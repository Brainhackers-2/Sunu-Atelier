<?php

namespace App\Livewire\Admin;

use App\Models\PromoCode;
use Livewire\Component;

class PromoCodesManager extends Component
{
    public string $code = '';
    public string $type = 'percentage';
    public int $value = 10;
    public int $min_order_amount = 0;
    public ?int $max_uses = null;

    public function createCode(): void
    {
        $this->validate([
            'code' => 'required|string|max:40|unique:promo_codes,code',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|integer|min:1',
            'min_order_amount' => 'required|integer|min:0',
        ]);

        PromoCode::create([
            'code' => strtoupper(trim($this->code)),
            'type' => $this->type,
            'value' => $this->value,
            'min_order_amount' => $this->min_order_amount,
            'max_uses' => $this->max_uses,
            'is_active' => true,
        ]);

        $this->reset(['code', 'max_uses']);
    }

    public function toggle(int $id): void
    {
        $p = PromoCode::findOrFail($id);
        $p->update(['is_active' => ! $p->is_active]);
    }

    public function render()
    {
        return view('livewire.admin.promo-codes-manager', [
            'codes' => PromoCode::latest()->get(),
        ]);
    }
}
