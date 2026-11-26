<div class="max-w-screen-xl mx-auto px-4 py-10">
    <h1 class="text-2xl sm:text-3xl font-bold text-ebene mb-6">Finaliser ma commande</h1>

    @if ($items->isEmpty())
        <div class="bg-white rounded-3xl border border-ebene/10 p-10 text-center space-y-4">
            <p class="font-bold text-ebene">Votre panier est vide.</p>
            <a href="{{ route('boutique') }}" class="inline-flex px-6 py-3 rounded-xl bg-terre text-white text-sm font-semibold btn-touch">
                Retourner à la boutique
            </a>
        </div>
    @else
        {{-- Barre de progression 4 étapes --}}
        <div class="grid grid-cols-4 gap-2 mb-8">
            @foreach ([1 => '1. Coordonnées', 2 => '2. Livraison', 3 => '3. Paiement', 4 => '4. Validation'] as $num => $label)
                <div class="p-3 rounded-xl text-xs sm:text-sm font-semibold text-center border
                    {{ $step === $num ? 'bg-foret text-ivoire border-foret' : ($step > $num ? 'bg-foret/10 text-foret border-foret/20' : 'bg-white text-ebene/50 border-ebene/10') }}">
                    {{ $label }}
                </div>
            @endforeach
        </div>

        @if ($errorMessage)
            <div class="mb-6 p-4 rounded-2xl bg-erreur/10 border border-erreur/30 text-erreur text-sm font-medium flex items-center gap-2" role="alert">
                <i data-lucide="alert-circle" class="size-5 shrink-0"></i>
                <span>{{ $errorMessage }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            {{-- Formulaire étape active --}}
            <div class="lg:col-span-8 bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8 space-y-6">
                @if ($step === 1)
                    <h2 class="text-xl font-bold text-ebene">Étape 1 – Vos coordonnées</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Civilité</label>
                            <select wire:model="civility" class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
                                <option value="Mme">Mme</option>
                                <option value="M.">M.</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Nom complet *</label>
                            <input type="text" wire:model="customer_name" class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
                            @error('customer_name')<p class="text-xs text-erreur mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Téléphone / WhatsApp *</label>
                            <input type="tel" wire:model="customer_phone" placeholder="+221 77 000 00 00" class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
                            @error('customer_phone')<p class="text-xs text-erreur mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Email (optionnel)</label>
                            <input type="email" wire:model="customer_email" class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
                            @error('customer_email')<p class="text-xs text-erreur mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                @elseif ($step === 2)
                    <h2 class="text-xl font-bold text-ebene">Étape 2 – Mode de livraison</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        @foreach ([
                            'domicile' => ['Livraison Sénégal', 'Zones 1 à 4'],
                            'retrait' => ['Retrait Atelier', 'Gratuit à Dakar'],
                            'international' => ['International', 'Tarif fixe par zone'],
                        ] as $modeKey => [$modeTitle, $modeSub])
                            <button type="button" wire:click="$set('delivery_mode', '{{ $modeKey }}')"
                                    class="p-4 rounded-2xl border text-left btn-touch transition-colors
                                    {{ $delivery_mode === $modeKey ? 'border-foret bg-foret/10' : 'border-ebene/15 hover:border-foret/50' }}">
                                <p class="font-bold text-sm text-ebene">{{ $modeTitle }}</p>
                                <p class="text-xs text-ebene/60">{{ $modeSub }}</p>
                            </button>
                        @endforeach
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1">Zone &amp; tarif *</label>
                        <select wire:model.live="delivery_zone_id" class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
                            @foreach ($zones as $zone)
                                @php $zRate = $zone->rates->first(); @endphp
                                <option value="{{ $zone->id }}">
                                    {{ $zone->name }} ({{ $zRate ? number_format($zRate->flat_rate, 0, ',', ' ') . ' FCFA' : 'Gratuit' }} · {{ $zone->estimated_delay }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if ($delivery_mode !== 'retrait')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            @if ($delivery_mode === 'international')
                                <div>
                                    <label class="block text-sm font-medium mb-1">Pays *</label>
                                    <input type="text" wire:model="delivery_country" class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium mb-1">Code postal</label>
                                    <input type="text" wire:model="postal_code" class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
                                </div>
                            @endif
                            <div>
                                <label class="block text-sm font-medium mb-1">Ville *</label>
                                <input type="text" wire:model="delivery_city" class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
                                @error('delivery_city')<p class="text-xs text-erreur mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Créneau souhaité</label>
                                <select wire:model="delivery_slot" class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
                                    <option value="Matin (9h-13h)">Matin (9h-13h)</option>
                                    <option value="Après-midi (14h-18h)">Après-midi (14h-18h)</option>
                                    <option value="Fin de journée">Fin de journée</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Adresse précise *</label>
                            <textarea wire:model="delivery_address" rows="2" class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm"></textarea>
                            @error('delivery_address')<p class="text-xs text-erreur mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Repère GPS ou indication (optionnel)</label>
                            <input type="text" wire:model="gps_landmark" placeholder="Ex. Près de la station Total…" class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm">
                        </div>
                    @endif
                @elseif ($step === 3)
                    <h2 class="text-xl font-bold text-ebene">Étape 3 – Mode de paiement (Simulation)</h2>
                    <div class="p-3 rounded-xl bg-or/20 text-ebene text-xs font-medium">
                        Mode démonstration : aucune donnée bancaire réelle n'est collectée ni conservée.
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        @foreach ([
                            'wave_simule' => 'Wave (simulé)',
                            'orange_money_simule' => 'Orange Money (simulé)',
                            'carte_simulee' => 'Carte bancaire (simulée)',
                            'especes' => 'Espèces à la livraison / retrait',
                        ] as $pmKey => $pmLabel)
                            <label class="flex items-center gap-3 p-4 rounded-2xl border cursor-pointer
                                {{ $payment_method === $pmKey ? 'border-foret bg-foret/10' : 'border-ebene/15' }}">
                                <input type="radio" wire:model.live="payment_method" value="{{ $pmKey }}" class="text-foret">
                                <span class="text-sm font-semibold text-ebene">{{ $pmLabel }}</span>
                            </label>
                        @endforeach
                    </div>

                    @if ($payment_method !== 'especes')
                        <div class="p-4 rounded-2xl bg-ivoire border border-ebene/10 space-y-2">
                            <p class="text-xs font-bold uppercase text-ebene/60">Résultat de la simulation</p>
                            <div class="flex gap-4 text-sm">
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="radio" wire:model="simulated_outcome" value="success" class="text-foret">
                                    Simuler un paiement réussi (Payé)
                                </label>
                                <label class="inline-flex items-center gap-2 cursor-pointer">
                                    <input type="radio" wire:model="simulated_outcome" value="failed" class="text-erreur">
                                    Simuler un échec
                                </label>
                            </div>
                        </div>
                    @endif
                @elseif ($step === 4)
                    <h2 class="text-xl font-bold text-ebene">Étape 4 – Récapitulatif et validation</h2>
                    <div class="space-y-3 text-sm text-ebene/80 bg-ivoire/60 p-5 rounded-2xl">
                        <p><strong>Client :</strong> {{ $civility }} {{ $customer_name }} ({{ $customer_phone }})</p>
                        <p><strong>Livraison :</strong> {{ ucfirst($delivery_mode) }} · {{ $delivery_city }}, {{ $delivery_country }} {{ $delivery_address ? '– ' . $delivery_address : '' }}</p>
                        <p><strong>Paiement :</strong> {{ str_replace('_', ' ', ucfirst($payment_method)) }} (simulé)</p>
                    </div>
                @endif

                <div class="flex items-center justify-between pt-4 border-t border-ebene/10">
                    @if ($step > 1)
                        <button type="button" wire:click="previousStep" class="px-5 py-3 rounded-xl border border-ebene/20 text-sm font-semibold btn-touch">
                            Précédent
                        </button>
                    @else
                        <a href="{{ route('panier') }}" class="text-sm text-ebene/60 hover:underline">Retour au panier</a>
                    @endif

                    @if ($step < 4)
                        <button type="button" wire:click="nextStep" class="px-7 py-3 rounded-xl bg-foret text-ivoire text-sm font-semibold btn-touch hover:bg-foret/90">
                            Continuer
                        </button>
                    @else
                        <button type="button" wire:click="confirmOrder" wire:loading.attr="disabled"
                                class="px-7 py-3.5 rounded-xl bg-terre text-white text-sm font-bold btn-touch hover:bg-terre/90">
                            <span wire:loading.remove wire:target="confirmOrder">Confirmer la commande</span>
                            <span wire:loading wire:target="confirmOrder">Validation en cours…</span>
                        </button>
                    @endif
                </div>
            </div>

            {{-- Résumé sticky --}}
            <aside class="lg:col-span-4 bg-white rounded-3xl border border-ebene/10 p-6 space-y-4">
                <h2 class="font-bold text-ebene">Votre commande</h2>
                <div class="divide-y divide-ebene/10 text-sm">
                    @foreach ($items as $item)
                        <div class="py-2.5 flex justify-between gap-2">
                            <span>{{ $item->product->title }} × {{ $item->quantity }}</span>
                            <span class="font-semibold shrink-0">{{ number_format($item->product->price_public * $item->quantity, 0, ',', ' ') }} FCFA</span>
                        </div>
                    @endforeach
                </div>
                <div class="border-t border-ebene/10 pt-3 space-y-1.5 text-sm">
                    <div class="flex justify-between"><span>Sous-total</span><span>{{ number_format($subtotal, 0, ',', ' ') }} FCFA</span></div>
                    @if ($discount > 0)
                        <div class="flex justify-between text-foret"><span>Remise</span><span>-{{ number_format($discount, 0, ',', ' ') }} FCFA</span></div>
                    @endif
                    <div class="flex justify-between"><span>Livraison</span><span>{{ number_format($shipping, 0, ',', ' ') }} FCFA</span></div>
                    <div class="flex justify-between text-base font-bold text-foret pt-2 border-t border-ebene/10">
                        <span>Total TTC</span>
                        <span>{{ number_format($total, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
            </aside>
        </div>
    @endif
</div>
