<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    public function viewWholesalePrice(?User $user): bool
    {
        return $user !== null && ($user->isAdmin() || $user->isProApproved());
    }

    public function manage(User $user): bool
    {
        return $user->isAdmin();
    }

    public function review(User $user, Product $product): bool
    {
        return $user->orders()
            ->where('status', 'livree')
            ->whereHas('items', fn ($q) => $q->where('product_id', $product->id))
            ->exists();
    }
}
