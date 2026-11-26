<div class="max-w-3xl mx-auto px-4 py-10 space-y-8">
    @if (! $order)
        <div class="bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8 shadow-sm">
            <h1 class="text-2xl sm:text-3xl font-bold text-ebene mb-2">Suivi de commande</h1>
            <p class="text-sm text-ebene/65 mb-6">Saisissez votre numéro de commande et le numéro WhatsApp utilisé lors de l'achat.</p>

            @if ($errorMessage)
                <div class="mb-4 p-4 rounded-xl bg-erreur/10 text-erreur text-sm font-medium" role="alert">
                    {{ $errorMessage }}
                </div>
            @endif

            <form wire:submit="search" class="space-y-4">
                <div>
                    <label for="track-num" class="block text-sm font-medium mb-1">Numéro de commande</label>
                    <input id="track-num" type="text" wire:model="orderNumber" placeholder="Ex. SA-2611-0001"
                           class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm uppercase">
                    @error('orderNumber')<p class="text-xs text-erreur mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="track-phone" class="block text-sm font-medium mb-1">Téléphone / WhatsApp</label>
                    <input id="track-phone" type="tel" wire:model="phone" placeholder="+221 77 000 00 00"
                           class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
                    @error('phone')<p class="text-xs text-erreur mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full py-3.5 px-6 rounded-xl bg-terre text-white font-semibold text-sm btn-touch hover:bg-terre/90">
                    Suivre mon colis
                </button>
            </form>
        </div>
    @else
        @php
            $steps = [
                'nouvelle' => 'Nouvelle',
                'confirmee' => 'Confirmée',
                'en_preparation' => 'En préparation',
                'dispatch' => $order->delivery_mode === 'retrait' ? 'Prête au retrait' : ($order->delivery_mode === 'international' ? 'Expédiée' : 'Livraison programmée'),
                'en_cours_de_livraison' => 'En livraison',
                'livree' => 'Livrée ✓',
            ];
            $statusMap = [
                'nouvelle' => 0,
                'confirmee' => 1,
                'en_preparation' => 2,
                'livraison_programmee' => 3,
                'prete_au_retrait' => 3,
                'expediee' => 3,
                'en_cours_de_livraison' => 4,
                'livree' => 5,
            ];
            $currentIdx = $statusMap[$order->status] ?? 0;
        @endphp

        <div class="bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8 shadow-sm space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 border-b border-ebene/10 pb-4">
                <div>
                    <p class="text-xs uppercase tracking-wider text-ebene/50 font-bold">Commande</p>
                    <h1 class="text-2xl font-bold text-ebene">{{ $order->order_number }}</h1>
                    <p class="text-xs text-ebene/60">{{ $order->customer_name }} · {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <span class="px-3 py-1.5 rounded-full text-xs font-bold
                    {{ $order->payment_status === 'paye' ? 'bg-foret text-ivoire' : 'bg-or text-ebene' }}">
                    {{ $order->payment_status === 'paye' ? 'Payée' : 'À régler à la livraison' }}
                </span>
            </div>

            {{-- Frise 6 statuts --}}
            @if ($order->status === 'annulee')
                <div class="p-4 rounded-2xl bg-erreur/10 text-erreur font-semibold text-sm">
                    Cette commande a été annulée.
                </div>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-6 gap-2">
                    @foreach (array_values($steps) as $idx => $label)
                        <div class="p-3 rounded-xl text-center text-xs font-semibold border
                            {{ $idx <= $currentIdx ? 'bg-foret text-ivoire border-foret' : 'bg-ivoire text-ebene/50 border-ebene/10' }}">
                            {{ $label }}
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Détails livraison --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-ivoire/70 rounded-2xl p-4 text-sm">
                <div>
                    <p class="text-xs font-bold uppercase text-ebene/50 mb-1">Livraison</p>
                    <p>{{ ucfirst($order->delivery_mode) }} – {{ $order->delivery_city }}, {{ $order->delivery_country }}</p>
                    @if ($order->delivery_address)
                        <p class="text-ebene/75">{{ $order->delivery_address }}</p>
                    @endif
                    @if ($order->delivery_slot)
                        <p class="text-xs text-ebene/60 mt-1">Créneau : {{ $order->delivery_slot }}</p>
                    @endif
                </div>
                <div>
                    <p class="text-xs font-bold uppercase text-ebene/50 mb-1">Suivi &amp; Assistance</p>
                    @if ($order->carrier_tracking_number)
                        <p>Transporteur : <strong>{{ $order->carrier_tracking_number }}</strong></p>
                    @endif
                    @if ($order->courier)
                        <p>Livreur : {{ $order->courier->name }}</p>
                    @endif
                    <p class="font-bold text-foret mt-1">Total : {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</p>
                </div>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('commande.recu', $order->tracking_token) }}"
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-terre text-white text-sm font-semibold btn-touch">
                    Télécharger le reçu PDF
                </a>
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ rawurlencode('Bonjour, je demande des nouvelles de ma commande ' . $order->order_number) }}"
                   target="_blank" rel="noopener noreferrer"
                   class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-whatsapp text-ebene text-sm font-bold btn-touch">
                    Assistance WhatsApp
                </a>
            </div>
        </div>
    @endif
</div>
