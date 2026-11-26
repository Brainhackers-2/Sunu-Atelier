<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class CartBadge extends Component
{
    public int $count = 0;

    protected $listeners = ['cartUpdated' => 'refresh'];

    public function mount(): void
    {
        $this->refresh();
    }

    public function refresh(): void
    {
        // Sera enrichi Phase 4 avec CartService
        $this->count = 0;
    }

    public function render()
    {
        return view('livewire.layout.cart-badge');
    }
}
