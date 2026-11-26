<?php

namespace App\Livewire\Shop;

use App\Models\Category;
use App\Models\Material;
use App\Models\Product;
use App\Models\Technique;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class ProductCatalog extends Component
{
    use WithPagination;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url(as: 'cat')]
    public string $category = '';

    #[Url(as: 'matiere')]
    public string $material = '';

    #[Url(as: 'technique')]
    public string $technique = '';

    #[Url(as: 'min')]
    public ?int $priceMin = null;

    #[Url(as: 'max')]
    public ?int $priceMax = null;

    #[Url(as: 'sort')]
    public string $sort = 'popular';

    public function updated($property): void
    {
        if ($property !== 'page') {
            $this->resetPage();
        }
    }

    public function resetFilters(): void
    {
        $this->reset(['search', 'category', 'material', 'technique', 'priceMin', 'priceMax', 'sort']);
        $this->sort = 'popular';
        $this->resetPage();
    }

    public function render()
    {
        $query = Product::query()
            ->where('is_active', true)
            ->with(['category', 'artisan', 'variants' => fn ($q) => $q->where('is_active', true), 'images'])
            ->withAvg(['reviews as approved_reviews_avg' => fn ($q) => $q->where('is_approved', true)], 'rating');

        if (trim($this->search) !== '') {
            $term = trim($this->search);
            $query->where(function ($q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                    ->orWhere('short_description', 'like', "%{$term}%")
                    ->orWhereHas('artisan', fn ($aq) => $aq->where('name', 'like', "%{$term}%"))
                    ->orWhereHas('materials', fn ($mq) => $mq->where('name', 'like', "%{$term}%"));
            });
        }

        if ($this->category !== '') {
            $query->whereHas('category', fn ($q) => $q->where('slug', $this->category));
        }

        if ($this->material !== '') {
            $query->whereHas('materials', fn ($q) => $q->where('slug', $this->material));
        }

        if ($this->technique !== '') {
            $query->whereHas('technique', fn ($q) => $q->where('slug', $this->technique));
        }

        if ($this->priceMin !== null) {
            $query->where('price_public', '>=', $this->priceMin);
        }

        if ($this->priceMax !== null && $this->priceMax > 0) {
            $query->where('price_public', '<=', $this->priceMax);
        }

        match ($this->sort) {
            'price_asc' => $query->orderBy('price_public', 'asc'),
            'price_desc' => $query->orderBy('price_public', 'desc'),
            'newest' => $query->orderByDesc('is_new')->orderByDesc('created_at'),
            default => $query->orderByDesc('is_bestseller')->orderByDesc('created_at'),
        };

        return view('livewire.shop.product-catalog', [
            'products' => $query->paginate(9),
            'categories' => Category::where('is_active', true)->withCount(['products' => fn ($q) => $q->where('is_active', true)])->orderBy('sort_order')->get(),
            'materials' => Material::orderBy('name')->get(),
            'techniques' => Technique::orderBy('name')->get(),
        ]);
    }
}
