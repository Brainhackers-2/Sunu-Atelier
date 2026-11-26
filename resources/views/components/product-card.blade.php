@props(['product'])

@php
    $firstVariant = $product->variants->first();
    $isAvailable = $product->isAvailableForPurchase();
    $rating = round((float) ($product->approved_reviews_avg ?? 4.8), 1);
@endphp

<article class="bg-white rounded-2xl border border-ebene/10 overflow-hidden flex flex-col shadow-sm hover:shadow-md transition-shadow group">
    {{-- Visuel produit --}}
    <a href="{{ route('produit', $product->slug) }}" class="relative aspect-[4/3] bg-gradient-to-br from-foret/10 via-ivoire to-terre/10 flex items-center justify-center overflow-hidden">
        @if ($product->images->first())
            <img
                src="{{ asset($product->images->first()->path) }}"
                alt="{{ $product->title }}"
                loading="lazy"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
            >
        @else
            <div class="text-center px-4">
                <span class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-foret/15 text-foret font-bold text-lg mb-2">
                    {{ strtoupper(substr($product->category?->name ?? 'SA', 0, 2)) }}
                </span>
                <p class="text-xs font-medium text-ebene/50">{{ $product->category?->name }}</p>
            </div>
        @endif

        {{-- Badges --}}
        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5">
            @if ($product->availability_type === 'piece_unique')
                <span class="px-2.5 py-1 rounded-full bg-or text-ebene text-[11px] font-bold">Pièce unique</span>
            @elseif ($product->is_bestseller)
                <span class="px-2.5 py-1 rounded-full bg-or text-ebene text-[11px] font-bold">Bestseller</span>
            @elseif ($product->is_new)
                <span class="px-2.5 py-1 rounded-full bg-foret text-ivoire text-[11px] font-bold">Nouveauté</span>
            @endif
        </div>
    </a>

    {{-- Contenu --}}
    <div class="p-4 flex-1 flex flex-col">
        <div class="flex items-center justify-between gap-2 text-xs text-ebene/60 mb-1">
            <span>{{ $product->artisan?->name ?? 'Atelier Sunu' }}</span>
            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-ebene text-or font-semibold text-[11px]">
                ★ {{ number_format($rating, 1, ',', '') }}
            </span>
        </div>

        <a href="{{ route('produit', $product->slug) }}" class="font-bold text-ebene hover:text-terre transition-colors line-clamp-2 mb-2">
            {{ $product->title }}
        </a>

        <div class="mt-auto pt-3 flex items-baseline gap-2">
            <span class="text-base font-bold text-foret">{{ $product->formattedPrice() }}</span>
            @if ($product->price_compare_at)
                <span class="text-xs text-ebene/40 line-through">{{ number_format($product->price_compare_at, 0, ',', ' ') }} FCFA</span>
            @endif
        </div>

        @if ($firstVariant && $isAvailable)
            <button
                type="button"
                onclick="Livewire.dispatch('addToCart', { variantId: {{ $firstVariant->id }}, quantity: 1 })"
                class="mt-3 w-full py-2.5 px-4 rounded-xl bg-terre text-white text-sm font-semibold btn-touch hover:bg-terre/90 transition-colors flex items-center justify-center gap-2"
            >
                <i data-lucide="shopping-bag" class="size-4" aria-hidden="true"></i>
                Ajouter au panier
            </button>
        @else
            <span class="mt-3 w-full py-2.5 px-4 rounded-xl bg-ebene/10 text-ebene/50 text-sm font-semibold text-center btn-touch flex items-center justify-center">
                Indisponible
            </span>
        @endif
    </div>
</article>
