<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Favorite;
use App\Models\ProductVariant;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartService
{
    public function getOrCreateCart(): Cart
    {
        $user = Auth::user();
        if ($user) {
            return Cart::firstOrCreate(['user_id' => $user->id]);
        }

        $sessionId = Session::getId();
        return Cart::firstOrCreate(['session_id' => $sessionId]);
    }

    public function itemCount(): int
    {
        $user = Auth::user();
        $cart = $user
            ? Cart::where('user_id', $user->id)->first()
            : Cart::where('session_id', Session::getId())->first();

        return $cart ? (int) $cart->items()->sum('quantity') : 0;
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

        // Fusionner également les favoris de la session invité
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
