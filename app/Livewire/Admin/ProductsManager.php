<?php

namespace App\Livewire\Admin;

use App\Models\Artisan;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ProductsManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $search = '';
    public bool $showForm = false;
    public ?int $editingId = null;

    public string $title = '';
    public string $sku = '';
    public ?int $category_id = null;
    public ?int $artisan_id = null;
    public string $availability_type = 'en_stock';
    public int $price_public = 15000;
    public ?int $price_pro = 10000;
    public int $stock_quantity = 10;
    public string $short_description = '';
    public bool $is_bestseller = false;
    public bool $is_new = true;
    public bool $is_active = true;
    public $photo = null;

    public function openCreate(): void
    {
        $this->reset(['editingId', 'title', 'sku', 'short_description', 'photo']);
        $this->category_id = Category::value('id');
        $this->artisan_id = Artisan::value('id');
        $this->availability_type = 'en_stock';
        $this->price_public = 15000;
        $this->price_pro = 10000;
        $this->stock_quantity = 10;
        $this->is_bestseller = false;
        $this->is_new = true;
        $this->is_active = true;
        $this->showForm = true;
    }

    public function edit(int $id): void
    {
        $p = Product::with('variants')->findOrFail($id);
        $this->editingId = $p->id;
        $this->title = $p->title;
        $this->sku = $p->sku;
        $this->category_id = $p->category_id;
        $this->artisan_id = $p->artisan_id;
        $this->availability_type = $p->availability_type;
        $this->price_public = $p->price_public;
        $this->price_pro = $p->price_pro;
        $this->stock_quantity = (int) ($p->variants->first()?->stock_quantity ?? 0);
        $this->short_description = (string) $p->short_description;
        $this->is_bestseller = $p->is_bestseller;
        $this->is_new = $p->is_new;
        $this->is_active = $p->is_active;
        $this->photo = null;
        $this->showForm = true;
    }

    public function save(): void
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'sku' => 'required|string|max:60|unique:products,sku,' . $this->editingId,
            'category_id' => 'required|exists:categories,id',
            'artisan_id' => 'nullable|exists:artisans,id',
            'availability_type' => 'required|in:en_stock,piece_unique,sur_commande',
            'price_public' => 'required|integer|min:100',
            'price_pro' => 'nullable|integer|min:100',
            'stock_quantity' => 'required|integer|min:0',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'category_id' => $this->category_id,
            'artisan_id' => $this->artisan_id,
            'title' => $this->title,
            'slug' => Str::slug($this->title) . ($this->editingId ? '' : '-' . Str::random(4)),
            'sku' => strtoupper(trim($this->sku)),
            'availability_type' => $this->availability_type,
            'price_public' => $this->price_public,
            'price_pro' => $this->price_pro,
            'short_description' => $this->short_description,
            'is_bestseller' => $this->is_bestseller,
            'is_new' => $this->is_new,
            'is_active' => $this->is_active,
        ];

        if ($this->editingId) {
            $product = Product::findOrFail($this->editingId);
            $product->update($data);
            $variant = $product->variants()->first();
            if ($variant) {
                $variant->update(['stock_quantity' => $this->stock_quantity]);
            }
        } else {
            $product = Product::create($data);
            $product->variants()->create([
                'size' => 'Standard',
                'stock_quantity' => $this->availability_type === 'piece_unique' ? 1 : $this->stock_quantity,
                'is_active' => true,
            ]);
        }

        if ($this->photo) {
            $path = $this->photo->store('products', 'public');
            ProductImage::create([
                'product_id' => $product->id,
                'path' => 'storage/' . $path,
                'alt_text' => $product->title,
                'sort_order' => 0,
                'is_primary' => true,
            ]);
        }

        $this->showForm = false;
    }

    public function delete(int $id): void
    {
        Product::where('id', $id)->delete();
    }

    public function render()
    {
        $products = Product::query()
            ->with(['category', 'artisan', 'variants'])
            ->when(trim($this->search) !== '', fn ($q) => $q->where('title', 'like', '%' . trim($this->search) . '%'))
            ->latest()
            ->paginate(12);

        return view('livewire.admin.products-manager', [
            'products' => $products,
            'categories' => Category::orderBy('sort_order')->get(),
            'artisans' => Artisan::orderBy('name')->get(),
        ]);
    }
}
