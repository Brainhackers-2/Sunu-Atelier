<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Favorite;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getCart(): ?Cart
    {
        $user = Auth::user();
        return $user
            ? Cart::where('user_id', $user->id)->with(['items.product.images', 'items.variant', 'promoCode'])->first()
            : Cart::where('session_id', Session::getId())->with(['items.product.images', 'items.variant', 'promoCode'])->first();
    }

    public function getOrCreateCart(): Cart
    {
        $user = Auth::user();
        if ($user) {
            return Cart::firstOrCreate(['user_id' => $user->id]);
        }

        return Cart::firstOrCreate(['session_id' => Session::getId()]);
    }

    public function itemCount(): int
    {
        $cart = $this->getCart();
        return $cart ? (int) $cart->items->sum('quantity') : 0;
    }

    public function addItem(int $variantId, int $quantity = 1): array
    {
        $variant = ProductVariant::with('product')->find($variantId);
        if (! $variant || ! $variant->is_active || ! $variant->product || ! $variant->product->is_active) {
            return ['ok' => false, 'message' => 'Cette pièce n’est plus disponible.'];
        }

        $product = $variant->product;
        $cart = $this->getOrCreateCart();
        $existing = $cart->items()->where('product_variant_id', $variant->id)->first();
        $newQty = ($existing?->quantity ?? 0) + max(1, $quantity);

        if ($product->availability_type !== 'sur_commande') {
            if ($variant->stock_quantity <= 0) {
                return ['ok' => false, 'message' => 'Rupture de stock pour cette variante.'];
            }
            if ($newQty > $variant->stock_quantity) {
                $newQty = $variant->stock_quantity;
            }
        }

        if ($existing) {
            $existing->update(['quantity' => $newQty]);
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'product_variant_id' => $variant->id,
                'quantity' => $newQty,
            ]);
        }

        return ['ok' => true, 'message' => "{$product->title} ajouté au panier."];
    }

    public function updateQuantity(int $cartItemId, int $quantity): void
    {
        $cart = $this->getCart();
        if (! $cart) {
            return;
        }
        $item = $cart->items()->with('variant.product')->find($cartItemId);
        if (! $item) {
            return;
        }

        if ($quantity <= 0) {
            $item->delete();
            return;
        }

        if ($item->variant?->product?->availability_type !== 'sur_commande') {
            $quantity = min($quantity, max(1, $item->variant->stock_quantity));
        }
        $item->update(['quantity' => $quantity]);
    }

    public function removeItem(int $cartItemId): void
    {
        $cart = $this->getCart();
        $cart?->items()->where('id', $cartItemId)->delete();
    }

    public function clearCart(): void
    {
        $cart = $this->getCart();
        if ($cart) {
            $cart->items()->delete();
            $cart->update(['promo_code_id' => null]);
        }
    }

    public function mergeGuestSessionToUser(string $guestSessionId, User $user): void
    {
        $guestCart = Cart::where('session_id', $guestSessionId)->with('items')->first();
        if ($guestCart) {
            $userCart = Cart::firstOrCreate(['user_id' => $user->id]);

            foreach ($guestCart->items as $guestItem) {
                $variant = ProductVariant::with('product')->find($guestItem->product_variant_id);
                if (! $variant || ! $variant->product || ! $variant->product->is_active) {
                    continue;
                }

                $existing = $userCart->items()
                    ->where('product_variant_id', $guestItem->product_variant_id)
                    ->first();

                $desiredQty = ($existing?->quantity ?? 0) + $guestItem->quantity;
                if ($variant->product->availability_type !== 'sur_commande') {
                    $desiredQty = min($desiredQty, max(1, $variant->stock_quantity));
                }

                if ($existing) {
                    $existing->update(['quantity' => $desiredQty]);
                } else {
                    $userCart->items()->create([
                        'product_id' => $guestItem->product_id,
                        'product_variant_id' => $guestItem->product_variant_id,
                        'quantity' => $desiredQty,
                    ]);
                }
            }

            $guestCart->delete();
        }

        $guestFavs = Favorite::where('session_id', $guestSessionId)->get();
        foreach ($guestFavs as $fav) {
            Favorite::firstOrCreate([
                'user_id' => $user->id,
                'product_id' => $fav->product_id,
            ]);
            $fav->delete();
        }
    }
}
