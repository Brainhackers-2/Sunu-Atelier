<div>
    <div class="relative">
        <label for="search-input" class="sr-only">Rechercher une création</label>
        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 size-5 text-ebene/40" aria-hidden="true"></i>
        <input
            id="search-input"
            type="search"
            wire:model.live.debounce.300ms="query"
            placeholder="Rechercher un produit, une matière, un artisan…"
            class="w-full pl-10 pr-4 py-3 rounded-xl border border-ebene/20 bg-white text-ebene text-sm focus:outline-none focus:ring-2 focus:ring-foret/40"
            autocomplete="off"
        >
    </div>

    @if (strlen($query) >= 2)
        <div class="mt-3 text-sm text-ebene/60 text-center">
            Résultats de recherche disponibles en Phase 5…
        </div>
    @endif
</div>
