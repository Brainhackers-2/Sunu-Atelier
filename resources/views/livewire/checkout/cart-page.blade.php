<div class="max-w-screen-xl mx-auto px-4 py-10">
    <h1 class="text-2xl sm:text-3xl font-bold text-ebene mb-8">Mon Panier</h1>

    @if ($items->isEmpty())
        <div class="bg-white rounded-3xl border border-ebene/10 p-12 text-center space-y-4">
            <i data-lucide="shopping-cart" class="size-16 mx-auto text-ebene/20" aria-hidden="true"></i>
            <h2 class="text-xl font-bold text-ebene">Votre panier est vide</h2>
            <p class="text-sm text-ebene/60">Parcourez nos créations artisanales pour commencer votre commande.</p>
            <a href="{{ route('boutique') }}" class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl bg-terre text-white font-semibold text-sm btn-touch hover:bg-terre/90">
                Découvrir la boutique
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Tableau panier --}}
            <div class="lg:col-span-8 bg-white rounded-3xl border border-ebene/10 divide-y divide-ebene/10">
                @foreach ($items as $item)
                    <div class="p-5 flex flex-col sm:flex-row sm:items-center gap-4" wire:key="cart-row-{{ $item->id }}">
                        <div class="w-20 h-20 rounded-2xl bg-foret/10 text-foret font-bold flex items-center justify-center shrink-0">
                            {{ strtoupper(substr($item->product?->category?->name ?? 'SA', 0, 2)) }}
                        </div>

                        <div class="flex-1 min-w-0">
                            <a href="{{ route('produit', $item->product->slug) }}" class="font-bold text-ebene hover:text-terre">
                                {{ $item->product->title }}
                            </a>
                            <p class="text-xs text-ebene/60 mt-0.5">{{ $item->variant?->displayLabel() }}</p>
                            <p class="text-sm text-foret font-semibold mt-1">
                                {{ number_format($item->product->price_public, 0, ',', ' ') }} FCFA / unité
                            </p>
                        </div>

                        <div class="flex items-center gap-3">
                            <div class="inline-flex items-center border border-ebene/20 rounded-xl">
                                <button wire:click="decrement({{ $item->id }}, {{ $item->quantity }})" class="w-9 h-9 font-bold hover:bg-ebene/5" aria-label="Diminuer">-</button>
                                <span class="px-3 text-sm font-semibold">{{ $item->quantity }}</span>
                                <button wire:click="increment({{ $item->id }}, {{ $item->quantity }})" class="w-9 h-9 font-bold hover:bg-ebene/5" aria-label="Augmenter">+</button>
                            </div>

                            <div class="text-right min-w-[100px]">
                                <p class="font-bold text-ebene">{{ number_format($item->product->price_public * $item->quantity, 0, ',', ' ') }} FCFA</p>
                                <button wire:click="remove({{ $item->id }})" class="text-xs text-erreur hover:underline">Supprimer</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Récapitulatif + Code promo --}}
            <aside class="lg:col-span-4 space-y-5">
                <div class="bg-white rounded-3xl border border-ebene/10 p-6 space-y-5 shadow-sm">
                    <h2 class="text-lg font-bold text-ebene">Récapitulatif</h2>

                    {{-- Code promo --}}
                    @if ($cart?->promoCode)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-foret/10 text-foret text-sm">
                            <span>Code <strong>{{ $cart->promoCode->code }}</strong> appliqué</span>
                            <button wire:click="removePromo" class="text-xs underline">Retirer</button>
                        </div>
                    @else
                        <form wire:submit="applyPromo" class="flex gap-2">
                            <input type="text" wire:model="promoInput" placeholder="Code promo (ex. BIENVENUE10)"
                                   class="flex-1 px-3 py-2.5 rounded-xl border border-ebene/20 text-sm uppercase">
                            <button type="submit" class="px-4 py-2.5 rounded-xl bg-ebene text-ivoire text-sm font-semibold btn-touch">
                                Appliquer
                            </button>
                        </form>
                    @endif

                    @if ($promoMessage)
                        <p class="text-xs {{ $promoError ? 'text-erreur' : 'text-foret' }} font-medium">{{ $promoMessage }}</p>
                    @endif

                    <div class="space-y-2 text-sm border-t border-ebene/10 pt-4">
                        <div class="flex justify-between">
                            <span class="text-ebene/70">Sous-total</span>
                            <span class="font-semibold">{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span>
                        </div>
                        @if ($discount > 0)
                            <div class="flex justify-between text-foret">
                                <span>Remise</span>
                                <span class="font-semibold">-{{ number_format($discount, 0, ',', ' ') }} FCFA</span>
                            </div>
                        @endif
                        <div class="flex justify-between text-ebene/60">
                            <span>Livraison</span>
                            <span>Calculée à l'étape suivante</span>
                        </div>
                        <div class="flex justify-between text-base font-bold text-ebene border-t border-ebene/10 pt-3">
                            <span>Total estimé TTC</span>
                            <span class="text-foret">{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                        </div>
                    </div>

                    <a href="{{ route('commande') }}"
                       class="w-full py-3.5 px-6 rounded-xl bg-terre text-white font-semibold text-sm btn-touch hover:bg-terre/90 transition-colors flex items-center justify-center gap-2">
                        Procéder au paiement sécurisé
                        <i data-lucide="arrow-right" class="size-4" aria-hidden="true"></i>
                    </a>
                </div>

                {{-- Rassurance --}}
                <div class="bg-white rounded-2xl border border-ebene/10 p-4 text-xs text-ebene/70 space-y-2">
                    <p class="flex items-center gap-2"><i data-lucide="shield-check" class="size-4 text-foret"></i> Paiement sécurisé &amp; pièces garanties</p>
                    <a href="https://wa.me/{{ $whatsappNumber }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-2 text-foret font-semibold hover:underline">
                        <i data-lucide="message-circle" class="size-4 text-whatsapp"></i> Besoin d'aide ? Écrire sur WhatsApp
                    </a>
                </div>
            </aside>
        </div>
    @endif
</div>
