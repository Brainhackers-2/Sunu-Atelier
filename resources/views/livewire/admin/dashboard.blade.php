<div class="space-y-6">
    {{-- KPIs --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach ([
            ['CA du jour', number_format($todaySales, 0, ',', ' ') . ' FCFA', 'bg-foret text-ivoire'],
            ['CA du mois', number_format($monthSales, 0, ',', ' ') . ' FCFA', 'bg-white text-ebene'],
            ['Total commandes', $ordersCount, 'bg-white text-ebene'],
            ['Panier moyen', number_format($avgBasket, 0, ',', ' ') . ' FCFA', 'bg-white text-ebene'],
        ] as [$label, $val, $cls])
            <div class="rounded-2xl border border-ebene/10 p-5 {{ $cls }}">
                <p class="text-xs opacity-75 uppercase tracking-wider font-semibold">{{ $label }}</p>
                <p class="text-2xl font-bold mt-2">{{ $val }}</p>
            </div>
        @endforeach
    </div>

    {{-- Alertes + Graphique --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <div class="lg:col-span-7 bg-white rounded-2xl border border-ebene/10 p-5">
            <h2 class="font-bold text-ebene mb-4">Ventes sur les 30 derniers jours (FCFA)</h2>
            <canvas id="adminSalesChart" height="140"></canvas>
        </div>

        <div class="lg:col-span-5 bg-white rounded-2xl border border-ebene/10 p-5 space-y-4">
            <h2 class="font-bold text-ebene">Alertes opérationnelles</h2>
            <div class="p-3 rounded-xl bg-or/20 text-ebene text-sm font-medium">
                <strong>{{ $pendingOrdersCount }}</strong> nouvelle(s) commande(s) en attente de confirmation.
            </div>
            <div>
                <p class="text-xs font-bold uppercase text-ebene/50 mb-2">Stock critique ({{ $lowStockVariants->count() }})</p>
                <ul class="space-y-1.5 text-xs">
                    @forelse ($lowStockVariants as $v)
                        <li class="flex justify-between p-2 rounded-lg bg-erreur/10 text-erreur">
                            <span>{{ $v->product?->title }} ({{ $v->displayLabel() }})</span>
                            <strong>{{ $v->stock_quantity }} restant(s)</strong>
                        </li>
                    @empty
                        <li class="text-ebene/60">Aucune alerte de stock critique.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>

    {{-- 10 dernières commandes --}}
    <div class="bg-white rounded-2xl border border-ebene/10 p-5 overflow-x-auto">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-bold text-ebene">10 dernières commandes</h2>
            <a href="{{ route('admin.commandes') }}" class="text-sm text-terre font-semibold hover:underline">Tout gérer</a>
        </div>
        <table class="w-full text-sm text-left">
            <thead class="text-xs uppercase text-ebene/50 border-b border-ebene/10">
                <tr>
                    <th class="py-2 pr-4">N°</th>
                    <th class="py-2 pr-4">Client</th>
                    <th class="py-2 pr-4">Total</th>
                    <th class="py-2 pr-4">Paiement</th>
                    <th class="py-2">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ebene/10">
                @foreach ($recentOrders as $order)
                    <tr>
                        <td class="py-2.5 pr-4 font-bold">{{ $order->order_number }}</td>
                        <td class="py-2.5 pr-4">{{ $order->customer_name }}</td>
                        <td class="py-2.5 pr-4 font-semibold">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td>
                        <td class="py-2.5 pr-4 text-xs">{{ $order->payment_status }}</td>
                        <td class="py-2.5"><span class="px-2.5 py-1 rounded-full bg-foret/10 text-foret text-xs font-semibold">{{ $order->status }}</span></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const ctx = document.getElementById('adminSalesChart');
            if (!ctx || !window.Chart) return;
            new window.Chart(ctx, {
                type: 'line',
                data: {
                    labels: @js($chartLabels),
                    datasets: [{
                        label: 'CA (FCFA)',
                        data: @js($chartValues),
                        borderColor: '#125B3E',
                        backgroundColor: 'rgba(18, 91, 62, 0.12)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: { responsive: true, plugins: { legend: { display: false } } }
            });
        });
    </script>
</div>
