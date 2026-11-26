<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Component;

class CategoriesManager extends Component
{
    public ?int $editingId = null;
    public string $name = '';
    public string $description = '';
    public int $sort_order = 1;
    public bool $is_active = true;

    public function edit(int $id): void
    {
        $c = Category::findOrFail($id);
        $this->editingId = $c->id;
        $this->name = $c->name;
        $this->description = (string) $c->description;
        $this->sort_order = $c->sort_order;
        $this->is_active = $c->is_active;
    }

    public function save(): void
    {
        $this->validate([
            'name' => 'required|string|max:120',
            'sort_order' => 'required|integer|min:0',
        ]);

        Category::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'slug' => Str::slug($this->name),
                'description' => $this->description,
                'sort_order' => $this->sort_order,
                'is_active' => $this->is_active,
            ]
        );

        $this->reset(['editingId', 'name', 'description']);
        $this->sort_order = 1;
        $this->is_active = true;
    }

    public function render()
    {
        return view('livewire.admin.categories-manager', [
            'categories' => Category::withCount('products')->orderBy('sort_order')->get(),
        ]);
    }
}
