<x-app-layout>
    <x-slot:title>Confirmation {{ $order->order_number }}</x-slot:title>

    @php
        $scanUrl = route('scan', $order->tracking_token);
        $suiviUrl = route('suivi.token', $order->tracking_token);
        $waText = "Bonjour Sunu Atelier, voici ma commande {$order->order_number} d'un montant de " . number_format($order->total_amount, 0, ',', ' ') . " FCFA. Suivi : {$suiviUrl}";
    @endphp

    <section class="max-w-3xl mx-auto px-4 py-12 space-y-8" x-data="{ copied: '' }">
        {{-- 1. Bannière de félicitations --}}
        <div class="bg-foret text-ivoire rounded-3xl p-8 text-center space-y-3 shadow-lg">
            <div class="w-14 h-14 rounded-full bg-or text-ebene flex items-center justify-center mx-auto">
                <i data-lucide="check" class="size-7" aria-hidden="true"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold">Merci {{ $order->customer_name }} !</h1>
            <p class="text-sm text-ivoire/85">Votre commande <strong>{{ $order->order_number }}</strong> a bien été enregistrée.</p>
        </div>

        {{-- 2. Instructions paiement simulé si Wave / OM --}}
        @if (in_array($order->payment_method, ['wave_simule', 'orange_money_simule'], true))
            <div class="bg-or/20 border border-or rounded-2xl p-5 text-sm text-ebene space-y-1">
                <p class="font-bold">Instructions Mobile Money (Simulation)</p>
                <p>Montant : <strong>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong> · Référence : <strong>{{ $order->order_number }}</strong></p>
                <p class="text-xs text-ebene/75">Statut enregistré : {{ strtoupper($order->payment_status) }} (mode démonstration).</p>
            </div>
        @endif

        {{-- 3. Carte du reçu + QR Code --}}
        <div class="bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8 shadow-sm grid grid-cols-1 md:grid-cols-12 gap-6 items-center">
            <div class="md:col-span-7 space-y-3">
                <div class="flex items-center gap-2">
                    <span class="text-xs uppercase tracking-wider text-ebene/50 font-bold">Numéro de commande</span>
                    <button type="button"
                            x-on:click="navigator.clipboard.writeText('{{ $order->order_number }}'); copied = 'num'"
                            class="text-xs text-terre font-semibold hover:underline">
                        Copier
                    </button>
                </div>
                <p class="text-2xl font-bold text-ebene">{{ $order->order_number }}</p>
                <p class="text-sm text-ebene/70">Date : {{ $order->created_at->format('d/m/Y à H:i') }}</p>
                <p class="text-sm text-ebene/70">Total : <strong class="text-foret">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong></p>

                <div class="pt-2 flex flex-wrap gap-2">
                    <a href="{{ route('commande.recu', $order->tracking_token) }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-xl bg-terre text-white text-sm font-semibold btn-touch hover:bg-terre/90">
                        <i data-lucide="file-down" class="size-4" aria-hidden="true"></i>
                        Télécharger le reçu PDF
                    </a>
                    <a href="{{ $suiviUrl }}"
                       class="inline-flex items-center gap-2 px-5 py-3 rounded-xl border border-foret text-foret text-sm font-semibold btn-touch hover:bg-foret/5">
                        Suivre ma commande
                    </a>
                </div>
            </div>

            <div class="md:col-span-5 text-center space-y-3 p-4 rounded-2xl bg-ivoire border border-ebene/10">
                <img src="{{ $qrDataUri }}" alt="QR Code de la commande {{ $order->order_number }}" class="w-44 h-44 mx-auto rounded-xl bg-white p-2">
                <p class="text-xs text-ebene/70">À présenter au livreur lors de la remise du colis</p>
                <div class="flex justify-center gap-2 text-xs">
                    <button type="button" x-on:click="navigator.clipboard.writeText('{{ $scanUrl }}'); copied = 'qr'"
                            class="px-3 py-1.5 rounded-lg border border-ebene/20 hover:bg-ebene/5 font-medium">
                        Copier lien QR
                    </button>
                    <a href="{{ $qrDataUri }}" download="QR-{{ $order->order_number }}.png"
                       class="px-3 py-1.5 rounded-lg border border-ebene/20 hover:bg-ebene/5 font-medium">
                        Télécharger QR
                    </a>
                </div>
                <p x-show="copied" class="text-xs text-foret font-semibold" style="display: none">Copié dans le presse-papiers !</p>
            </div>
        </div>

        {{-- 4. Bouton WhatsApp 1-clic --}}
        <div class="text-center">
            <a href="https://wa.me/{{ $whatsappNumber }}?text={{ rawurlencode($waText) }}" target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl bg-whatsapp text-ebene font-bold text-sm btn-touch hover:opacity-90">
                <i data-lucide="message-circle" class="size-4" aria-hidden="true"></i>
                Envoyer mon bon de commande sur WhatsApp
            </a>
        </div>
    </section>
</x-app-layout>
