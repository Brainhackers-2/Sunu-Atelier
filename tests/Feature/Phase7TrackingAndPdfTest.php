<?php

namespace Tests\Feature;

use App\Livewire\Tracking\OrderTracking;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class Phase7TrackingAndPdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_confirmation_and_scan_and_suivi_token_routes(): void
    {
        $this->seed();
        $order = Order::first();

        $this->get('/confirmation/' . $order->tracking_token)
            ->assertStatus(200)
            ->assertSee($order->order_number)
            ->assertSee('data:image/png;base64,');

        $this->get('/suivi/' . $order->tracking_token)
            ->assertStatus(200)
            ->assertSee($order->order_number);

        $this->get('/scan/' . $order->tracking_token)
            ->assertStatus(200)
            ->assertSee($order->order_number);

        $this->get('/confirmation/invalid-token')->assertStatus(404);
    }

    public function test_receipt_pdf_downloads_for_valid_token_and_blocks_invalid(): void
    {
        $this->seed();
        $order = Order::first();

        $response = $this->get('/commande/' . $order->tracking_token . '/recu.pdf');
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');

        $this->get('/commande/not-a-valid-token/recu.pdf')->assertStatus(404);
    }

    public function test_tracking_form_uses_identical_error_and_rate_limits(): void
    {
        $this->seed();
        $order = Order::first();

        // Mauvais numéro
        $comp1 = Livewire::test(OrderTracking::class)
            ->set('orderNumber', 'SA-9999-9999')
            ->set('phone', $order->customer_phone)
            ->call('search');
        $err1 = $comp1->get('errorMessage');

        // Bon numéro, mauvais téléphone
        $comp2 = Livewire::test(OrderTracking::class)
            ->set('orderNumber', $order->order_number)
            ->set('phone', '+221 77 999 99 99')
            ->call('search');
        $err2 = $comp2->get('errorMessage');

        $this->assertSame($err1, $err2);
        $this->assertNotEmpty($err1);

        // 3 autres échecs pour atteindre 5/min/IP
        for ($i = 0; $i < 3; $i++) {
            Livewire::test(OrderTracking::class)
                ->set('orderNumber', 'SA-0000-0000')
                ->set('phone', '000000000')
                ->call('search');
        }

        // 6e tentative bloquée par rate limiter
        $blocked = Livewire::test(OrderTracking::class)
            ->set('orderNumber', $order->order_number)
            ->set('phone', $order->customer_phone)
            ->call('search');
        $this->assertStringContainsString('Trop de tentatives', $blocked->get('errorMessage'));
    }
}
