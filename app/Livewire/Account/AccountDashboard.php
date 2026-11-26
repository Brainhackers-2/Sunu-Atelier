<?php

namespace App\Livewire\Account;

use App\Models\Address;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AccountDashboard extends Component
{
    public string $name = '';
    public string $phone = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    public string $addr_label = 'Domicile';
    public string $addr_city = 'Dakar';
    public string $addr_line = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->phone = $user->phone ?? '';
    }

    public function updateProfile(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:30',
        ]);
        Auth::user()->update(['name' => $this->name, 'phone' => $this->phone]);
        $this->dispatch('toast', id: uniqid(), type: 'success', message: 'Profil mis à jour.');
    }

    public function updatePassword(): void
    {
        $this->validate([
            'new_password' => 'required|min:8|confirmed',
        ]);
        Auth::user()->update(['password' => Hash::make($this->new_password)]);
        $this->reset(['new_password', 'new_password_confirmation']);
        $this->dispatch('toast', id: uniqid(), type: 'success', message: 'Mot de passe modifié.');
    }

    public function addAddress(): void
    {
        $this->validate([
            'addr_label' => 'required|string|max:60',
            'addr_city' => 'required|string|max:100',
            'addr_line' => 'required|string|max:300',
        ]);

        $user = Auth::user();
        $user->addresses()->create([
            'label' => $this->addr_label,
            'full_name' => $user->name,
            'phone' => $user->phone ?? '+221 77 000 00 00',
            'country' => 'Sénégal',
            'city' => $this->addr_city,
            'address_line' => $this->addr_line,
            'is_default' => $user->addresses()->count() === 0,
        ]);

        $this->reset('addr_line');
        $this->dispatch('toast', id: uniqid(), type: 'success', message: 'Adresse ajoutée.');
    }

    public function deleteAddress(int $id): void
    {
        Auth::user()->addresses()->where('id', $id)->delete();
    }

    public function render()
    {
        $user = Auth::user();
        return view('livewire.account.account-dashboard', [
            'orders' => $user->orders()->latest()->get(),
            'addresses' => $user->addresses()->get(),
        ]);
    }
}
