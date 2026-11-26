<div class="space-y-6">
    <div>
        <h3 class="text-xs font-bold uppercase tracking-wider text-ebene/60 mb-3">Catégorie</h3>
        <div class="space-y-2">
            <label class="flex items-center justify-between text-sm cursor-pointer">
                <span class="flex items-center gap-2">
                    <input type="radio" wire:model.live="category" value="" class="text-foret focus:ring-foret">
                    Toutes
                </span>
            </label>
            @foreach ($categories as $cat)
                <label class="flex items-center justify-between text-sm cursor-pointer">
                    <span class="flex items-center gap-2">
                        <input type="radio" wire:model.live="category" value="{{ $cat->slug }}" class="text-foret focus:ring-foret">
                        {{ $cat->name }}
                    </span>
                    <span class="text-xs text-ebene/50">({{ $cat->products_count }})</span>
                </label>
            @endforeach
        </div>
    </div>

    <div>
        <h3 class="text-xs font-bold uppercase tracking-wider text-ebene/60 mb-3">Matière</h3>
        <select wire:model.live="material" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
            <option value="">Toutes les matières</option>
            @foreach ($materials as $mat)
                <option value="{{ $mat->slug }}">{{ $mat->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <h3 class="text-xs font-bold uppercase tracking-wider text-ebene/60 mb-3">Origine / Technique</h3>
        <select wire:model.live="technique" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
            <option value="">Toutes les techniques</option>
            @foreach ($techniques as $tech)
                <option value="{{ $tech->slug }}">{{ $tech->name }}</option>
            @endforeach
        </select>
    </div>

    <div>
        <h3 class="text-xs font-bold uppercase tracking-wider text-ebene/60 mb-3">Budget (FCFA)</h3>
        <div class="grid grid-cols-2 gap-2">
            <input type="number" wire:model.live.debounce.400ms="priceMin" placeholder="Min" min="0" step="1000"
                   class="w-full px-3 py-2 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
            <input type="number" wire:model.live.debounce.400ms="priceMax" placeholder="Max" min="0" step="1000"
                   class="w-full px-3 py-2 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
        </div>
    </div>

    <button type="button" wire:click="resetFilters"
            class="w-full py-2.5 px-4 rounded-xl border border-ebene/20 text-sm font-semibold text-ebene hover:bg-ebene/5 btn-touch">
        Réinitialiser les filtres
    </button>
</div>
