<?php

namespace App\Livewire\Admin;

use App\Models\ProductVariant;
use App\Models\StockMovement;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class StocksManager extends Component
{
    public function adjust(int $variantId, int $delta): void
    {
        $variant = ProductVariant::findOrFail($variantId);
        $newQty = max(0, $variant->stock_quantity + $delta);
        $actualDelta = $newQty - $variant->stock_quantity;
        $variant->update(['stock_quantity' => $newQty]);

        StockMovement::create([
            'product_variant_id' => $variant->id,
            'user_id' => Auth::id(),
            'type' => $actualDelta >= 0 ? 'production' : 'ajustement',
            'quantity_delta' => $actualDelta,
            'reason' => 'Ajustement manuel admin',
            'created_at' => now(),
        ]);
    }

    public function render()
    {
        return view('livewire.admin.stocks-manager', [
            'variants' => ProductVariant::with('product')->orderBy('stock_quantity')->get(),
            'movements' => StockMovement::with(['variant.product', 'user'])->latest('created_at')->limit(15)->get(),
        ]);
    }
}
