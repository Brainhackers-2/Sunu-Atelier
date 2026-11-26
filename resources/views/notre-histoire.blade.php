<x-app-layout>
    <x-slot:title>Notre histoire</x-slot:title>

    {{-- Hero éditorial --}}
    <section class="relative bg-gradient-to-br from-foret to-ebene text-ivoire py-16 overflow-hidden">
        <img src="{{ asset('images/categories/textiles.jpg') }}" alt="Artisanat sénégalais" class="absolute inset-0 w-full h-full object-cover opacity-20">
        <div class="relative z-10 max-w-screen-xl mx-auto px-4 grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
            <div class="lg:col-span-7 space-y-4">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-or text-ebene text-xs font-bold">
                    <i data-lucide="heart-handshake" class="size-3.5" aria-hidden="true"></i>
                    Savoir-faire du Sénégal
                </span>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold leading-tight">{{ $content?->title ?? 'Notre Histoire & Nos Artisans' }}</h1>
                <p class="text-sm sm:text-base text-ivoire/85 max-w-2xl leading-relaxed">{{ $content?->subtitle ?? 'Rémunération juste, matières durables et savoir-faire transmis.' }}</p>
            </div>
            <div class="lg:col-span-5 hidden lg:block">
                <div class="rounded-3xl overflow-hidden border border-ivoire/15 shadow-2xl aspect-[4/3]">
                    <img src="{{ asset('images/categories/bijoux.jpg') }}" alt="Atelier Sunu Atelier" class="w-full h-full object-cover">
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-screen-xl mx-auto px-4 py-12 space-y-12">
        {{-- Manifeste & engagements --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">
            <div class="lg:col-span-7 bg-white rounded-3xl border border-ebene/10 p-7 sm:p-10 space-y-4 shadow-sm flex flex-col justify-center">
                <h2 class="text-2xl font-bold text-ebene">Relier les ateliers du Sénégal au monde</h2>
                <p class="text-sm sm:text-base text-ebene/80 leading-relaxed">
                    {{ $content?->body ?? 'Sunu Atelier valorise le savoir-faire des maîtres artisans de Dakar, Thiès, Saint-Louis, Ziguinchor et du Sine-Saloum.' }}
                </p>
                <p class="text-sm text-ebene/70 leading-relaxed">
                    Chaque pièce est sélectionnée directement auprès de nos ateliers partenaires, avec une rémunération équitable, des matières naturelles locales et un contrôle qualité exigeant avant chaque expédition.
                </p>
            </div>
            <div class="lg:col-span-5 grid grid-cols-1 gap-4">
                @foreach ([
                    ['icon' => 'award', 'title' => 'Rémunération juste', 'desc' => 'Partenariat direct sans intermédiaire avec nos maîtres artisans.'],
                    ['icon' => 'leaf', 'title' => 'Matières nobles & locales', 'desc' => 'Cuir pleine fleur, coton bio tissé main, laiton recyclé et argile de Casamance.'],
                    ['icon' => 'shield-check', 'title' => 'Authenticité certifiée', 'desc' => 'Chaque création est accompagnée de son certificat d’origine Sunu Atelier.'],
                ] as $val)
                    <div class="bg-white rounded-2xl border border-ebene/10 p-5 flex items-start gap-4 shadow-sm">
                        <div class="w-10 h-10 rounded-xl bg-foret/10 text-foret flex items-center justify-center shrink-0">
                            <i data-lucide="{{ $val['icon'] }}" class="size-5" aria-hidden="true"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-ebene text-sm">{{ $val['title'] }}</h3>
                            <p class="text-xs text-ebene/70 mt-1 leading-relaxed">{{ $val['desc'] }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Artisans --}}
        <div>
            <div class="flex flex-wrap items-end justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-ebene">Nos Maîtres Artisans Partenaires</h2>
                    <p class="text-sm text-ebene/65 mt-1">Les visages et les mains derrière nos créations.</p>
                </div>
                <a href="{{ route('boutique') }}" class="text-sm font-semibold text-terre hover:underline inline-flex items-center gap-1">
                    Découvrir leurs créations <i data-lucide="arrow-right" class="size-4" aria-hidden="true"></i>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($artisans as $artisan)
                    <article class="bg-white rounded-2xl border border-ebene/10 p-6 space-y-3 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center justify-between gap-2">
                            <div class="w-11 h-11 rounded-xl bg-foret text-ivoire font-bold flex items-center justify-center text-sm shrink-0">
                                {{ strtoupper(substr($artisan->name, 0, 2)) }}
                            </div>
                            <span class="px-3 py-1 rounded-full bg-or/25 text-ebene text-xs font-bold">{{ $artisan->village }}</span>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-ebene">{{ $artisan->name }}</h3>
                            <p class="text-xs font-semibold text-foret">{{ $artisan->craft_specialty }}</p>
                        </div>
                        <p class="text-sm text-ebene/75 leading-relaxed">{{ $artisan->bio }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
