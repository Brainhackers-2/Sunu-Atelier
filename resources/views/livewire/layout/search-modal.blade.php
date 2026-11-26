<div>
    <div class="relative">
        <label for="search-input" class="sr-only">Rechercher une création</label>
        <i data-lucide="search" class="absolute left-3 top-1/2 -translate-y-1/2 size-5 text-ebene/40" aria-hidden="true"></i>
        <input
            id="search-input"
            x-ref="searchInput"
            type="search"
            wire:model.live.debounce.300ms="query"
            placeholder="Rechercher un produit, une matière, un artisan…"
            class="w-full pl-10 pr-4 py-3 rounded-xl border border-ebene/20 bg-white text-ebene text-sm focus:outline-none focus:ring-2 focus:ring-foret/40"
            autocomplete="off"
        >
    </div>

    @if (mb_strlen(trim($query)) >= 2)
        <div class="mt-3 divide-y divide-ebene/10 max-h-80 overflow-y-auto">
            @forelse ($results as $item)
                <a href="{{ route('produit', $item->slug) }}" class="flex items-center justify-between gap-3 py-2.5 px-2 rounded-lg hover:bg-foret/5 transition-colors">
                    <div>
                        <p class="text-sm font-semibold text-ebene">{{ $item->title }}</p>
                        <p class="text-xs text-ebene/60">{{ $item->category?->name }} · {{ $item->artisan?->name }}</p>
                    </div>
                    <span class="text-sm font-bold text-foret shrink-0">{{ $item->formattedPrice() }}</span>
                </a>
            @empty
                <p class="py-4 text-sm text-ebene/60 text-center">Aucune création trouvée pour « {{ $query }} ».</p>
            @endforelse
        </div>
    @endif
</div>
