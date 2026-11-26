<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="font-bold text-ebene">Clients inscrits ({{ $clients->count() }})</h2>
        <a href="{{ route('admin.clients.csv') }}" class="px-5 py-2.5 rounded-xl bg-foret text-ivoire text-sm font-semibold btn-touch">
            Exporter CSV
        </a>
    </div>

    <div class="bg-white rounded-2xl border border-ebene/10 p-5 overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs uppercase text-ebene/50 border-b border-ebene/10">
                <tr>
                    <th class="py-2 pr-4">Nom</th>
                    <th class="py-2 pr-4">Email</th>
                    <th class="py-2 pr-4">WhatsApp</th>
                    <th class="py-2 pr-4">Commandes</th>
                    <th class="py-2">Total dépensé</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ebene/10">
                @foreach ($clients as $c)
                    <tr>
                        <td class="py-2.5 pr-4 font-semibold">{{ $c->name }}</td>
                        <td class="py-2.5 pr-4">{{ $c->email }}</td>
                        <td class="py-2.5 pr-4">{{ $c->phone ?? '—' }}</td>
                        <td class="py-2.5 pr-4">{{ $c->orders_count }}</td>
                        <td class="py-2.5 font-semibold">{{ number_format((int) $c->orders_sum_total_amount, 0, ',', ' ') }} FCFA</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
