<?php

namespace App\Livewire\Layout;

use App\Services\CartService;
use Livewire\Component;

class CartBadge extends Component
{
    public int $count = 0;

    protected $listeners = ['cartUpdated' => 'refresh'];

    public function mount(CartService $cartService): void
    {
        $this->count = $cartService->itemCount();
    }

    public function refresh(CartService $cartService): void
    {
        $this->count = $cartService->itemCount();
    }

    public function render()
    {
        return view('livewire.layout.cart-badge');
    }
}
