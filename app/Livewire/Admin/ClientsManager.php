<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class ClientsManager extends Component
{
    public function render()
    {
        $clients = User::where('role', 'client')
            ->withCount('orders')
            ->withSum('orders', 'total_amount')
            ->latest()
            ->get();

        $guestOrders = Order::whereNull('user_id')->latest()->limit(20)->get();

        return view('livewire.admin.clients-manager', compact('clients', 'guestOrders'));
    }
}
