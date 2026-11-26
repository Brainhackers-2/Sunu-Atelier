<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderCounter;
use App\Models\OrderEvent;
use App\Models\ProductVariant;
use App\Models\PromoCode;
use App\Models\ShippingRate;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class OrderService
{
    public function __construct(private CartService $cartService) {}

    public function placeOrder(Cart $cart, array $data): Order
    {
        $cart->load(['items.product', 'items.variant', 'promoCode']);
        if ($cart->items->isEmpty()) {
            throw new RuntimeException('Votre panier est vide.');
        }

        return DB::transaction(function () use ($cart, $data) {
            $subtotal = 0;

            // 1. Verrouillage des variantes et vérification stricte du stock
            foreach ($cart->items as $item) {
                $variant = ProductVariant::where('id', $item->product_variant_id)
                    ->lockForUpdate()
                    ->with('product')
                    ->first();

                if (! $variant || ! $variant->product || ! $variant->product->is_active) {
                    throw new RuntimeException("Le produit « {$item->product?->title} » n'est plus disponible.");
                }

                if ($variant->product->availability_type !== 'sur_commande') {
                    if ($variant->stock_quantity < $item->quantity) {
                        throw new RuntimeException("Stock insuffisant pour « {$variant->product->title} ».");
                    }
                    $variant->decrement('stock_quantity', $item->quantity);

                    StockMovement::create([
                        'product_variant_id' => $variant->id,
                        'user_id' => Auth::id(),
                        'type' => 'vente',
                        'quantity_delta' => -$item->quantity,
                        'reason' => 'Commande client',
                        'created_at' => now(),
                    ]);
                }

                $subtotal += $variant->product->price_public * $item->quantity;
            }

            // 2. Code promo
            $discount = 0;
            $promo = $cart->promoCode;
            if ($promo && $promo->isValidForAmount($subtotal)) {
                $discount = $promo->calculateDiscount($subtotal);
                $promo->increment('used_count');
            }

            // 3. Frais de livraison recalculés côté serveur
            $shipping = 0;
            if (! empty($data['delivery_zone_id'])) {
                $rate = ShippingRate::where('delivery_zone_id', $data['delivery_zone_id'])
                    ->where('is_active', true)
                    ->first();
                if ($rate) {
                    $shipping = $rate->flat_rate;
                    if ($rate->free_threshold && $subtotal >= $rate->free_threshold) {
                        $shipping = 0;
                    }
                }
            }

            $total = max(0, $subtotal - $discount + $shipping);

            // 4. Compteur mensuel SA-AAMM-NNNN avec verrouillage
            $ym = now()->format('ym');
            $counter = OrderCounter::where('year_month', $ym)->lockForUpdate()->first();
            if (! $counter) {
                $counter = OrderCounter::create(['year_month' => $ym, 'last_sequence' => 0]);
            }
            $counter->increment('last_sequence');
            $orderNumber = sprintf('SA-%s-%04d', $ym, $counter->last_sequence);

            // 5. Statut de paiement simulé
            $paymentMethod = $data['payment_method'];
            $paymentStatus = 'en_attente';
            if ($paymentMethod !== 'especes') {
                $paymentStatus = ($data['simulated_outcome'] ?? 'success') === 'success' ? 'paye' : 'echoue';
            }

            // 6. Création de la commande
            $order = Order::create([
                'order_number' => $orderNumber,
                'tracking_token' => bin2hex(random_bytes(16)),
                'user_id' => Auth::id(),
                'promo_code_id' => $discount > 0 ? $promo?->id : null,
                'delivery_zone_id' => $data['delivery_zone_id'] ?? null,
                'civility' => $data['civility'] ?? null,
                'customer_name' => $data['customer_name'],
                'customer_phone' => $data['customer_phone'],
                'customer_email' => $data['customer_email'] ?? null,
                'delivery_mode' => $data['delivery_mode'],
                'delivery_country' => $data['delivery_country'] ?? 'Sénégal',
                'delivery_city' => $data['delivery_city'] ?? null,
                'delivery_address' => $data['delivery_address'] ?? null,
                'postal_code' => $data['postal_code'] ?? null,
                'gps_landmark' => $data['gps_landmark'] ?? null,
                'delivery_slot' => $data['delivery_slot'] ?? null,
                'subtotal' => $subtotal,
                'discount_amount' => $discount,
                'shipping_amount' => $shipping,
                'total_amount' => $total,
                'payment_method' => $paymentMethod,
                'payment_status' => $paymentStatus,
                'is_simulated_payment' => true,
                'status' => 'nouvelle',
            ]);

            foreach ($cart->items as $item) {
                $order->items()->create([
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'product_title' => $item->product->title,
                    'variant_label' => $item->variant?->displayLabel(),
                    'sku' => $item->product->sku,
                    'unit_price' => $item->product->price_public,
                    'quantity' => $item->quantity,
                    'line_total' => $item->product->price_public * $item->quantity,
                ]);
            }

            OrderEvent::create([
                'order_id' => $order->id,
                'user_id' => Auth::id(),
                'event_type' => 'order_created',
                'status_from' => null,
                'status_to' => 'nouvelle',
                'note' => "Commande créée ({$paymentMethod} – {$paymentStatus}).",
                'created_at' => now(),
            ]);

            $this->cartService->clearCart();

            return $order;
        });
    }
}
