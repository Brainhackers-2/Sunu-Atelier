<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase5CatalogTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_seven_sections_and_hides_wholesale_price(): void
    {
        $this->seed();

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee("L'Art des Mains d'Afrique");
        $response->assertSee('Nos Univers Artisanaux');
        $response->assertSee('Nos Créations Coup de Cœur');
        $response->assertSee('Espace Professionnels');
        $response->assertDontSee('29 000 FCFA'); // price_pro never exposed
    }

    public function test_boutique_filters_by_category_and_search(): void
    {
        $this->seed();

        $this->get('/boutique?cat=maroquinerie')
            ->assertStatus(200)
            ->assertSee('Sac Cabas Ndar en Cuir Camel')
            ->assertDontSee('Pagne Tissé Manjak Royal');

        $this->get('/boutique?q=Manjak')
            ->assertStatus(200)
            ->assertSee('Pagne Tissé Manjak Royal');
    }

    public function test_product_detail_page_displays_product_and_availability(): void
    {
        $this->seed();

        $product = Product::where('availability_type', 'piece_unique')->first();

        $this->get('/produit/' . $product->slug)
            ->assertStatus(200)
            ->assertSee($product->title)
            ->assertSee($product->sku)
            ->assertSee('Pièce unique disponible');
    }

    public function test_cart_service_respects_piece_unique_stock_limit(): void
    {
        $this->seed();

        $uniqueProduct = Product::where('availability_type', 'piece_unique')->first();
        $variant = $uniqueProduct->variants()->first();

        $service = app(CartService::class);
        $res = $service->addItem($variant->id, 5);

        $this->assertTrue($res['ok']);
        $this->assertSame(1, $service->itemCount());
    }
}
