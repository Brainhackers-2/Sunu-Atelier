<?php

namespace App\Livewire\Pro;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProDashboard extends Component
{
    public function render()
    {
        $user = Auth::user();
        $profile = $user?->proProfile;
        $products = $user && $user->isProApproved()
            ? Product::where('is_active', true)->with('category')->get()
            : collect();

        return view('livewire.pro.pro-dashboard', compact('user', 'profile', 'products'));
    }
}
