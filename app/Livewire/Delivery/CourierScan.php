<?php

namespace App\Livewire\Delivery;

use App\Models\Order;
use App\Models\OrderEvent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CourierScan extends Component
{
    public Order $order;
    public bool $cashCollected = false;
    public string $feedback = '';

    public function mount(Order $order): void
    {
        $this->order = $order->load(['items', 'events']);
    }

    public function validateDelivery(): void
    {
        $user = Auth::user();
        if (! $user || (! $user->isCourier() && ! $user->isAdmin())) {
            abort(403);
        }

        if ($this->order->status === 'livree') {
            $this->feedback = 'Cette commande a déjà été validée comme livrée.';
            return;
        }

        if ($this->order->payment_status !== 'paye' && ! $this->cashCollected) {
            $this->addError('cashCollected', 'Veuillez confirmer avoir encaissé le montant en espèces.');
            return;
        }

        $oldStatus = $this->order->status;
        $this->order->update([
            'status' => 'livree',
            'payment_status' => 'paye',
            'courier_id' => $this->order->courier_id ?? $user->id,
        ]);

        OrderEvent::create([
            'order_id' => $this->order->id,
            'user_id' => $user->id,
            'event_type' => 'delivery_validated',
            'status_from' => $oldStatus,
            'status_to' => 'livree',
            'note' => 'Livraison validée par scan QR.',
            'created_at' => now(),
        ]);

        $this->order->refresh();
        $this->feedback = 'Livraison validée avec succès !';
    }

    public function render()
    {
        return view('livewire.delivery.courier-scan');
    }
}
