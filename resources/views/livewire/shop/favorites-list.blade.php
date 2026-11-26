<div class="max-w-screen-xl mx-auto px-4 py-10 space-y-6">
    <h1 class="text-2xl sm:text-3xl font-bold text-ebene">Mes Favoris</h1>

    @if ($favorites->isEmpty())
        <div class="bg-white rounded-3xl border border-ebene/10 p-12 text-center space-y-3">
            <p class="font-bold text-ebene">Vous n'avez aucune pièce en favori pour le moment.</p>
            <a href="{{ route('boutique') }}" class="inline-flex px-6 py-3 rounded-xl bg-terre text-white text-sm font-semibold btn-touch">Explorer la boutique</a>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
            @foreach ($favorites as $fav)
                @if ($fav->product)
                    <div class="relative">
                        <x-product-card :product="$fav->product" />
                        <button wire:click="removeFavorite({{ $fav->product->id }})" class="mt-2 text-xs text-erreur hover:underline w-full text-center">
                            Retirer des favoris
                        </button>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
