<div>
    {{-- En-tête Avis --}}
    <section class="bg-gradient-to-br from-foret to-ebene text-ivoire py-12">
        <div class="max-w-screen-xl mx-auto px-4 flex flex-col sm:flex-row sm:items-center justify-between gap-6">
            <div class="space-y-2">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-or text-ebene text-xs font-bold">
                    <i data-lucide="star" class="size-3.5" aria-hidden="true"></i>
                    Avis vérifiés
                </span>
                <h1 class="text-3xl sm:text-4xl font-bold">Avis &amp; Témoignages</h1>
                <p class="text-sm text-ivoire/80">Retours authentiques de nos clients au Sénégal et à l'international.</p>
            </div>
            @if ($reviews->count() > 0)
                <div class="bg-ivoire/10 backdrop-blur-sm border border-ivoire/15 rounded-2xl px-6 py-4 text-center shrink-0">
                    <p class="text-3xl font-bold text-or">{{ number_format($reviews->avg('rating'), 1) }} <span class="text-lg">/ 5</span></p>
                    <p class="text-xs text-ivoire/80 mt-0.5">Basé sur {{ $reviews->count() }} avis vérifié{{ $reviews->count() > 1 ? 's' : '' }}</p>
                </div>
            @endif
        </div>
    </section>

    <div class="max-w-screen-xl mx-auto px-4 py-10 space-y-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @forelse ($reviews as $rev)
                <article class="bg-white rounded-2xl border border-ebene/10 p-6 space-y-3 shadow-sm flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-center justify-between gap-2">
                            <div class="flex items-center gap-2.5">
                                <span class="w-9 h-9 rounded-full bg-foret/10 text-foret font-bold text-xs flex items-center justify-center shrink-0">
                                    {{ strtoupper(substr($rev->user?->name ?? 'CV', 0, 2)) }}
                                </span>
                                <div>
                                    <strong class="text-sm text-ebene block leading-tight">{{ $rev->user?->name ?? 'Client vérifié' }}</strong>
                                    <span class="text-[11px] text-foret font-medium">Achat vérifié</span>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full bg-ebene text-or text-xs font-bold shrink-0">{{ $rev->rating }} ★</span>
                        </div>
                        <p class="text-sm text-ebene/85 leading-relaxed">« {{ $rev->comment }} »</p>
                    </div>
                    @if ($rev->product)
                        <a href="{{ route('produit', $rev->product->slug) }}" class="pt-3 border-t border-ebene/10 text-xs text-terre font-semibold hover:underline inline-flex items-center gap-1">
                            {{ $rev->product->title }}
                            <i data-lucide="arrow-up-right" class="size-3.5" aria-hidden="true"></i>
                        </a>
                    @endif
                </article>
            @empty
                <div class="col-span-full bg-white rounded-2xl border border-ebene/10 p-8 text-center text-sm text-ebene/60">
                    Aucun avis publié pour le moment.
                </div>
            @endforelse
        </div>

        <div class="bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8 max-w-2xl shadow-sm">
            <h2 class="text-xl font-bold text-ebene mb-2">Laisser un avis</h2>
            @auth
                @if ($feedback)
                    <div class="mb-4 p-3 rounded-xl bg-foret/10 text-foret text-sm font-medium">{{ $feedback }}</div>
                @endif
                <form wire:submit="submitReview" class="space-y-4 text-sm">
                    <div>
                        <label class="block text-xs font-medium mb-1">Produit acheté</label>
                        <select wire:model="product_id" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20 bg-ivoire/40">
                            <option value="">Sélectionner un produit…</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}">{{ $p->title }}</option>
                            @endforeach
                        </select>
                        @error('product_id')<p class="text-xs text-erreur mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Note (1 à 5)</label>
                        <select wire:model="rating" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20 bg-ivoire/40">
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }} étoile{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Votre témoignage</label>
                        <textarea wire:model="comment" rows="3" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20 bg-ivoire/40"></textarea>
                        @error('comment')<p class="text-xs text-erreur mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="px-6 py-3 rounded-xl bg-terre text-white font-semibold hover:bg-terre/90 transition-colors btn-touch">Publier mon avis</button>
                </form>
            @else
                <p class="text-sm text-ebene/70">
                    Les avis sont réservés aux acheteurs connectés (commande livrée).
                    <a href="{{ route('login') }}" class="text-terre font-semibold hover:underline">Se connecter</a>
                </p>
            @endauth
        </div>
    </div>
</div>
