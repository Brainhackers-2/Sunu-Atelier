<?php

namespace App\Livewire\Shop;

use App\Models\Product;
use App\Models\Setting;
use Livewire\Component;

class ProductDetail extends Component
{
    public Product $product;
    public ?int $selectedVariantId = null;
    public int $quantity = 1;

    public function mount(Product $product): void
    {
        $this->product = $product->load([
            'category', 'artisan', 'technique', 'materials',
            'variants' => fn ($q) => $q->where('is_active', true),
            'images',
            'reviews' => fn ($q) => $q->where('is_approved', true)->with('user')->latest(),
        ]);

        $firstAvailable = $this->product->variants->first(fn ($v) => $v->stock_quantity > 0)
            ?? $this->product->variants->first();
        $this->selectedVariantId = $firstAvailable?->id;
    }

    public function incrementQty(): void
    {
        $variant = $this->product->variants->firstWhere('id', $this->selectedVariantId);
        if ($this->product->availability_type === 'piece_unique') {
            $this->quantity = 1;
            return;
        }
        if ($this->product->availability_type === 'en_stock' && $variant) {
            $this->quantity = min($this->quantity + 1, max(1, $variant->stock_quantity));
            return;
        }
        $this->quantity++;
    }

    public function decrementQty(): void
    {
        $this->quantity = max(1, $this->quantity - 1);
    }

    public function addToCart(): void
    {
        if (! $this->selectedVariantId) {
            return;
        }
        $this->dispatch('addToCart', variantId: $this->selectedVariantId, quantity: $this->quantity);
    }

    public function render()
    {
        $selectedVariant = $this->product->variants->firstWhere('id', $this->selectedVariantId);
        $whatsappNumber = preg_replace('/\D+/', '', Setting::getValue('whatsapp_number', '221770000000'));

        $related = Product::query()
            ->where('is_active', true)
            ->where('category_id', $this->product->category_id)
            ->where('id', '!=', $this->product->id)
            ->with(['category', 'artisan', 'variants' => fn ($q) => $q->where('is_active', true), 'images'])
            ->limit(4)
            ->get();

        $avgRating = round((float) ($this->product->reviews->avg('rating') ?? 5.0), 1);

        return view('livewire.shop.product-detail', [
            'selectedVariant' => $selectedVariant,
            'whatsappNumber' => $whatsappNumber,
            'related' => $related,
            'avgRating' => $avgRating,
        ]);
    }
}
