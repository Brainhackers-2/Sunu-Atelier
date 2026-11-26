<x-app-layout>
    <x-slot:title>Mes factures Pro</x-slot:title>
    <section class="max-w-screen-xl mx-auto px-4 py-10 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-ebene">Mes Factures Commerciales (OHADA)</h1>
            <a href="{{ route('pro.index') }}" class="text-sm text-terre font-semibold hover:underline">← Retour Espace Pro</a>
        </div>

        @php
            $orders = auth()->check() ? auth()->user()->orders()->latest()->get() : collect();
        @endphp

        <div class="bg-white rounded-2xl border border-ebene/10 p-6 space-y-3">
            @forelse ($orders as $order)
                <div class="flex items-center justify-between py-3 border-b border-ebene/10 text-sm">
                    <div>
                        <p class="font-bold">FAC-{{ $order->order_number }}</p>
                        <p class="text-xs text-ebene/60">{{ $order->created_at->format('d/m/Y') }} · {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</p>
                    </div>
                    <a href="{{ route('pro.facture.pdf', $order->tracking_token) }}" class="px-4 py-2 rounded-xl bg-foret text-ivoire text-xs font-semibold">
                        Télécharger PDF
                    </a>
                </div>
            @empty
                <p class="text-sm text-ebene/60">Aucune facture disponible pour le moment.</p>
            @endforelse
        </div>
    </section>
</x-app-layout>
