<?php

namespace App\Livewire\Tracking;

use App\Models\Order;
use App\Models\Setting;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class OrderTracking extends Component
{
    public string $orderNumber = '';
    public string $phone = '';
    public ?Order $order = null;
    public string $errorMessage = '';

    public function mount(?string $token = null): void
    {
        if ($token) {
            if (! preg_match('/^[a-f0-9]{32}$/', $token)) {
                abort(404);
            }
            $this->order = Order::where('tracking_token', $token)
                ->with(['items', 'events', 'courier'])
                ->firstOrFail();
        }
    }

    public function search(): void
    {
        $this->errorMessage = '';
        $this->order = null;

        $throttleKey = 'tracking:' . request()->ip();
        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            $this->errorMessage = "Trop de tentatives. Veuillez réessayer dans {$seconds} secondes.";
            return;
        }

        $this->validate([
            'orderNumber' => 'required|string|max:30',
            'phone' => 'required|string|max:30',
        ]);

        $num = strtoupper(trim($this->orderNumber));
        $inputDigits = preg_replace('/\D+/', '', $this->phone);

        $candidate = Order::where('order_number', $num)
            ->with(['items', 'events', 'courier'])
            ->first();

        $matched = false;
        if ($candidate && $inputDigits !== '') {
            $dbDigits = preg_replace('/\D+/', '', $candidate->customer_phone);
            $matched = $dbDigits === $inputDigits
                || str_ends_with($dbDigits, $inputDigits)
                || str_ends_with($inputDigits, $dbDigits);
        }

        if (! $matched) {
            RateLimiter::hit($throttleKey, 60);
            // Message identique quel que soit le champ erroné
            $this->errorMessage = 'Aucune commande trouvée avec ces informations. Vérifiez votre numéro de commande et votre téléphone.';
            return;
        }

        RateLimiter::clear($throttleKey);
        $this->order = $candidate;
    }

    public function render()
    {
        $whatsappNumber = preg_replace('/\D+/', '', Setting::getValue('whatsapp_number', '221770000000'));
        return view('livewire.tracking.order-tracking', compact('whatsappNumber'));
    }
}
