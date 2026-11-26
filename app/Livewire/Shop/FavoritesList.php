<?php

namespace App\Livewire\Shop;

use App\Models\Favorite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FavoritesList extends Component
{
    public function removeFavorite(int $productId): void
    {
        $query = Favorite::where('product_id', $productId);
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }
        $query->delete();
    }

    public function render()
    {
        $query = Favorite::with(['product.category', 'product.artisan', 'product.variants', 'product.images']);
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        } else {
            $query->where('session_id', Session::getId());
        }

        return view('livewire.shop.favorites-list', [
            'favorites' => $query->latest()->get(),
        ]);
    }
}
