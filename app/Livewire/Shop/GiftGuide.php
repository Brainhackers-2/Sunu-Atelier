<?php

namespace App\Livewire\Shop;

use App\Models\Product;
use Livewire\Component;

class GiftGuide extends Component
{
    public string $occasion = 'anniversaire';
    public int $maxBudget = 50000;
    public string $style = 'tous';

    public function render()
    {
        $query = Product::query()
            ->where('is_active', true)
            ->where('price_public', '<=', $this->maxBudget)
            ->with(['category', 'artisan', 'variants', 'images']);

        if ($this->style !== 'tous') {
            $query->whereHas('category', fn ($q) => $q->where('slug', $this->style));
        }

        return view('livewire.shop.gift-guide', [
            'suggestions' => $query->orderByDesc('is_bestseller')->limit(6)->get(),
        ]);
    }
}
