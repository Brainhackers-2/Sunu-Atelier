<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\DeliveryZone;
use App\Models\Order;
use App\Models\Product;
use App\Models\PromoCode;
use App\Services\OrderService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use RuntimeException;
use Tests\TestCase;

class Phase6CheckoutAndOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_cart_and_checkout_pages_load(): void
    {
        $this->seed();
        $this->get('/panier')->assertStatus(200);
        $this->get('/commande')->assertStatus(200);
    }

    public function test_order_service_generates_monthly_counter_token_and_clears_cart(): void
    {
        $this->seed();

        $product = Product::where('availability_type', 'en_stock')->first();
        $variant = $product->variants()->first();
        $initialStock = $variant->stock_quantity;
        $zone = DeliveryZone::where('type', 'local_senegal')->first();
        $promo = PromoCode::where('code', 'BIENVENUE10')->first();

        $cart = Cart::create(['session_id' => 'test-sess-1', 'promo_code_id' => $promo->id]);
        $cart->items()->create([
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 1,
        ]);

        $order = app(OrderService::class)->placeOrder($cart, [
            'civility' => 'M.',
            'customer_name' => 'Ibrahima Diallo',
            'customer_phone' => '+221 77 222 33 44',
            'delivery_mode' => 'domicile',
            'delivery_zone_id' => $zone->id,
            'delivery_city' => 'Dakar',
            'delivery_address' => 'Plateau',
            'payment_method' => 'wave_simule',
            'simulated_outcome' => 'success',
        ]);

        $this->assertMatchesRegularExpression('/^SA-\d{4}-\d{4}$/', $order->order_number);
        $this->assertSame(32, strlen($order->tracking_token));
        $this->assertSame('paye', $order->payment_status);
        $this->assertTrue($order->is_simulated_payment);
        $this->assertSame($initialStock - 1, $variant->fresh()->stock_quantity);
        $this->assertDatabaseHas('order_events', ['order_id' => $order->id, 'event_type' => 'order_created']);
    }

    public function test_piece_unique_cannot_be_sold_twice(): void
    {
        $this->seed();

        $unique = Product::where('availability_type', 'piece_unique')->first();
        $variant = $unique->variants()->first();
        $zone = DeliveryZone::where('type', 'pickup')->first();

        $cart1 = Cart::create(['session_id' => 'buyer-1']);
        $cart1->items()->create(['product_id' => $unique->id, 'product_variant_id' => $variant->id, 'quantity' => 1]);

        $cart2 = Cart::create(['session_id' => 'buyer-2']);
        $cart2->items()->create(['product_id' => $unique->id, 'product_variant_id' => $variant->id, 'quantity' => 1]);

        $service = app(OrderService::class);
        $order1 = $service->placeOrder($cart1, [
            'customer_name' => 'Acheteur 1',
            'customer_phone' => '+221 77 111 11 11',
            'delivery_mode' => 'retrait',
            'delivery_zone_id' => $zone->id,
            'payment_method' => 'especes',
        ]);
        $this->assertNotNull($order1->id);

        $this->expectException(RuntimeException::class);
        $service->placeOrder($cart2, [
            'customer_name' => 'Acheteur 2',
            'customer_phone' => '+221 77 222 22 22',
            'delivery_mode' => 'retrait',
            'delivery_zone_id' => $zone->id,
            'payment_method' => 'especes',
        ]);
    }
}
