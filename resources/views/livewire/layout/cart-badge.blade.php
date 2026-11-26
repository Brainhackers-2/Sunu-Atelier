<button
    type="button"
    wire:click="$dispatch('openCart')"
    class="relative btn-touch flex items-center justify-center rounded-full hover:bg-foret/10 text-ebene hover:text-foret transition-colors"
    aria-label="Ouvrir le panier ({{ $count }} article{{ $count !== 1 ? 's' : '' }})"
>
    <i data-lucide="shopping-cart" class="size-5" aria-hidden="true"></i>
    @if ($count > 0)
        <span
            class="absolute -top-1 -right-1 bg-terre text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center"
            aria-hidden="true"
        >
            {{ $count > 99 ? '99+' : $count }}
        </span>
    @endif
</button>
