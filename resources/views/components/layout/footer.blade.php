{{--
    Pied de page – Sunu Atelier
    Référence BéaLux : 4 colonnes desktop, barre légale inférieure.
    Cahier v1.3 (1.3) : Identité, Liens rapides, Service client, Newsletter.
--}}
@php
    $phone   = config('app.phone', '+221 XX XXX XX XX');
    $email   = config('app.email', 'contact@sunuatelier.sn');
    $address = config('app.address', 'Dakar, Sénégal');
    $wa      = config('app.whatsapp_number', '221XXXXXXXXX');
@endphp

<footer class="bg-ebene text-ivoire" aria-label="Pied de page">

    {{-- ── Colonnes principales ───────────────────── --}}
    <div class="max-w-screen-xl mx-auto px-4 py-14 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">

        {{-- Colonne 1 : Identité de marque --}}
        <div class="flex flex-col gap-4">
            <a href="{{ route('home') }}" class="inline-block" aria-label="Sunu Atelier – Accueil">
                <span class="text-2xl font-bold text-ivoire">Sunu Atelier</span>
                <span class="block text-[10px] tracking-widest text-ivoire/50 uppercase mt-0.5">Artisanat d'exception</span>
            </a>
            <p class="text-sm text-ivoire/70 leading-relaxed">
                Pièces artisanales authentiques du Sénégal – maroquinerie, textiles, bijoux et décoration.
                Faites main, pour vous et pour le monde.
            </p>
            <address class="not-italic text-sm text-ivoire/60 flex items-start gap-2">
                <i data-lucide="map-pin" class="size-4 shrink-0 mt-0.5" aria-hidden="true"></i>
                {{ $address }}
            </address>
        </div>

        {{-- Colonne 2 : Liens rapides --}}
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-widest text-or mb-5">Liens rapides</h3>
            <ul class="flex flex-col gap-3 text-sm text-ivoire/70" role="list">
                @foreach ([
                    ['label' => 'Boutique',           'route' => 'boutique'],
                    ['label' => 'Guide cadeau',        'route' => 'guide-cadeau'],
                    ['label' => 'Suivre ma commande',  'route' => 'suivi'],
                    ['label' => 'Espace Professionnel','route' => 'pro'],
                    ['label' => 'Notre histoire',      'route' => 'notre-histoire'],
                    ['label' => 'Avis clients',        'route' => 'avis'],
                ] as $link)
                    <li>
                        <a href="{{ route($link['route']) }}"
                           class="hover:text-or transition-colors inline-flex items-center gap-1.5 group">
                            <i data-lucide="chevron-right"
                               class="size-3.5 text-ivoire/30 group-hover:text-or transition-colors"
                               aria-hidden="true"></i>
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- Colonne 3 : Service client --}}
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-widest text-or mb-5">Service client</h3>
            <ul class="flex flex-col gap-3 text-sm text-ivoire/70" role="list">
                <li>
                    <a href="tel:{{ preg_replace('/\s+/', '', $phone) }}"
                       class="flex items-center gap-2 hover:text-or transition-colors">
                        <i data-lucide="phone" class="size-4 text-or shrink-0" aria-hidden="true"></i>
                        {{ $phone }}
                    </a>
                </li>
                <li>
                    <a href="mailto:{{ $email }}"
                       class="flex items-center gap-2 hover:text-or transition-colors">
                        <i data-lucide="mail" class="size-4 text-or shrink-0" aria-hidden="true"></i>
                        {{ $email }}
                    </a>
                </li>
                <li>
                    <a href="https://wa.me/{{ $wa }}?text={{ rawurlencode('Bonjour Sunu Atelier !') }}"
                       target="_blank" rel="noopener noreferrer"
                       class="flex items-center gap-2 text-whatsapp hover:text-green-300 transition-colors">
                        <i data-lucide="message-circle" class="size-4 shrink-0" aria-hidden="true"></i>
                        WhatsApp
                    </a>
                </li>
                <li class="mt-2 text-ivoire/50">
                    <i data-lucide="clock" class="size-4 inline mr-1 text-or" aria-hidden="true"></i>
                    Lun – Sam · 9h – 18h (Dakar)
                </li>
            </ul>
        </div>

        {{-- Colonne 4 : Newsletter (Livewire) --}}
        <div>
            <h3 class="text-sm font-semibold uppercase tracking-widest text-or mb-5">Restez informé</h3>
            <p class="text-sm text-ivoire/70 mb-4">
                Nouvelles créations, promotions et coulisses de l'atelier directement dans votre boîte mail.
            </p>
            <livewire:layout.newsletter-form />
        </div>

    </div>

    {{-- ── Barre inférieure ───────────────────────── --}}
    <div class="border-t border-ivoire/10">
        <div class="max-w-screen-xl mx-auto px-4 py-5 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-ivoire/40">

            <span>© {{ date('Y') }} Sunu Atelier · Tous droits réservés</span>

            <nav aria-label="Liens légaux" class="flex items-center gap-4 flex-wrap justify-center">
                <a href="{{ route('mentions-legales') }}" class="hover:text-or transition-colors">Mentions légales</a>
                <a href="{{ route('cgv') }}" class="hover:text-or transition-colors">CGV</a>
                <a href="{{ route('contact') }}" class="hover:text-or transition-colors">Contact</a>
            </nav>

            {{-- Badges moyens de paiement (simulés) --}}
            <div class="flex items-center gap-2 text-ivoire/30" aria-label="Moyens de paiement acceptés">
                <i data-lucide="credit-card" class="size-5" aria-hidden="true"></i>
                <span class="text-[10px] uppercase tracking-wider">Carte · Wave · Orange Money · Espèces</span>
            </div>

        </div>
    </div>

</footer>
