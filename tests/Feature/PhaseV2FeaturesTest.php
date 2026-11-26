<?php

namespace Tests\Feature;

use App\Livewire\Delivery\CourierScan;
use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class PhaseV2FeaturesTest extends TestCase
{
    use RefreshDatabase;

    public function test_gift_guide_and_pro_pages_load(): void
    {
        $this->seed();
        $this->get('/guide-cadeau')->assertStatus(200)->assertSee('Guide Cadeau');
        $this->get('/pro/inscription')->assertStatus(200)->assertSee('Devenir Revendeur');

        $pro = User::where('role', 'pro')->first();
        $this->actingAs($pro)->get('/pro')->assertStatus(200)->assertSee('Catalogue Tarifs de Gros');
    }

    public function test_courier_can_validate_delivery_via_scan_and_double_scan_is_blocked(): void
    {
        $this->seed();
        $courier = User::where('role', 'livreur')->first();
        $order = Order::first();
        $order->update(['status' => 'en_cours_de_livraison', 'payment_status' => 'en_attente']);

        // Sans case encaissement -> erreur
        Livewire::actingAs($courier)
            ->test(CourierScan::class, ['order' => $order])
            ->call('validateDelivery')
            ->assertHasErrors('cashCollected');

        // Avec case encaissement -> validée + payée
        Livewire::actingAs($courier)
            ->test(CourierScan::class, ['order' => $order])
            ->set('cashCollected', true)
            ->call('validateDelivery');

        $this->assertSame('livree', $order->fresh()->status);
        $this->assertSame('paye', $order->fresh()->payment_status);

        // Double scan bloqué
        Livewire::actingAs($courier)
            ->test(CourierScan::class, ['order' => $order->fresh()])
            ->call('validateDelivery')
            ->assertSet('feedback', 'Cette commande a déjà été validée comme livrée.');
    }

    public function test_admin_can_download_route_sheet_pdf(): void
    {
        $this->seed();
        $admin = User::where('role', 'admin')->first();

        $res = $this->actingAs($admin)->get('/admin/logistique/feuille-de-route.pdf');
        $res->assertStatus(200);
        $res->assertHeader('content-type', 'application/pdf');
    }
}
