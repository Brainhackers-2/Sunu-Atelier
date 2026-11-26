<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ReportsManager extends Component
{
    public function render()
    {
        $byPayment = Order::where('status', '!=', 'annulee')
            ->select('payment_method', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('payment_method')
            ->get();

        $byDelivery = Order::where('status', '!=', 'annulee')
            ->select('delivery_mode', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('delivery_mode')
            ->get();

        $byCountry = Order::where('status', '!=', 'annulee')
            ->select('delivery_country', DB::raw('COUNT(*) as count'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('delivery_country')
            ->orderByDesc('total')
            ->get();

        return view('livewire.admin.reports-manager', compact('byPayment', 'byDelivery', 'byCountry'));
    }
}
