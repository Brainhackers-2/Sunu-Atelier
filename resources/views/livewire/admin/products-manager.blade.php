<div class="space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
        <input type="search" wire:model.live.debounce.300ms="search" placeholder="Rechercher un produit…"
               class="px-4 py-2.5 rounded-xl border border-ebene/20 bg-white text-sm w-full sm:w-72">
        <button wire:click="openCreate" class="px-5 py-2.5 rounded-xl bg-terre text-white text-sm font-semibold btn-touch">
            + Ajouter un produit
        </button>
    </div>

    @if ($showForm)
        <form wire:submit="save" class="bg-white rounded-2xl border border-ebene/10 p-6 space-y-4">
            <h2 class="font-bold text-ebene">{{ $editingId ? 'Modifier le produit' : 'Nouveau produit' }}</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                <div>
                    <label class="block text-xs font-medium mb-1">Titre *</label>
                    <input type="text" wire:model="title" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
                    @error('title')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">SKU *</label>
                    <input type="text" wire:model="sku" class="w-full px-3 py-2 rounded-xl border border-ebene/20 uppercase">
                    @error('sku')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Catégorie *</label>
                    <select wire:model="category_id" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Artisan</label>
                    <select wire:model="artisan_id" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
                        <option value="">—</option>
                        @foreach ($artisans as $art)
                            <option value="{{ $art->id }}">{{ $art->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Disponibilité</label>
                    <select wire:model="availability_type" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
                        <option value="en_stock">En stock</option>
                        <option value="piece_unique">Pièce unique</option>
                        <option value="sur_commande">Sur commande</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Stock variante</label>
                    <input type="number" wire:model="stock_quantity" min="0" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Prix public (FCFA) *</label>
                    <input type="number" wire:model="price_public" min="100" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Prix pro (FCFA)</label>
                    <input type="number" wire:model="price_pro" min="100" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Photo (JPG/PNG/WebP, max 2 Mo)</label>
                    <input type="file" wire:model="photo" accept=".jpg,.jpeg,.png,.webp" class="w-full text-xs">
                    @error('photo')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Description courte</label>
                <textarea wire:model="short_description" rows="2" class="w-full px-3 py-2 rounded-xl border border-ebene/20 text-sm"></textarea>
            </div>
            <div class="flex flex-wrap gap-4 text-sm">
                <label class="inline-flex items-center gap-2"><input type="checkbox" wire:model="is_bestseller"> Bestseller</label>
                <label class="inline-flex items-center gap-2"><input type="checkbox" wire:model="is_new"> Nouveauté</label>
                <label class="inline-flex items-center gap-2"><input type="checkbox" wire:model="is_active"> Actif</label>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-foret text-ivoire text-sm font-semibold btn-touch">Enregistrer</button>
                <button type="button" wire:click="$set('showForm', false)" class="px-5 py-2.5 rounded-xl border border-ebene/20 text-sm">Annuler</button>
            </div>
        </form>
    @endif

    <div class="bg-white rounded-2xl border border-ebene/10 p-5 overflow-x-auto">
        <table class="w-full text-sm text-left">
            <thead class="text-xs uppercase text-ebene/50 border-b border-ebene/10">
                <tr>
                    <th class="py-2 pr-4">Produit</th>
                    <th class="py-2 pr-4">Catégorie</th>
                    <th class="py-2 pr-4">Artisan</th>
                    <th class="py-2 pr-4">Public / Pro</th>
                    <th class="py-2 pr-4">Stock</th>
                    <th class="py-2">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-ebene/10">
                @foreach ($products as $p)
                    <tr>
                        <td class="py-2.5 pr-4 font-semibold">{{ $p->title }} <span class="block text-xs text-ebene/50">{{ $p->sku }}</span></td>
                        <td class="py-2.5 pr-4">{{ $p->category?->name }}</td>
                        <td class="py-2.5 pr-4">{{ $p->artisan?->name ?? '—' }}</td>
                        <td class="py-2.5 pr-4">{{ number_format($p->price_public, 0, ',', ' ') }} / {{ number_format($p->price_pro ?? 0, 0, ',', ' ') }} FCFA</td>
                        <td class="py-2.5 pr-4">{{ $p->totalStock() }}</td>
                        <td class="py-2.5 space-x-2">
                            <button wire:click="edit({{ $p->id }})" class="text-foret font-semibold hover:underline">Modifier</button>
                            <button wire:click="delete({{ $p->id }})" wire:confirm="Supprimer ce produit ?" class="text-erreur hover:underline">Supprimer</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</div>
