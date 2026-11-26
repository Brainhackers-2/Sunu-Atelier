<div class="max-w-screen-xl mx-auto px-4 py-10 space-y-10">
    <div>
        <h1 class="text-2xl sm:text-3xl font-bold text-ebene">Avis &amp; Témoignages</h1>
        <p class="text-sm text-ebene/65 mt-1">Retours vérifiés de nos clients au Sénégal et à l'international.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse ($reviews as $rev)
            <article class="bg-white rounded-2xl border border-ebene/10 p-5 space-y-3">
                <div class="flex items-center justify-between">
                    <strong class="text-sm text-ebene">{{ $rev->user?->name ?? 'Client vérifié' }}</strong>
                    <span class="px-2.5 py-0.5 rounded-full bg-ebene text-or text-xs font-bold">{{ $rev->rating }} ★</span>
                </div>
                <p class="text-xs text-foret font-semibold">{{ $rev->product?->title }}</p>
                <p class="text-sm text-ebene/80">{{ $rev->comment }}</p>
            </article>
        @empty
            <p class="text-sm text-ebene/60">Aucun avis publié pour le moment.</p>
        @endforelse
    </div>

    <div class="bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8 max-w-2xl">
        <h2 class="text-xl font-bold text-ebene mb-2">Laisser un avis</h2>
        @auth
            @if ($feedback)
                <div class="mb-4 p-3 rounded-xl bg-foret/10 text-foret text-sm font-medium">{{ $feedback }}</div>
            @endif
            <form wire:submit="submitReview" class="space-y-4 text-sm">
                <div>
                    <label class="block text-xs font-medium mb-1">Produit acheté</label>
                    <select wire:model="product_id" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                        <option value="">Sélectionner un produit…</option>
                        @foreach ($products as $p)
                            <option value="{{ $p->id }}">{{ $p->title }}</option>
                        @endforeach
                    </select>
                    @error('product_id')<p class="text-xs text-erreur mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Note (1 à 5)</label>
                    <select wire:model="rating" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                        @for ($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}">{{ $i }} étoile{{ $i > 1 ? 's' : '' }}</option>
                        @endfor
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Votre témoignage</label>
                    <textarea wire:model="comment" rows="3" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20"></textarea>
                    @error('comment')<p class="text-xs text-erreur mt-1">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="px-6 py-3 rounded-xl bg-terre text-white font-semibold btn-touch">Publier mon avis</button>
            </form>
        @else
            <p class="text-sm text-ebene/70">
                Les avis sont réservés aux acheteurs connectés (commande livrée).
                <a href="{{ route('login') }}" class="text-terre font-semibold hover:underline">Se connecter</a>
            </p>
        @endauth
    </div>
</div>
