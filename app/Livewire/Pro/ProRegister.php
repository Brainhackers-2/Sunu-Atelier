<?php

namespace App\Livewire\Pro;

use App\Models\ProProfile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class ProRegister extends Component
{
    public string $company_name = '';
    public string $ninea = '';
    public string $trade_register = '';
    public string $activity_type = 'boutique';
    public string $contact_name = '';
    public string $email = '';
    public string $whatsapp = '';
    public string $address = '';
    public string $estimated_monthly_volume = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $submitted = false;

    public function register(): void
    {
        $this->validate([
            'company_name' => 'required|string|max:255',
            'ninea' => 'nullable|string|max:60',
            'trade_register' => 'nullable|string|max:60',
            'activity_type' => 'required|in:boutique,hotel,decorateur,exportateur',
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'whatsapp' => 'required|string|max:30',
            'address' => 'required|string|max:500',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name' => $this->contact_name,
            'email' => $this->email,
            'phone' => $this->whatsapp,
            'role' => 'pro',
            'is_active' => true,
            'password' => Hash::make($this->password),
        ]);

        ProProfile::create([
            'user_id' => $user->id,
            'company_name' => $this->company_name,
            'ninea' => $this->ninea,
            'trade_register' => $this->trade_register,
            'activity_type' => $this->activity_type,
            'contact_name' => $this->contact_name,
            'whatsapp' => $this->whatsapp,
            'address' => $this->address,
            'estimated_monthly_volume' => $this->estimated_monthly_volume,
            'discount_rate' => 25,
            'status' => 'en_attente',
        ]);

        Auth::login($user);
        $this->submitted = true;
    }

    public function render()
    {
        return view('livewire.pro.pro-register');
    }
}
