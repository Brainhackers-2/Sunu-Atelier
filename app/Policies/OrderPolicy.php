<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    public function view(User $user, Order $order): bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        if ($user->isCourier() && $order->courier_id === $user->id) {
            return true;
        }
        return $order->user_id === $user->id;
    }

    public function validateDelivery(User $user, Order $order): bool
    {
        return $user->isAdmin() || $user->isCourier();
    }

    public function manage(User $user): bool
    {
        return $user->isAdmin();
    }
}
