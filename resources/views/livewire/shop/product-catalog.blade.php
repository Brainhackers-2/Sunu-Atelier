<div x-data="{ filtersOpen: false }">
    {{-- En-tête bannière --}}
    <section class="bg-foret text-ivoire py-10">
        <div class="max-w-screen-xl mx-auto px-4 flex flex-col sm:flex-row sm:items-end justify-between gap-4">
            <div>
                <p class="text-xs uppercase tracking-widest text-or font-semibold mb-1">Savoir-faire du Sénégal</p>
                <h1 class="text-3xl sm:text-4xl font-bold">Notre Collection</h1>
            </div>
            <p class="text-sm text-ivoire/80">{{ $products->total() }} création{{ $products->total() > 1 ? 's' : '' }} disponible{{ $products->total() > 1 ? 's' : '' }}</p>
        </div>
    </section>

    <section class="max-w-screen-xl mx-auto px-4 py-8">
        {{-- Barre de contrôle : recherche + tri + bouton filtres mobile --}}
        <div class="flex flex-col md:flex-row items-stretch md:items-center gap-3 mb-6">
            <div class="relative flex-1">
                <i data-lucide="search" class="absolute left-3.5 top-1/2 -translate-y-1/2 size-4 text-ebene/40" aria-hidden="true"></i>
                <input
                    type="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="Rechercher par nom, matière ou artisan…"
                    class="w-full pl-10 pr-4 py-3 rounded-xl border border-ebene/20 bg-white text-sm focus:outline-none focus:ring-2 focus:ring-foret/40"
                >
            </div>

            <div class="flex items-center gap-3">
                <button type="button" x-on:click="filtersOpen = true"
                        class="lg:hidden inline-flex items-center gap-2 px-4 py-3 rounded-xl border border-ebene/20 bg-white text-sm font-semibold btn-touch">
                    <i data-lucide="sliders-horizontal" class="size-4" aria-hidden="true"></i>
                    Filtres
                </button>

                <select wire:model.live="sort" aria-label="Trier les produits"
                        class="px-4 py-3 rounded-xl border border-ebene/20 bg-white text-sm font-medium focus:outline-none focus:ring-2 focus:ring-foret/40 btn-touch">
                    <option value="popular">Plus populaires</option>
                    <option value="price_asc">Prix croissant</option>
                    <option value="price_desc">Prix décroissant</option>
                    <option value="newest">Nouveautés</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Sidebar Filtres Desktop --}}
            <aside class="hidden lg:block lg:col-span-3 bg-white rounded-2xl border border-ebene/10 p-5 space-y-6">
                @include('livewire.shop.partials.filters')
            </aside>

            {{-- Tiroir Filtres Mobile --}}
            <div x-show="filtersOpen" x-on:keydown.escape.window="filtersOpen = false" class="fixed inset-0 z-[100] flex lg:hidden" style="display: none">
                <div x-on:click="filtersOpen = false" class="absolute inset-0 bg-ebene/60"></div>
                <div class="relative w-80 max-w-[85vw] bg-ivoire h-full overflow-y-auto p-5 space-y-6 shadow-2xl">
                    <div class="flex items-center justify-between border-b border-ebene/10 pb-3">
                        <h2 class="font-bold text-ebene">Filtres</h2>
                        <button type="button" x-on:click="filtersOpen = false" class="btn-touch flex items-center justify-center rounded-full hover:bg-ebene/5">
                            <i data-lucide="x" class="size-5"></i>
                        </button>
                    </div>
                    @include('livewire.shop.partials.filters')
                </div>
            </div>

            {{-- Grille produits --}}
            <div class="lg:col-span-9">
                <div wire:loading.flex class="items-center justify-center py-8 text-sm text-foret font-medium gap-2">
                    <span>Chargement des créations…</span>
                </div>

                @if ($products->isEmpty())
                    <div class="bg-white rounded-2xl border border-ebene/10 p-12 text-center space-y-3">
                        <p class="font-bold text-ebene">Aucune pièce ne correspond à vos critères.</p>
                        <p class="text-sm text-ebene/60">Essayez de modifier ou réinitialiser vos filtres.</p>
                        <button wire:click="resetFilters" class="px-5 py-2.5 rounded-xl bg-terre text-white text-sm font-semibold btn-touch">
                            Réinitialiser les filtres
                        </button>
                    </div>
                @else
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-5" wire:loading.class="opacity-50">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" :wire:key="'cat-prod-'.$product->id" />
                        @endforeach
                    </div>

                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
