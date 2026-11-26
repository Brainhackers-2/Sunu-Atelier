<?php

namespace App\Livewire\Checkout;

use App\Models\PromoCode;
use App\Models\Setting;
use App\Services\CartService;
use Livewire\Component;

class CartPage extends Component
{
    public string $promoInput = '';
    public string $promoMessage = '';
    public bool $promoError = false;

    public function increment(int $itemId, int $qty, CartService $cartService): void
    {
        $cartService->updateQuantity($itemId, $qty + 1);
        $this->dispatch('cartUpdated');
    }

    public function decrement(int $itemId, int $qty, CartService $cartService): void
    {
        $cartService->updateQuantity($itemId, $qty - 1);
        $this->dispatch('cartUpdated');
    }

    public function remove(int $itemId, CartService $cartService): void
    {
        $cartService->removeItem($itemId);
        $this->dispatch('cartUpdated');
    }

    public function applyPromo(CartService $cartService): void
    {
        $cart = $cartService->getCart();
        if (! $cart || $cart->items->isEmpty()) {
            return;
        }

        $code = strtoupper(trim($this->promoInput));
        $promo = PromoCode::where('code', $code)->first();
        $subtotal = $cart->items->sum(fn ($i) => ($i->product?->price_public ?? 0) * $i->quantity);

        if (! $promo || ! $promo->isValidForAmount($subtotal)) {
            $this->promoError = true;
            $this->promoMessage = 'Code promo invalide, expiré ou montant minimum non atteint.';
            return;
        }

        $cart->update(['promo_code_id' => $promo->id]);
        $this->promoError = false;
        $this->promoMessage = "Code {$promo->code} appliqué !";
        $this->promoInput = '';
    }

    public function removePromo(CartService $cartService): void
    {
        $cart = $cartService->getCart();
        $cart?->update(['promo_code_id' => null]);
        $this->promoMessage = '';
        $this->promoError = false;
    }

    public function render(CartService $cartService)
    {
        $cart = $cartService->getCart();
        $items = $cart?->items ?? collect();
        $subtotal = $items->sum(fn ($i) => ($i->product?->price_public ?? 0) * $i->quantity);
        $discount = $cart?->promoCode ? $cart->promoCode->calculateDiscount($subtotal) : 0;
        $whatsappNumber = preg_replace('/\D+/', '', Setting::getValue('whatsapp_number', '221770000000'));

        return view('livewire.checkout.cart-page', [
            'cart' => $cart,
            'items' => $items,
            'subtotal' => $subtotal,
            'discount' => $discount,
            'total' => max(0, $subtotal - $discount),
            'whatsappNumber' => $whatsappNumber,
        ]);
    }
}
