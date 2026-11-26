<?php

namespace App\Livewire\Admin;

use App\Models\ProProfile;
use Livewire\Component;

class ProAccountsManager extends Component
{
    public function approve(int $id, int $rate = 30): void
    {
        $profile = ProProfile::findOrFail($id);
        $profile->update([
            'status' => 'valide',
            'discount_rate' => max(25, min(45, $rate)),
        ]);
    }

    public function reject(int $id): void
    {
        ProProfile::where('id', $id)->update(['status' => 'refuse']);
    }

    public function render()
    {
        return view('livewire.admin.pro-accounts-manager', [
            'profiles' => ProProfile::with('user')->latest()->get(),
        ]);
    }
}
