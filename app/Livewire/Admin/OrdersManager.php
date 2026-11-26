<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderEvent;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class OrdersManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';
    public string $paymentFilter = '';
    public string $deliveryFilter = '';
    public ?int $selectedOrderId = null;
    public string $carrierTracking = '';

    public function selectOrder(int $id): void
    {
        $order = Order::findOrFail($id);
        $this->selectedOrderId = $order->id;
        $this->carrierTracking = (string) $order->carrier_tracking_number;
    }

    public function updateStatus(int $orderId, string $newStatus): void
    {
        $allowed = ['nouvelle', 'confirmee', 'en_preparation', 'livraison_programmee', 'prete_au_retrait', 'expediee', 'en_cours_de_livraison', 'livree', 'annulee'];
        if (! in_array($newStatus, $allowed, true)) {
            return;
        }

        $order = Order::findOrFail($orderId);
        $oldStatus = $order->status;
        if ($oldStatus === $newStatus) {
            return;
        }

        $order->update(['status' => $newStatus]);

        OrderEvent::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'event_type' => 'status_changed',
            'status_from' => $oldStatus,
            'status_to' => $newStatus,
            'note' => "Statut modifié par l'administrateur.",
            'created_at' => now(),
        ]);
    }

    public function saveCarrierTracking(): void
    {
        if (! $this->selectedOrderId) {
            return;
        }
        Order::where('id', $this->selectedOrderId)->update([
            'carrier_tracking_number' => trim($this->carrierTracking) ?: null,
        ]);
    }

    public function render()
    {
        $orders = Order::query()
            ->when(trim($this->search) !== '', function ($q) {
                $t = trim($this->search);
                $q->where('order_number', 'like', "%{$t}%")->orWhere('customer_name', 'like', "%{$t}%");
            })
            ->when($this->statusFilter !== '', fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->paymentFilter !== '', fn ($q) => $q->where('payment_method', $this->paymentFilter))
            ->when($this->deliveryFilter !== '', fn ($q) => $q->where('delivery_mode', $this->deliveryFilter))
            ->latest()
            ->paginate(12);

        $selectedOrder = $this->selectedOrderId ? Order::with(['items', 'events'])->find($this->selectedOrderId) : null;

        return view('livewire.admin.orders-manager', compact('orders', 'selectedOrder'));
    }
}
