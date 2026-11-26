<?php

namespace Tests\Feature;

use App\Livewire\Admin\OrdersManager;
use App\Livewire\Community\ReviewsSection;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class Phase8AdminAndPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_v1_recommended_pages_return_200(): void
    {
        $this->seed();

        foreach (['/favoris', '/notre-histoire', '/avis', '/contact', '/cgv', '/mentions-legales'] as $url) {
            $this->get($url)->assertStatus(200);
        }
    }

    public function test_admin_pages_are_accessible_by_admin_and_forbidden_for_others(): void
    {
        $this->seed();

        $admin = User::where('role', 'admin')->first();
        $client = User::where('role', 'client')->first();
        $pro = User::where('role', 'pro')->first();

        $adminRoutes = ['/admin', '/admin/produits', '/admin/categories', '/admin/commandes', '/admin/clients', '/admin/stocks', '/admin/codes-promo', '/admin/rapports', '/admin/reglages'];

        foreach ($adminRoutes as $url) {
            $this->actingAs($admin)->get($url)->assertStatus(200);
            $this->actingAs($client)->get($url)->assertStatus(403);
            $this->actingAs($pro)->get($url)->assertStatus(403);
        }

        $csv = $this->actingAs($admin)->get('/admin/clients/export.csv');
        $csv->assertStatus(200);
        $this->assertStringContainsString('text/csv', (string) $csv->headers->get('content-type'));
    }

    public function test_admin_can_update_order_status_with_audit_event(): void
    {
        $this->seed();
        $admin = User::where('role', 'admin')->first();
        $order = Order::first();

        Livewire::actingAs($admin)
            ->test(OrdersManager::class)
            ->call('updateStatus', $order->id, 'en_preparation');

        $this->assertSame('en_preparation', $order->fresh()->status);
        $this->assertDatabaseHas('order_events', [
            'order_id' => $order->id,
            'status_to' => 'en_preparation',
        ]);
    }

    public function test_only_delivered_buyer_can_submit_review(): void
    {
        $this->seed();
        $client = User::where('role', 'client')->first();
        $pro = User::where('role', 'pro')->first();
        $boughtProduct = Order::first()->items()->first()->product;
        $otherProduct = Product::where('id', '!=', $boughtProduct->id)->first();

        // Pro sans commande livrée -> bloqué
        Livewire::actingAs($pro)
            ->test(ReviewsSection::class)
            ->set('product_id', $boughtProduct->id)
            ->set('rating', 5)
            ->set('comment', 'Très beau produit artisanal.')
            ->call('submitReview')
            ->assertSet('feedback', 'Seuls les clients ayant reçu ce produit (commande livrée) peuvent laisser un avis.');

        // Client avec commande livrée sur un autre produit -> accepté en modération
        Livewire::actingAs($client)
            ->test(ReviewsSection::class)
            ->set('product_id', $boughtProduct->id)
            ->set('rating', 5)
            ->set('comment', 'Superbe qualité, je recommande vivement !')
            ->call('submitReview');

        $this->assertDatabaseHas('reviews', [
            'user_id' => $client->id,
            'product_id' => $boughtProduct->id,
            'is_approved' => false,
        ]);
    }
}
