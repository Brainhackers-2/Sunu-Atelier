<div class="max-w-lg mx-auto px-4 py-8 space-y-6">
    <div class="bg-foret text-ivoire rounded-2xl p-5 flex items-center justify-between">
        <div>
            <span class="text-xs uppercase tracking-widest text-or font-bold">Scan Livraison</span>
            <h1 class="text-xl font-bold">{{ $order->order_number }}</h1>
        </div>
        <span class="px-3 py-1 rounded-full bg-ivoire/15 text-xs font-semibold">{{ strtoupper($order->status) }}</span>
    </div>

    <div class="bg-white rounded-2xl border border-ebene/10 p-5 space-y-3 text-sm">
        <p><strong>Destinataire :</strong> {{ $order->customer_name }}</p>
        <p>
            <strong>WhatsApp / Tél :</strong>
            <a href="tel:{{ preg_replace('/\s+/', '', $order->customer_phone) }}" class="text-terre font-semibold underline">{{ $order->customer_phone }}</a>
        </p>
        <p><strong>Adresse :</strong> {{ $order->delivery_city }}, {{ $order->delivery_address }}</p>
        @if ($order->gps_landmark)
            <p class="text-xs text-ebene/65">Repère : {{ $order->gps_landmark }}</p>
        @endif
    </div>

    <div class="bg-white rounded-2xl border border-ebene/10 p-5 space-y-4">
        @if ($order->payment_status === 'paye')
            <div class="p-3 rounded-xl bg-foret/10 text-foret font-bold text-sm text-center">
                Paiement déjà validé ✓
            </div>
        @else
            <div class="p-4 rounded-xl bg-or/20 text-ebene text-center">
                <p class="text-xs uppercase font-bold">Montant à encaisser</p>
                <p class="text-2xl font-bold mt-1">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</p>
            </div>
        @endif

        @if ($feedback)
            <div class="p-3 rounded-xl bg-foret text-ivoire text-sm font-semibold text-center">{{ $feedback }}</div>
        @endif

        @if ($order->status !== 'livree')
            @if ($order->payment_status !== 'paye')
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" wire:model="cashCollected" class="rounded text-foret">
                    <span>J'ai bien encaissé le montant en espèces</span>
                </label>
                @error('cashCollected')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
            @endif

            <button wire:click="validateDelivery" class="w-full py-3.5 rounded-xl bg-terre text-white font-bold text-sm btn-touch hover:bg-terre/90">
                Valider la livraison
            </button>
        @endif
    </div>
</div>
