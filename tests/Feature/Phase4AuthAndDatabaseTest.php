<?php

namespace Tests\Feature;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase4AuthAndDatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_expected_catalog_and_roles(): void
    {
        $this->seed();

        $this->assertDatabaseCount('categories', 4);
        $this->assertDatabaseCount('products', 14);
        $this->assertDatabaseCount('artisans', 5);
        $this->assertDatabaseHas('users', ['email' => 'client@sunuatelier.sn', 'role' => 'client']);
        $this->assertDatabaseHas('users', ['email' => 'pro@sunuatelier.sn', 'role' => 'pro']);
        $this->assertDatabaseHas('users', ['email' => 'livreur@sunuatelier.sn', 'role' => 'livreur']);
        $this->assertDatabaseHas('users', ['email' => 'admin@sunuatelier.sn', 'role' => 'admin']);
    }

    public function test_wholesale_price_is_hidden_from_public_serialization_and_clients(): void
    {
        $this->seed();

        $product = Product::first();
        $this->assertArrayNotHasKey('price_pro', $product->toArray());

        $client = User::where('role', 'client')->first();
        $pro = User::where('role', 'pro')->first();
        $admin = User::where('role', 'admin')->first();

        $this->assertFalse($client->can('viewWholesalePrice', $product));
        $this->assertTrue($pro->can('viewWholesalePrice', $product));
        $this->assertTrue($admin->can('viewWholesalePrice', $product));
    }

    public function test_non_admin_is_blocked_from_admin_routes(): void
    {
        $this->seed();

        $this->get('/admin')->assertRedirect('/admin/login');

        $client = User::where('role', 'client')->first();
        $this->actingAs($client)->get('/admin')->assertStatus(403);
    }

    public function test_login_rate_limiter_blocks_after_five_failed_attempts(): void
    {
        $this->seed();

        for ($i = 0; $i < 5; $i++) {
            $this->post('/connexion', [
                'email' => 'client@sunuatelier.sn',
                'password' => 'wrong-password',
            ])->assertSessionHasErrors('email');
        }

        $response = $this->post('/connexion', [
            'email' => 'client@sunuatelier.sn',
            'password' => 'SunuAtelier2026!',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_guest_cart_merges_into_user_cart_on_service_merge(): void
    {
        $this->seed();

        $client = User::where('role', 'client')->first();
        $product = Product::where('availability_type', 'en_stock')->first();
        $variant = $product->variants()->first();

        $guestCart = Cart::create(['session_id' => 'guest-session-123']);
        $guestCart->items()->create([
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => 2,
        ]);

        app(CartService::class)->mergeGuestSessionToUser('guest-session-123', $client);

        $this->assertDatabaseMissing('carts', ['session_id' => 'guest-session-123']);
        $this->assertDatabaseHas('cart_items', [
            'product_variant_id' => $variant->id,
            'quantity' => 2,
        ]);
    }
}
