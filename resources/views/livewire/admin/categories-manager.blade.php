<div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
    <form wire:submit="save" class="lg:col-span-4 bg-white rounded-2xl border border-ebene/10 p-5 space-y-4 h-fit">
        <h2 class="font-bold text-ebene">{{ $editingId ? 'Modifier la catégorie' : 'Nouvelle catégorie' }}</h2>
        <div>
            <label class="block text-xs font-medium mb-1">Nom *</label>
            <input type="text" wire:model="name" class="w-full px-3 py-2 rounded-xl border border-ebene/20 text-sm">
        </div>
        <div>
            <label class="block text-xs font-medium mb-1">Description</label>
            <textarea wire:model="description" rows="2" class="w-full px-3 py-2 rounded-xl border border-ebene/20 text-sm"></textarea>
        </div>
        <div>
            <label class="block text-xs font-medium mb-1">Ordre d'affichage</label>
            <input type="number" wire:model="sort_order" class="w-full px-3 py-2 rounded-xl border border-ebene/20 text-sm">
        </div>
        <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" wire:model="is_active"> Active</label>
        <button type="submit" class="w-full py-2.5 rounded-xl bg-foret text-ivoire text-sm font-semibold btn-touch">Enregistrer</button>
    </form>

    <div class="lg:col-span-8 bg-white rounded-2xl border border-ebene/10 p-5 overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs uppercase text-ebene/50 border-b border-ebene/10">
                <tr>
                    <th class="py-2 pr-4">Ordre</th>
                    <th class="py-2 pr-4">Nom</th>
                    <th class="py-2 pr-4">Produits</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ebene/10">
                @foreach ($categories as $cat)
                    <tr>
                        <td class="py-2.5 pr-4">{{ $cat->sort_order }}</td>
                        <td class="py-2.5 pr-4 font-semibold">{{ $cat->name }}</td>
                        <td class="py-2.5 pr-4">{{ $cat->products_count }}</td>
                        <td class="py-2.5">
                            <button wire:click="edit({{ $cat->id }})" class="text-foret font-semibold hover:underline">Modifier</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
