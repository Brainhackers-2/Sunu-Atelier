<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <form wire:submit="createCode" class="lg:col-span-4 bg-white rounded-2xl border border-ebene/10 p-5 space-y-3 h-fit text-sm">
        <h2 class="font-bold text-ebene">Nouveau code promo</h2>
        <input type="text" wire:model="code" placeholder="CODE (ex. DAKAR15)" class="w-full px-3 py-2 rounded-xl border border-ebene/20 uppercase">
        @error('code')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
        <select wire:model="type" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
            <option value="percentage">Pourcentage (%)</option>
            <option value="fixed">Montant fixe (FCFA)</option>
        </select>
        <input type="number" wire:model="value" placeholder="Valeur" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
        <input type="number" wire:model="min_order_amount" placeholder="Minimum d'achat (FCFA)" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
        <input type="number" wire:model="max_uses" placeholder="Utilisations max (optionnel)" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
        <button type="submit" class="w-full py-2.5 rounded-xl bg-foret text-ivoire font-semibold btn-touch">Créer</button>
    </form>

    <div class="lg:col-span-8 bg-white rounded-2xl border border-ebene/10 p-5 overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs uppercase text-ebene/50 border-b border-ebene/10">
                <tr>
                    <th class="py-2 pr-4">Code</th>
                    <th class="py-2 pr-4">Remise</th>
                    <th class="py-2 pr-4">Min</th>
                    <th class="py-2 pr-4">Utilisations</th>
                    <th class="py-2">Statut</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ebene/10">
                @foreach ($codes as $c)
                    <tr>
                        <td class="py-2.5 pr-4 font-bold">{{ $c->code }}</td>
                        <td class="py-2.5 pr-4">{{ $c->type === 'percentage' ? $c->value . ' %' : number_format($c->value, 0, ',', ' ') . ' FCFA' }}</td>
                        <td class="py-2.5 pr-4">{{ number_format($c->min_order_amount, 0, ',', ' ') }} FCFA</td>
                        <td class="py-2.5 pr-4">{{ $c->used_count }} / {{ $c->max_uses ?? '∞' }}</td>
                        <td class="py-2.5">
                            <button wire:click="toggle({{ $c->id }})" class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $c->is_active ? 'bg-foret/10 text-foret' : 'bg-ebene/10 text-ebene/60' }}">
                                {{ $c->is_active ? 'Actif' : 'Inactif' }}
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
