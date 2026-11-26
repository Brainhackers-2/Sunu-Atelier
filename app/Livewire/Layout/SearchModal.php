<?php

namespace App\Livewire\Layout;

use App\Models\Product;
use Livewire\Component;

class SearchModal extends Component
{
    public string $query = '';

    public function render()
    {
        $results = collect();
        $trimmed = trim($this->query);

        if (mb_strlen($trimmed) >= 2) {
            $results = Product::query()
                ->where('is_active', true)
                ->where(function ($q) use ($trimmed) {
                    $q->where('title', 'like', "%{$trimmed}%")
                        ->orWhere('short_description', 'like', "%{$trimmed}%")
                        ->orWhereHas('artisan', fn ($aq) => $aq->where('name', 'like', "%{$trimmed}%"))
                        ->orWhereHas('materials', fn ($mq) => $mq->where('name', 'like', "%{$trimmed}%"));
                })
                ->with(['category', 'artisan'])
                ->limit(6)
                ->get();
        }

        return view('livewire.layout.search-modal', compact('results'));
    }
}
