<div class="max-w-screen-xl mx-auto px-4 py-8 space-y-12">
    {{-- 1. Fil d'Ariane --}}
    <nav aria-label="Fil d'Ariane" class="text-xs sm:text-sm text-ebene/60 flex items-center gap-2 flex-wrap">
        <a href="{{ route('home') }}" class="hover:text-foret">Accueil</a>
        <span>/</span>
        <a href="{{ route('boutique') }}" class="hover:text-foret">Boutique</a>
        @if ($product->category)
            <span>/</span>
            <a href="{{ route('boutique', ['cat' => $product->category->slug]) }}" class="hover:text-foret">{{ $product->category->name }}</a>
        @endif
        <span>/</span>
        <span class="text-ebene font-medium">{{ $product->title }}</span>
    </nav>

    {{-- 2 & 3. Galerie + Panneau d'achat --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
        {{-- Galerie --}}
        <div class="lg:col-span-6 space-y-4">
            <div class="aspect-[4/3] rounded-3xl bg-gradient-to-br from-foret/10 via-white to-terre/10 border border-ebene/10 flex items-center justify-center overflow-hidden group">
                @if ($product->images->first())
                    <img src="{{ asset($product->images->first()->path) }}" alt="{{ $product->title }}"
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                    <div class="text-center p-8">
                        <span class="inline-flex items-center justify-center w-20 h-20 rounded-3xl bg-foret/15 text-foret font-bold text-2xl mb-3">
                            {{ strtoupper(substr($product->category?->name ?? 'SA', 0, 2)) }}
                        </span>
                        <p class="text-sm font-medium text-ebene/60">{{ $product->title }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Panneau d'achat --}}
        <div class="lg:col-span-6 space-y-5 bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-2 text-xs text-ebene/60">
                <span>Réf. {{ $product->sku }} · Artisan : <strong class="text-ebene">{{ $product->artisan?->name ?? 'Atelier Sunu' }}</strong></span>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-ebene text-or font-bold">
                    ★ {{ number_format($avgRating, 1, ',', '') }} ({{ $product->reviews->count() }} avis)
                </span>
            </div>

            <h1 class="text-2xl sm:text-3xl font-bold text-ebene">{{ $product->title }}</h1>

            <div class="flex items-baseline gap-3">
                <span class="text-2xl sm:text-3xl font-bold text-foret">{{ $product->formattedPrice() }}</span>
                @if ($product->price_compare_at)
                    <span class="text-base text-ebene/40 line-through">{{ number_format($product->price_compare_at, 0, ',', ' ') }} FCFA</span>
                @endif
            </div>

            {{-- Disponibilité --}}
            <div class="text-sm">
                @if ($product->availability_type === 'piece_unique')
                    @if ($product->totalStock() > 0)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-or text-ebene font-bold text-xs">Pièce unique disponible</span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-erreur/10 text-erreur font-bold text-xs">Pièce unique vendue</span>
                    @endif
                @elseif ($product->availability_type === 'sur_commande')
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-foret/10 text-foret font-semibold text-xs">
                        Sur commande · Délai de fabrication : {{ $product->manufacturing_days ?? 7 }} jours
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-foret/10 text-foret font-semibold text-xs">
                        En stock – Expédié sous 48h
                    </span>
                @endif
            </div>

            {{-- Variantes --}}
            @if ($product->variants->isNotEmpty())
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-ebene/60 mb-2">Variante (taille / couleur / matière)</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach ($product->variants as $variant)
                            <button type="button" wire:click="$set('selectedVariantId', {{ $variant->id }})"
                                    class="px-4 py-2 rounded-xl border text-sm font-medium btn-touch transition-colors
                                    {{ $selectedVariantId === $variant->id ? 'border-foret bg-foret text-ivoire' : 'border-ebene/20 text-ebene hover:border-foret' }}">
                                {{ $variant->displayLabel() }}
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Quantité + Ajouter au panier --}}
            @if ($product->isAvailableForPurchase())
                <div class="flex flex-col sm:flex-row gap-3 pt-2">
                    <div class="inline-flex items-center justify-between border border-ebene/20 rounded-xl px-2 h-12 sm:w-36">
                        <button type="button" wire:click="decrementQty" class="w-9 h-9 rounded-lg hover:bg-ebene/5 font-bold" aria-label="Diminuer">-</button>
                        <span class="font-bold text-sm">{{ $quantity }}</span>
                        <button type="button" wire:click="incrementQty" class="w-9 h-9 rounded-lg hover:bg-ebene/5 font-bold" aria-label="Augmenter">+</button>
                    </div>

                    <button type="button" wire:click="addToCart"
                            class="flex-1 py-3 px-6 rounded-xl bg-terre text-white font-semibold text-sm btn-touch hover:bg-terre/90 transition-colors flex items-center justify-center gap-2">
                        <i data-lucide="shopping-bag" class="size-4" aria-hidden="true"></i>
                        Ajouter au panier
                    </button>
                </div>

                @php
                    $waMsg = "Bonjour Sunu Atelier, je souhaite commander : {$product->title} (Réf. {$product->sku}) × {$quantity}.";
                @endphp
                <a href="https://wa.me/{{ $whatsappNumber }}?text={{ rawurlencode($waMsg) }}" target="_blank" rel="noopener noreferrer"
                   class="w-full py-3 px-6 rounded-xl bg-whatsapp text-ebene font-bold text-sm btn-touch hover:opacity-90 transition-opacity flex items-center justify-center gap-2">
                    <i data-lucide="message-circle" class="size-4" aria-hidden="true"></i>
                    Commander en 1 clic sur WhatsApp
                </a>
            @else
                <div class="p-4 rounded-xl bg-erreur/10 text-erreur text-sm font-semibold">
                    Cette création n'est actuellement plus disponible à la commande.
                </div>
            @endif
        </div>
    </div>

    {{-- 4. Onglets (Alpine.js) --}}
    <div x-data="{ tab: 'desc' }" class="bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8">
        <div class="flex flex-wrap gap-2 border-b border-ebene/10 pb-4 mb-6">
            @foreach ([
                'desc' => 'Description & histoire',
                'mats' => 'Matériaux & savoir-faire',
                'care' => 'Entretien & utilisation',
                'auth' => 'Garanties & authenticité',
            ] as $key => $label)
                <button type="button" x-on:click="tab = '{{ $key }}'"
                        :class="tab === '{{ $key }}' ? 'bg-foret text-ivoire' : 'bg-ivoire text-ebene hover:bg-foret/10'"
                        class="px-4 py-2 rounded-xl text-sm font-semibold transition-colors btn-touch">
                    {{ $label }}
                </button>
            @endforeach
        </div>

        <div x-show="tab === 'desc'" class="text-sm text-ebene/80 leading-relaxed space-y-2">
            <p>{{ $product->description }}</p>
        </div>
        <div x-show="tab === 'mats'" style="display: none" class="text-sm text-ebene/80 leading-relaxed space-y-2">
            <p>{{ $product->materials_story }}</p>
            @if ($product->technique)
                <p><strong>Technique :</strong> {{ $product->technique->name }}</p>
            @endif
        </div>
        <div x-show="tab === 'care'" style="display: none" class="text-sm text-ebene/80 leading-relaxed">
            <p>{{ $product->care_instructions }}</p>
        </div>
        <div x-show="tab === 'auth'" style="display: none" class="text-sm text-ebene/80 leading-relaxed">
            <p>{{ $product->authenticity_guarantee }}</p>
        </div>
    </div>

    {{-- 5. Avis clients vérifiés --}}
    <section class="bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8 space-y-6">
        <div class="flex items-center justify-between gap-4">
            <h2 class="text-xl font-bold text-ebene">Avis clients vérifiés ({{ $product->reviews->count() }})</h2>
            <a href="{{ route('avis') }}" class="text-sm font-semibold text-terre hover:underline">Voir tous les avis</a>
        </div>

        @forelse ($product->reviews as $review)
            <div class="border-t border-ebene/10 pt-4">
                <div class="flex items-center justify-between text-xs text-ebene/60 mb-1">
                    <strong class="text-ebene text-sm">{{ $review->user?->name ?? 'Client vérifié' }}</strong>
                    <span class="px-2 py-0.5 rounded-full bg-ebene text-or font-bold">{{ $review->rating }} ★</span>
                </div>
                <p class="text-sm text-ebene/80">{{ $review->comment }}</p>
            </div>
        @empty
            <p class="text-sm text-ebene/60">Aucun avis vérifié pour cette création pour le moment.</p>
        @endforelse
    </section>

    {{-- 6. Cross-selling (4 pièces associées) --}}
    @if ($related->isNotEmpty())
        <section class="space-y-6">
            <h2 class="text-2xl font-bold text-ebene">Pour compléter votre style</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach ($related as $rel)
                    <x-product-card :product="$rel" />
                @endforeach
            </div>
        </section>
    @endif
</div>
