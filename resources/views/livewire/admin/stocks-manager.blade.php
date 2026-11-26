<div class="space-y-6">
    <div class="bg-white rounded-2xl border border-ebene/10 p-5 overflow-x-auto">
        <h2 class="font-bold text-ebene mb-4">Niveaux de stock par variante</h2>
        <table class="w-full text-sm text-left">
            <thead class="text-xs uppercase text-ebene/50 border-b border-ebene/10">
                <tr>
                    <th class="py-2 pr-4">Produit</th>
                    <th class="py-2 pr-4">Variante</th>
                    <th class="py-2 pr-4">Type</th>
                    <th class="py-2 pr-4">Stock</th>
                    <th class="py-2">Ajustement</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ebene/10">
                @foreach ($variants as $v)
                    @php
                        $badge = $v->stock_quantity === 0 ? 'bg-erreur/10 text-erreur' : ($v->stock_quantity <= $v->low_stock_threshold ? 'bg-or/30 text-ebene' : 'bg-foret/10 text-foret');
                    @endphp
                    <tr>
                        <td class="py-2.5 pr-4 font-semibold">{{ $v->product?->title }}</td>
                        <td class="py-2.5 pr-4">{{ $v->displayLabel() }}</td>
                        <td class="py-2.5 pr-4 text-xs">{{ $v->product?->availability_type }}</td>
                        <td class="py-2.5 pr-4"><span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $badge }}">{{ $v->stock_quantity }}</span></td>
                        <td class="py-2.5 space-x-1">
                            <button wire:click="adjust({{ $v->id }}, -1)" class="px-2.5 py-1 rounded-lg border border-ebene/20 font-bold">-1</button>
                            <button wire:click="adjust({{ $v->id }}, 1)" class="px-2.5 py-1 rounded-lg border border-ebene/20 font-bold">+1</button>
                            <button wire:click="adjust({{ $v->id }}, 5)" class="px-2.5 py-1 rounded-lg bg-foret text-ivoire text-xs font-semibold">+5</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
