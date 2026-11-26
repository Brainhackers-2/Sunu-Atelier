{{-- Tiroir panier – Sunu Atelier --}}
<div>
    {{-- Overlay sombre --}}
    @if ($open)
        <div
            wire:click="closeDrawer"
            class="fixed inset-0 z-[90] bg-ebene/60"
            aria-hidden="true"
        ></div>
    @endif

    {{-- Tiroir --}}
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
        {{-- En-tête --}}
        <div class="flex items-center justify-between p-5 border-b border-ebene/10">
            <h2 class="text-lg font-bold text-ebene flex items-center gap-2">
                <i data-lucide="shopping-cart" class="size-5 text-foret" aria-hidden="true"></i>
                Mon panier
            </h2>
            <button
                wire:click="closeDrawer"
                class="btn-touch flex items-center justify-center rounded-full hover:bg-foret/10 text-ebene"
                aria-label="Fermer le panier"
            >
                <i data-lucide="x" class="size-5" aria-hidden="true"></i>
            </button>
        </div>

        {{-- Corps du tiroir (sera enrichi Phase 6 avec CartService) --}}
        <div class="flex-1 flex items-center justify-center p-8">
            <div class="text-center text-ebene/40">
                <i data-lucide="shopping-cart" class="size-16 mx-auto mb-4 opacity-30" aria-hidden="true"></i>
                <p class="font-medium">Votre panier est vide</p>
                <p class="text-sm mt-1">Découvrez nos créations artisanales</p>
            </div>
        </div>

        {{-- Pied --}}
        <div class="p-5 border-t border-ebene/10">
            <a
                href="{{ route('boutique') }}"
                wire:navigate
                class="flex items-center justify-center gap-2 w-full py-3 px-6 rounded-xl bg-terre text-white font-semibold text-sm btn-touch hover:bg-terre/90 transition-colors"
            >
                <i data-lucide="shopping-bag" class="size-4" aria-hidden="true"></i>
                Explorer la boutique
            </a>
        </div>
    </div>
</div>
