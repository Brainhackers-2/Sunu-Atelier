<div class="max-w-screen-xl mx-auto px-4 py-10 space-y-8">
    @if (! $user || $user->role !== 'pro')
        <div class="bg-white rounded-3xl border border-ebene/10 p-8 text-center space-y-4">
            <h1 class="text-2xl font-bold text-ebene">Espace Professionnel Sunu Atelier</h1>
            <p class="text-sm text-ebene/65">Réservé aux revendeurs, boutiques, hôtels et exportateurs agréés.</p>
            <div class="flex justify-center gap-3">
                <a href="{{ route('login') }}" class="px-6 py-3 rounded-xl bg-foret text-ivoire font-semibold text-sm btn-touch">Se connecter</a>
                <a href="{{ route('pro.inscription') }}" class="px-6 py-3 rounded-xl bg-or text-ebene font-bold text-sm btn-touch">Devenir Revendeur</a>
            </div>
        </div>
    @elseif (! $user->isProApproved())
        <div class="bg-or/20 border border-or rounded-3xl p-8 text-center space-y-2">
            <h1 class="text-2xl font-bold text-ebene">Compte en attente de validation</h1>
            <p class="text-sm text-ebene/75">Établissement : <strong>{{ $profile?->company_name }}</strong> · Statut : {{ $profile?->status }}</p>
        </div>
    @else
        <div class="bg-foret text-ivoire rounded-3xl p-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <span class="px-3 py-1 rounded-full bg-or text-ebene text-xs font-bold">Compte Pro Actif</span>
                <h1 class="text-2xl font-bold mt-2">{{ $profile->company_name }}</h1>
                <p class="text-sm text-ivoire/80">NINEA : {{ $profile->ninea ?? '—' }} · Remise accordée : <strong>-{{ $profile->discount_rate }} %</strong></p>
            </div>
        </div>

        <div class="bg-white rounded-3xl border border-ebene/10 p-6 overflow-x-auto">
            <h2 class="font-bold text-ebene mb-4">Catalogue Tarifs de Gros (FCFA)</h2>
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
                        <tr>
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
