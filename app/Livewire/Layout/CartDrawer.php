<?php

namespace App\Livewire\Layout;

use Livewire\Component;

class CartDrawer extends Component
{
    public bool $open = false;

    protected $listeners = ['openCart' => 'openDrawer', 'cartUpdated' => '$refresh'];

    public function openDrawer(): void
    {
        $this->open = true;
    }

    public function closeDrawer(): void
    {
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.layout.cart-drawer');
    }
}
