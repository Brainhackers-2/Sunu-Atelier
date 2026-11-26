<x-app-layout>
    <x-slot:title>Accueil</x-slot:title>

    {{-- ════════════════════════════════════════════════════════════════
         Section 1 – Hero prestige (2 colonnes desktop, 1 colonne mobile)
    ════════════════════════════════════════════════════════════════ --}}
    <section class="bg-ivoire border-b border-ebene/10">
        <div class="max-w-screen-xl mx-auto px-4 py-12 lg:py-20 grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
            <div class="lg:col-span-6 space-y-6 gs-reveal">
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-foret/10 text-foret text-xs font-semibold">
                    <i data-lucide="sparkles" class="size-3.5" aria-hidden="true"></i>
                    Artisanat sénégalais authentique
                </span>

                <h1 class="text-4xl sm:text-5xl font-bold text-ebene leading-tight tracking-tight">
                    {{ $hero?->title ?? "L'Art des Mains d'Afrique" }}
                </h1>

                <p class="text-base sm:text-lg text-ebene/70 leading-relaxed max-w-xl">
                    {{ $hero?->subtitle ?? 'Pièces artisanales authentiques du Sénégal : maroquinerie, textiles, bijoux et poteries façonnés à la main.' }}
                </p>

                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('boutique') }}"
                       class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl bg-terre text-white font-semibold text-sm btn-touch hover:bg-terre/90 transition-colors">
                        <i data-lucide="shopping-bag" class="size-4" aria-hidden="true"></i>
                        Explorer la collection
                    </a>
                    <a href="{{ route('guide-cadeau') }}"
                       class="inline-flex items-center justify-center gap-2 px-6 py-3.5 rounded-xl border border-foret text-foret font-semibold text-sm btn-touch hover:bg-foret/5 transition-colors">
                        <i data-lucide="gift" class="size-4" aria-hidden="true"></i>
                        Trouver le cadeau idéal
                    </a>
                </div>

                {{-- Pastilles de réassurance --}}
                <div class="flex flex-wrap items-center gap-4 pt-2 text-xs font-medium text-ebene/75">
                    <span class="inline-flex items-center gap-1.5"><i data-lucide="hand" class="size-4 text-foret" aria-hidden="true"></i> Fait main</span>
                    <span class="inline-flex items-center gap-1.5"><i data-lucide="gem" class="size-4 text-foret" aria-hidden="true"></i> Pièces uniques</span>
                    <span class="inline-flex items-center gap-1.5"><i data-lucide="leaf" class="size-4 text-foret" aria-hidden="true"></i> Matières locales</span>
                </div>
            </div>

            {{-- Visuel vitrine + mini-carte produit superposée (structure BéaLux) --}}
            <div class="lg:col-span-6 relative gs-reveal">
                <div class="aspect-[4/3] rounded-3xl bg-gradient-to-br from-foret to-ebene p-8 flex flex-col justify-between text-ivoire shadow-xl overflow-hidden">
                    <div class="flex items-center justify-between">
                        <img src="{{ asset('images/logo-sunu-atelier.png') }}" alt="Logo Sunu Atelier" class="h-14 w-14 rounded-2xl object-cover bg-ivoire p-1">
                        <span class="px-3 py-1 rounded-full bg-or text-ebene text-xs font-bold">Collection Sénégal</span>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-widest text-or mb-1">Savoir-faire local</p>
                        <p class="text-2xl font-bold leading-snug">Dakar · Thiès · Saint-Louis · Casamance</p>
                    </div>
                </div>

                @if ($bestsellers->first())
                    @php $featured = $bestsellers->first(); @endphp
                    <a href="{{ route('produit', $featured->slug) }}"
                       class="mt-4 sm:mt-0 sm:absolute sm:-bottom-5 sm:left-6 bg-white rounded-2xl p-4 shadow-lg border border-ebene/10 flex items-center gap-4 max-w-xs hover:border-terre transition-colors">
                        <div class="w-12 h-12 rounded-xl bg-foret/10 text-foret font-bold flex items-center justify-center shrink-0">
                            {{ strtoupper(substr($featured->category?->name ?? 'SA', 0, 2)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs text-terre font-semibold">Coup de cœur</p>
                            <p class="text-sm font-bold text-ebene truncate">{{ $featured->title }}</p>
                            <p class="text-xs font-bold text-foret">{{ $featured->formattedPrice() }}</p>
                        </div>
                    </a>
                @endif
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════
         Section 2 – Les 4 piliers de réassurance (4 cols desktop, 2×2 mobile)
    ════════════════════════════════════════════════════════════════ --}}
    <section class="bg-white border-b border-ebene/10">
        <div class="max-w-screen-xl mx-auto px-4 py-10 grid grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ([
                ['icon' => 'truck', 'title' => 'Livraison rapide & internationale', 'desc' => 'Dakar 24h, régions 48-72h, monde sous quelques jours.'],
                ['icon' => 'shield-check', 'title' => 'Paiement sécurisé', 'desc' => 'Carte simulée, Wave, Orange Money ou espèces à la livraison.'],
                ['icon' => 'award', 'title' => 'Authenticité garantie', 'desc' => 'Pièces faites main avec certificat d’artisan local.'],
                ['icon' => 'message-circle', 'title' => 'Conseillers dédiés', 'desc' => 'Aide au choix, personnalisation et commandes sur mesure.'],
            ] as $pillar)
                <div class="p-4 rounded-2xl bg-ivoire/70 border border-ebene/5 flex flex-col gap-2 gs-reveal">
                    <div class="w-10 h-10 rounded-xl bg-foret/10 text-foret flex items-center justify-center">
                        <i data-lucide="{{ $pillar['icon'] }}" class="size-5" aria-hidden="true"></i>
                    </div>
                    <h2 class="text-sm font-bold text-ebene">{{ $pillar['title'] }}</h2>
                    <p class="text-xs text-ebene/65 leading-relaxed">{{ $pillar['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════
         Section 3 – Univers et catégories phares (4 cols desktop, 2×2 mobile)
    ════════════════════════════════════════════════════════════════ --}}
    <section class="max-w-screen-xl mx-auto px-4 py-14">
        <div class="text-center max-w-xl mx-auto mb-10">
            <h2 class="text-2xl sm:text-3xl font-bold text-ebene">Nos Univers Artisanaux</h2>
            <p class="text-sm text-ebene/65 mt-2">Explorez nos quatre grandes familles de créations façonnées au Sénégal.</p>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach ($categories as $cat)
                <a href="{{ route('boutique', ['cat' => $cat->slug]) }}"
                   class="group relative rounded-2xl overflow-hidden bg-foret text-ivoire p-6 min-h-[180px] flex flex-col justify-between shadow-sm hover:shadow-lg transition-all gs-reveal">
                    <span class="w-10 h-10 rounded-xl bg-ivoire/15 flex items-center justify-center text-or group-hover:scale-110 transition-transform">
                        <i data-lucide="compass" class="size-5" aria-hidden="true"></i>
                    </span>
                    <div>
                        <h3 class="font-bold text-base sm:text-lg leading-snug group-hover:text-or transition-colors">{{ $cat->name }}</h3>
                        <p class="text-xs text-ivoire/75 mt-1 line-clamp-2">{{ $cat->description }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════
         Section 4 – Créations Coup de Cœur (3 cols desktop, 2 cols mobile)
    ════════════════════════════════════════════════════════════════ --}}
    <section class="bg-white/60 border-y border-ebene/10">
        <div class="max-w-screen-xl mx-auto px-4 py-14">
            <div class="flex items-end justify-between gap-4 mb-8">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-ebene">Nos Créations Coup de Cœur</h2>
                    <p class="text-sm text-ebene/65 mt-1">Les pièces les plus appréciées de nos ateliers.</p>
                </div>
                <a href="{{ route('boutique') }}" class="text-sm font-semibold text-terre hover:underline shrink-0 inline-flex items-center gap-1">
                    Tout voir <i data-lucide="arrow-right" class="size-4" aria-hidden="true"></i>
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
                @foreach ($bestsellers as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════
         Section 5 – Espace Professionnels (bloc contrasté vert forêt)
    ════════════════════════════════════════════════════════════════ --}}
    <section class="max-w-screen-xl mx-auto px-4 py-14">
        <div class="rounded-3xl bg-foret text-ivoire p-8 sm:p-12 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-8 space-y-3">
                <span class="inline-block px-3 py-1 rounded-full bg-or text-ebene text-xs font-bold">B2B &amp; Export</span>
                <h2 class="text-2xl sm:text-3xl font-bold">Espace Professionnels &amp; Revendeurs</h2>
                <p class="text-sm sm:text-base text-ivoire/80 max-w-2xl">
                    Boutiques, hôtels, décorateurs et exportateurs : profitez de remises dégressives de <strong>-25 % à -45 %</strong>, de commandes par lots et d'un accompagnement sur mesure.
                </p>
            </div>
            <div class="lg:col-span-4 flex lg:justify-end">
                <a href="{{ route('pro.inscription') }}"
                   class="inline-flex items-center justify-center gap-2 px-7 py-4 rounded-xl bg-or text-ebene font-bold text-sm btn-touch hover:bg-or/90 transition-colors">
                    <i data-lucide="briefcase" class="size-4" aria-hidden="true"></i>
                    Devenir Revendeur Agréé
                </a>
            </div>
        </div>
    </section>

    {{-- ════════════════════════════════════════════════════════════════
         Section 6 – WhatsApp direct
    ════════════════════════════════════════════════════════════════ --}}
    <section class="bg-white border-t border-ebene/10">
        <div class="max-w-2xl mx-auto px-4 py-14 text-center space-y-4">
            <div class="w-14 h-14 rounded-2xl bg-whatsapp/15 text-foret flex items-center justify-center mx-auto">
                <i data-lucide="message-circle" class="size-7" aria-hidden="true"></i>
            </div>
            <h2 class="text-2xl sm:text-3xl font-bold text-ebene">Une pièce en tête ? Parlons-en</h2>
            <p class="text-sm text-ebene/70">
                Besoin d'un conseil sur les dimensions, les matières ou une livraison internationale ? Un conseiller artisan vous répond directement sur WhatsApp.
            </p>
            <a href="https://wa.me/{{ $whatsappNumber }}?text={{ rawurlencode('Bonjour Sunu Atelier, je souhaite échanger avec un conseiller artisan.') }}"
               target="_blank" rel="noopener noreferrer"
               class="inline-flex items-center justify-center gap-2 px-7 py-3.5 rounded-xl bg-whatsapp text-ebene font-bold text-sm btn-touch hover:opacity-90 transition-opacity">
                <i data-lucide="message-circle" class="size-4" aria-hidden="true"></i>
                Échanger avec un conseiller artisan
            </a>
        </div>
    </section>

    {{-- GSAP fade-in-up respectant prefers-reduced-motion --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            if (window.matchMedia('(prefers-reduced-motion: reduce)').matches || !window.gsap) return;
            window.gsap.utils.toArray('.gs-reveal').forEach((el) => {
                window.gsap.from(el, {
                    y: 20,
                    opacity: 0,
                    duration: 0.55,
                    ease: 'power2.out',
                    scrollTrigger: { trigger: el, start: 'top 90%', once: true }
                });
            });
        });
    </script>
</x-app-layout>
