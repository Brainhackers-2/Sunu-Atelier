<div class="space-y-6">
    <div class="flex flex-wrap gap-3">
        <input type="search" wire:model.live.debounce.300ms="search" placeholder="N° commande ou client…"
               class="px-3 py-2.5 rounded-xl border border-ebene/20 bg-white text-sm w-60">
        <select wire:model.live="statusFilter" class="px-3 py-2.5 rounded-xl border border-ebene/20 bg-white text-sm">
            <option value="">Tous les statuts</option>
            @foreach (['nouvelle', 'confirmee', 'en_preparation', 'livraison_programmee', 'prete_au_retrait', 'expediee', 'en_cours_de_livraison', 'livree', 'annulee'] as $st)
                <option value="{{ $st }}">{{ ucfirst(str_replace('_', ' ', $st)) }}</option>
            @endforeach
        </select>
        <select wire:model.live="paymentFilter" class="px-3 py-2.5 rounded-xl border border-ebene/20 bg-white text-sm">
            <option value="">Tous paiements</option>
            <option value="carte_simulee">Carte simulée</option>
            <option value="wave_simule">Wave</option>
            <option value="orange_money_simule">Orange Money</option>
            <option value="especes">Espèces</option>
        </select>
        <select wire:model.live="deliveryFilter" class="px-3 py-2.5 rounded-xl border border-ebene/20 bg-white text-sm">
            <option value="">Toutes livraisons</option>
            <option value="domicile">Domicile</option>
            <option value="retrait">Retrait</option>
            <option value="international">International</option>
        </select>
    </div>

    @if ($selectedOrder)
        <div class="bg-white rounded-2xl border border-foret/30 p-5 space-y-4">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="font-bold text-lg text-ebene">{{ $selectedOrder->order_number }} – {{ $selectedOrder->customer_name }}</h2>
                    <p class="text-xs text-ebene/65">{{ $selectedOrder->customer_phone }} · {{ $selectedOrder->delivery_city }}, {{ $selectedOrder->delivery_address }}</p>
                </div>
                <button wire:click="$set('selectedOrderId', null)" class="text-sm text-ebene/60">Fermer ✕</button>
            </div>

            <div class="flex flex-wrap gap-2">
                @foreach (['confirmee' => 'Confirmer', 'en_preparation' => 'En préparation', 'livraison_programmee' => 'Programmer livraison', 'expediee' => 'Expédier', 'livree' => 'Marquer livrée', 'annulee' => 'Annuler'] as $st => $btn)
                    <button wire:click="updateStatus({{ $selectedOrder->id }}, '{{ $st }}')"
                            class="px-3 py-1.5 rounded-lg text-xs font-semibold border {{ $selectedOrder->status === $st ? 'bg-foret text-ivoire border-foret' : 'border-ebene/20 hover:bg-ebene/5' }}">
                        {{ $btn }}
                    </button>
                @endforeach
                <a href="{{ route('commande.recu', $selectedOrder->tracking_token) }}" class="px-3 py-1.5 rounded-lg bg-terre text-white text-xs font-semibold">Reçu PDF</a>
            </div>

            <form wire:submit="saveCarrierTracking" class="flex gap-2 items-center text-sm">
                <input type="text" wire:model="carrierTracking" placeholder="N° suivi transporteur (international)"
                       class="px-3 py-2 rounded-xl border border-ebene/20 w-72">
                <button type="submit" class="px-4 py-2 rounded-xl bg-ebene text-ivoire text-xs font-semibold">Enregistrer suivi</button>
            </form>
        </div>
    @endif

    <div class="bg-white rounded-2xl border border-ebene/10 p-5 overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs uppercase text-ebene/50 border-b border-ebene/10">
                <tr>
                    <th class="py-2 pr-4">N°</th>
                    <th class="py-2 pr-4">Client</th>
                    <th class="py-2 pr-4">Total</th>
                    <th class="py-2 pr-4">Mode</th>
                    <th class="py-2 pr-4">Statut</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ebene/10">
                @foreach ($orders as $order)
                    <tr>
                        <td class="py-2.5 pr-4 font-bold">{{ $order->order_number }}</td>
                        <td class="py-2.5 pr-4">{{ $order->customer_name }}<span class="block text-xs text-ebene/50">{{ $order->customer_phone }}</span></td>
                        <td class="py-2.5 pr-4 font-semibold">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
                        <td class="py-2.5 pr-4 text-xs">{{ $order->delivery_mode }} · {{ $order->payment_method }}</td>
                        <td class="py-2.5 pr-4"><span class="px-2.5 py-1 rounded-full bg-foret/10 text-foret text-xs font-semibold">{{ $order->status }}</span></td>
                        <td class="py-2.5">
                            <button wire:click="selectOrder({{ $order->id }})" class="text-terre font-semibold hover:underline">Gérer</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $orders->links() }}</div>
    </div>
</div>
