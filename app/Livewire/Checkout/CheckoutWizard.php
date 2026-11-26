<?php

namespace App\Livewire\Checkout;

use App\Models\DeliveryZone;
use App\Models\ShippingRate;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Throwable;

class CheckoutWizard extends Component
{
    public int $step = 1;

    // Étape 1 – Coordonnées
    public string $civility = 'Mme';
    public string $customer_name = '';
    public string $customer_phone = '';
    public string $customer_email = '';

    // Étape 2 – Livraison
    public string $delivery_mode = 'domicile';
    public ?int $delivery_zone_id = null;
    public string $delivery_country = 'Sénégal';
    public string $delivery_city = 'Dakar';
    public string $delivery_address = '';
    public string $postal_code = '';
    public string $gps_landmark = '';
    public string $delivery_slot = 'Après-midi (14h-18h)';

    // Étape 3 – Paiement simulé
    public string $payment_method = 'wave_simule';
    public string $simulated_outcome = 'success';

    public string $errorMessage = '';

    public function mount(): void
    {
        $user = Auth::user();
        if ($user) {
            $this->customer_name = $user->name;
            $this->customer_phone = $user->phone ?? '';
            $this->customer_email = $user->email;

            $addr = $user->addresses()->where('is_default', true)->first() ?? $user->addresses()->first();
            if ($addr) {
                $this->delivery_country = $addr->country;
                $this->delivery_city = $addr->city;
                $this->delivery_address = $addr->address_line;
                $this->gps_landmark = $addr->gps_hint ?? '';
            }
        }

        $this->selectDefaultZone();
    }

    public function updatedDeliveryMode(): void
    {
        $this->selectDefaultZone();
    }

    protected function selectDefaultZone(): void
    {
        $type = match ($this->delivery_mode) {
            'retrait' => 'pickup',
            'international' => 'international',
            default => 'local_senegal',
        };
        $this->delivery_zone_id = DeliveryZone::where('type', $type)->where('is_active', true)->value('id');
        if ($this->delivery_mode !== 'international') {
            $this->delivery_country = 'Sénégal';
        } elseif ($this->delivery_country === 'Sénégal') {
            $this->delivery_country = 'France';
        }
    }

    public function nextStep(): void
    {
        $this->errorMessage = '';

        if ($this->step === 1) {
            $this->validate([
                'civility' => 'required|in:Mme,M.',
                'customer_name' => 'required|string|max:255',
                'customer_phone' => 'required|string|max:30',
                'customer_email' => 'nullable|email|max:255',
            ]);
        } elseif ($this->step === 2) {
            $rules = [
                'delivery_mode' => 'required|in:domicile,retrait,international',
                'delivery_zone_id' => 'required|exists:delivery_zones,id',
            ];
            if ($this->delivery_mode !== 'retrait') {
                $rules['delivery_address'] = 'required|string|max:500';
                $rules['delivery_city'] = 'required|string|max:100';
            }
            if ($this->delivery_mode === 'international') {
                $rules['delivery_country'] = 'required|string|max:100';
            }
            $this->validate($rules);
        } elseif ($this->step === 3) {
            $this->validate([
                'payment_method' => 'required|in:carte_simulee,wave_simule,orange_money_simule,especes',
                'simulated_outcome' => 'required|in:success,failed',
            ]);
        }

        $this->step = min(4, $this->step + 1);
    }

    public function previousStep(): void
    {
        $this->errorMessage = '';
        $this->step = max(1, $this->step - 1);
    }

    public function confirmOrder(CartService $cartService, OrderService $orderService)
    {
        $this->errorMessage = '';
        $cart = $cartService->getCart();

        if (! $cart || $cart->items->isEmpty()) {
            $this->errorMessage = 'Votre panier est vide.';
            return null;
        }

        try {
            $order = $orderService->placeOrder($cart, [
                'civility' => $this->civility,
                'customer_name' => $this->customer_name,
                'customer_phone' => $this->customer_phone,
                'customer_email' => $this->customer_email,
                'delivery_mode' => $this->delivery_mode,
                'delivery_zone_id' => $this->delivery_zone_id,
                'delivery_country' => $this->delivery_country,
                'delivery_city' => $this->delivery_city,
                'delivery_address' => $this->delivery_address,
                'postal_code' => $this->postal_code,
                'gps_landmark' => $this->gps_landmark,
                'delivery_slot' => $this->delivery_slot,
                'payment_method' => $this->payment_method,
                'simulated_outcome' => $this->simulated_outcome,
            ]);

            $this->dispatch('cartUpdated');
            return $this->redirectRoute('confirmation', ['token' => $order->tracking_token]);
        } catch (Throwable $e) {
            $this->errorMessage = $e->getMessage();
            return null;
        }
    }

    public function render(CartService $cartService)
    {
        $cart = $cartService->getCart();
        $items = $cart?->items ?? collect();
        $subtotal = $items->sum(fn ($i) => ($i->product?->price_public ?? 0) * $i->quantity);
        $discount = $cart?->promoCode ? $cart->promoCode->calculateDiscount($subtotal) : 0;

        $rate = $this->delivery_zone_id
            ? ShippingRate::where('delivery_zone_id', $this->delivery_zone_id)->where('is_active', true)->first()
            : null;
        $shipping = $rate ? $rate->flat_rate : 0;

        $zoneType = match ($this->delivery_mode) {
            'retrait' => 'pickup',
            'international' => 'international',
            default => 'local_senegal',
        };
        $zones = DeliveryZone::where('type', $zoneType)->where('is_active', true)->with('rates')->get();

        return view('livewire.checkout.checkout-wizard', [
            'items' => $items,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping' => $shipping,
            'total' => max(0, $subtotal - $discount + $shipping),
            'zones' => $zones,
        ]);
    }
}
