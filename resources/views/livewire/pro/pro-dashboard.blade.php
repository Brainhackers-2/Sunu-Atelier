<div class="max-w-screen-xl mx-auto px-4 py-10 space-y-10">
    @if (! $user || $user->role !== 'pro')
        {{-- Hero B2B --}}
        <section class="relative rounded-3xl overflow-hidden bg-gradient-to-br from-foret to-ebene text-ivoire p-8 sm:p-12 shadow-xl">
            <img src="{{ asset('images/categories/decoration.jpg') }}" alt="Artisanat sénégalais pour professionnels" class="absolute inset-0 w-full h-full object-cover opacity-20">
            <div class="relative z-10 max-w-2xl space-y-5">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-or text-ebene text-xs font-bold">
                    <i data-lucide="briefcase" class="size-3.5" aria-hidden="true"></i>
                    Programme B2B · Revendeurs &amp; Hôtellerie
                </span>
                <h1 class="text-3xl sm:text-4xl font-bold leading-tight">Espace Professionnel Sunu Atelier</h1>
                <p class="text-sm sm:text-base text-ivoire/85 leading-relaxed">
                    Équipez vos boutiques, hôtels, restaurants et concept-stores avec des pièces artisanales sénégalaises authentiques. Bénéficiez de tarifs dégressifs jusqu'à <strong>-35 %</strong> et de factures commerciales conformes OHADA.
                </p>
                <div class="flex flex-wrap gap-3 pt-1">
                    <a href="{{ route('pro.inscription') }}" class="px-6 py-3 rounded-xl bg-or text-ebene font-bold text-sm hover:bg-or/90 transition-colors btn-touch inline-flex items-center gap-2">
                        Devenir Revendeur
                        <i data-lucide="arrow-right" class="size-4" aria-hidden="true"></i>
                    </a>
                    <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl bg-ivoire/15 text-ivoire border border-ivoire/25 font-semibold text-sm hover:bg-ivoire/25 transition-colors btn-touch inline-flex items-center gap-2">
                        Se connecter
                    </a>
                </div>
            </div>
        </section>

        {{-- Avantages Pro --}}
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @foreach ([
                ['icon' => 'percent', 'title' => 'Tarifs de gros dédiés', 'desc' => 'Remises professionnelles jusqu’à -35 % dès la validation de votre compte.'],
                ['icon' => 'file-text', 'title' => 'Facturation OHADA PDF', 'desc' => 'Téléchargez instantanément vos factures commerciales avec NINEA et RC.'],
                ['icon' => 'layers', 'title' => 'Séries & sur-mesure', 'desc' => 'Commandes en volume et personnalisation directe avec nos maîtres artisans.'],
                ['icon' => 'globe', 'title' => 'Export & Dakar 24h', 'desc' => 'Expédition rapide au Sénégal, en Afrique de l’Ouest, en Europe et en Amérique.'],
            ] as $perk)
                <div class="bg-white rounded-2xl border border-ebene/10 p-6 space-y-2.5 shadow-sm">
                    <div class="w-10 h-10 rounded-xl bg-foret/10 text-foret flex items-center justify-center">
                        <i data-lucide="{{ $perk['icon'] }}" class="size-5" aria-hidden="true"></i>
                    </div>
                    <h2 class="font-bold text-ebene text-base">{{ $perk['title'] }}</h2>
                    <p class="text-xs text-ebene/70 leading-relaxed">{{ $perk['desc'] }}</p>
                </div>
            @endforeach
        </section>
    @elseif (! $user->isProApproved())
        <div class="bg-or/15 border border-or rounded-3xl p-8 sm:p-10 text-center space-y-3 max-w-2xl mx-auto">
            <div class="w-12 h-12 rounded-2xl bg-or text-ebene flex items-center justify-center mx-auto">
                <i data-lucide="clock" class="size-6" aria-hidden="true"></i>
            </div>
            <h1 class="text-2xl font-bold text-ebene">Compte en attente de validation</h1>
            <p class="text-sm text-ebene/75">Établissement : <strong>{{ $profile?->company_name }}</strong> · Statut : <span class="uppercase font-semibold">{{ $profile?->status }}</span></p>
            <p class="text-xs text-ebene/65">Notre équipe vérifie votre dossier sous 24h ouvrées et active vos tarifs professionnels.</p>
        </div>
    @else
        <div class="bg-gradient-to-br from-foret to-ebene text-ivoire rounded-3xl p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-lg">
            <div>
                <span class="px-3 py-1 rounded-full bg-or text-ebene text-xs font-bold">Compte Pro Actif</span>
                <h1 class="text-2xl sm:text-3xl font-bold mt-2">{{ $profile->company_name }}</h1>
                <p class="text-sm text-ivoire/80 mt-1">NINEA : {{ $profile->ninea ?? '—' }} · Remise accordée : <strong>-{{ $profile->discount_rate }} %</strong></p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('pro.commander') }}" class="px-5 py-2.5 rounded-xl bg-or text-ebene font-bold text-xs sm:text-sm btn-touch inline-flex items-center gap-1.5">Passer commande</a>
                <a href="{{ route('pro.factures') }}" class="px-5 py-2.5 rounded-xl bg-ivoire/15 text-ivoire font-semibold text-xs sm:text-sm btn-touch inline-flex items-center gap-1.5">Mes factures PDF</a>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-ebene/10 p-6 overflow-x-auto shadow-sm">
            <h2 class="font-bold text-ebene text-lg mb-4">Catalogue Tarifs de Gros (FCFA)</h2>
            <table class="w-full text-sm text-left">
                <thead class="text-xs uppercase text-ebene/50 border-b border-ebene/10">
                    <tr>
                        <th class="py-2 pr-4">Création</th>
                        <th class="py-2 pr-4">Catégorie</th>
                        <th class="py-2 pr-4">Prix public</th>
                        <th class="py-2">Prix Pro (gros)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ebene/10">
                    @foreach ($products as $p)
                        <tr class="hover:bg-ivoire/50">
                            <td class="py-2.5 pr-4 font-semibold">{{ $p->title }}</td>
                            <td class="py-2.5 pr-4">{{ $p->category?->name }}</td>
                            <td class="py-2.5 pr-4 line-through text-ebene/50">{{ number_format($p->price_public, 0, ',', ' ') }} FCFA</td>
                            <td class="py-2.5 font-bold text-foret">{{ number_format($p->price_pro ?? $p->price_public, 0, ',', ' ') }} FCFA</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
