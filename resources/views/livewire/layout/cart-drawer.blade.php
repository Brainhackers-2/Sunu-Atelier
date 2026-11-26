<div>
    @if ($open)
        <div wire:click="closeDrawer" class="fixed inset-0 z-[90] bg-ebene/60" aria-hidden="true"></div>
    @endif

    <div
        x-data="{ open: @entangle('open') }"
        x-show="open"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-end="translate-x-full"
        x-on:keydown.escape.window="$wire.closeDrawer()"
        class="fixed right-0 top-0 z-[100] h-full w-full max-w-md bg-ivoire shadow-2xl flex flex-col"
        style="display: none"
        role="dialog" aria-modal="true" aria-label="Votre panier"
    >
        <div class="flex items-center justify-between p-5 border-b border-ebene/10">
            <h2 class="text-lg font-bold text-ebene flex items-center gap-2">
                <i data-lucide="shopping-cart" class="size-5 text-foret" aria-hidden="true"></i>
                Mon panier ({{ $items->sum('quantity') }})
            </h2>
            <button wire:click="closeDrawer" class="btn-touch flex items-center justify-center rounded-full hover:bg-foret/10 text-ebene" aria-label="Fermer le panier">
                <i data-lucide="x" class="size-5" aria-hidden="true"></i>
            </button>
        </div>

        @if ($items->isEmpty())
            <div class="flex-1 flex items-center justify-center p-8">
                <div class="text-center text-ebene/50">
                    <i data-lucide="shopping-cart" class="size-16 mx-auto mb-4 opacity-30" aria-hidden="true"></i>
                    <p class="font-medium">Votre panier est vide</p>
                    <p class="text-sm mt-1">Découvrez nos créations artisanales</p>
                </div>
            </div>
            <div class="p-5 border-t border-ebene/10">
                <a href="{{ route('boutique') }}" class="flex items-center justify-center gap-2 w-full py-3 px-6 rounded-xl bg-terre text-white font-semibold text-sm btn-touch hover:bg-terre/90 transition-colors">
                    Explorer la boutique
                </a>
            </div>
        @else
            <div class="flex-1 overflow-y-auto p-4 divide-y divide-ebene/10">
                @foreach ($items as $item)
                    <div class="py-4 flex gap-3" wire:key="drawer-item-{{ $item->id }}">
                        <div class="w-16 h-16 rounded-xl bg-foret/10 flex items-center justify-center shrink-0 text-foret font-bold text-xs">
                            {{ strtoupper(substr($item->product?->category?->name ?? 'SA', 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <a href="{{ route('produit', $item->product->slug) }}" class="text-sm font-semibold text-ebene hover:text-terre line-clamp-1">
                                {{ $item->product->title }}
                            </a>
                            <p class="text-xs text-ebene/60">{{ $item->variant?->displayLabel() }}</p>
                            <p class="text-sm font-bold text-foret mt-1">
                                {{ number_format($item->product->price_public * $item->quantity, 0, ',', ' ') }} FCFA
                            </p>
                            <div class="flex items-center gap-2 mt-2">
                                <button wire:click="decrement({{ $item->id }}, {{ $item->quantity }})" class="w-8 h-8 rounded-lg border border-ebene/20 flex items-center justify-center text-sm font-bold hover:bg-ebene/5" aria-label="Diminuer quantité">-</button>
                                <span class="text-sm font-medium px-2">{{ $item->quantity }}</span>
                                <button wire:click="increment({{ $item->id }}, {{ $item->quantity }})" class="w-8 h-8 rounded-lg border border-ebene/20 flex items-center justify-center text-sm font-bold hover:bg-ebene/5" aria-label="Augmenter quantité">+</button>
                                <button wire:click="remove({{ $item->id }})" class="ml-auto text-xs text-erreur hover:underline" aria-label="Supprimer">Supprimer</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="p-5 border-t border-ebene/10 bg-white space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <span class="text-ebene/70">Sous-total</span>
                    <span class="text-lg font-bold text-ebene">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('panier') }}" class="flex items-center justify-center py-3 px-4 rounded-xl border border-ebene/20 text-ebene font-semibold text-sm btn-touch hover:bg-ebene/5">
                        Voir le panier
                    </a>
                    <a href="{{ route('commande') }}" class="flex items-center justify-center py-3 px-4 rounded-xl bg-terre text-white font-semibold text-sm btn-touch hover:bg-terre/90">
                        Commander
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
