<?php

namespace App\Livewire\Layout;

use App\Services\CartService;
use Livewire\Component;

class CartDrawer extends Component
{
    public bool $open = false;

    protected $listeners = [
        'openCart' => 'openDrawer',
        'cartUpdated' => '$refresh',
        'addToCart' => 'handleAddToCart',
    ];

    public function openDrawer(): void
    {
        $this->open = true;
    }

    public function closeDrawer(): void
    {
        $this->open = false;
    }

    public function handleAddToCart(int $variantId, int $quantity = 1, CartService $cartService = null): void
    {
        $service = $cartService ?? app(CartService::class);
        $result = $service->addItem($variantId, $quantity);

        $this->dispatch('cartUpdated');
        $this->dispatch('toast', id: uniqid(), type: $result['ok'] ? 'success' : 'error', message: $result['message']);
        if ($result['ok']) {
            $this->open = true;
        }
    }

    public function increment(int $itemId, int $currentQty, CartService $cartService): void
    {
        $cartService->updateQuantity($itemId, $currentQty + 1);
        $this->dispatch('cartUpdated');
    }

    public function decrement(int $itemId, int $currentQty, CartService $cartService): void
    {
        $cartService->updateQuantity($itemId, $currentQty - 1);
        $this->dispatch('cartUpdated');
    }

    public function remove(int $itemId, CartService $cartService): void
    {
        $cartService->removeItem($itemId);
        $this->dispatch('cartUpdated');
    }

    public function render(CartService $cartService)
    {
        $cart = $cartService->getCart();
        $items = $cart?->items ?? collect();
        $subtotal = $items->sum(fn ($item) => ($item->product?->price_public ?? 0) * $item->quantity);

        return view('livewire.layout.cart-drawer', [
            'items' => $items,
            'subtotal' => $subtotal,
        ]);
    }
}
