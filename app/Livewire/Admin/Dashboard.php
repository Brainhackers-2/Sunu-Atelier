<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\ProductVariant;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $todaySales = (int) Order::whereDate('created_at', today())->where('status', '!=', 'annulee')->sum('total_amount');
        $monthSales = (int) Order::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->where('status', '!=', 'annulee')->sum('total_amount');
        $ordersCount = Order::count();
        $avgBasket = $ordersCount > 0 ? (int) Order::where('status', '!=', 'annulee')->avg('total_amount') : 0;

        $pendingOrdersCount = Order::where('status', 'nouvelle')->count();
        $lowStockVariants = ProductVariant::with('product')
            ->whereHas('product', fn ($q) => $q->where('availability_type', '!=', 'sur_commande'))
            ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->limit(8)
            ->get();

        $recentOrders = Order::latest()->limit(10)->get();

        // Ventes sur 30 jours pour Chart.js
        $daily = Order::query()
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('SUM(total_amount) as total'))
            ->where('created_at', '>=', now()->subDays(30))
            ->where('status', '!=', 'annulee')
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        return view('livewire.admin.dashboard', [
            'todaySales' => $todaySales,
            'monthSales' => $monthSales,
            'ordersCount' => $ordersCount,
            'avgBasket' => $avgBasket,
            'pendingOrdersCount' => $pendingOrdersCount,
            'lowStockVariants' => $lowStockVariants,
            'recentOrders' => $recentOrders,
            'chartLabels' => $daily->pluck('day')->toArray(),
            'chartValues' => $daily->pluck('total')->map(fn ($v) => (int) $v)->toArray(),
        ]);
    }
}
