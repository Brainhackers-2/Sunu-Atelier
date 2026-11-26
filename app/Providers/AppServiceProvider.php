<?php

namespace App\Providers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Policies\OrderPolicy;
use App\Policies\ProductPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Order::class, OrderPolicy::class);
        Gate::policy(Product::class, ProductPolicy::class);

        Gate::define('access-admin', fn (User $user) => $user->is_active && $user->isAdmin());
        Gate::define('access-pro', fn (User $user) => $user->is_active && ($user->isAdmin() || $user->isProApproved()));
        Gate::define('validate-delivery', fn (User $user) => $user->is_active && ($user->isAdmin() || $user->isCourier()));
    }
}
