{{--
    Barre de navigation principale – Sunu Atelier
    Référence BéaLux : sticky, logo gauche, liens centre (5), actions droite (recherche, favoris, panier badge, compte).
    Cahier v1.3 (1.2) : 6 liens (Accueil, Boutique, Pro, Notre histoire, Avis, Contact), sélecteurs langue/devise en V2 seulement.
--}}

@php
    $navLinks = [
        ['label' => 'Accueil',        'route' => 'home',         'icon' => 'home'],
        ['label' => 'Boutique',       'route' => 'boutique',     'icon' => 'shopping-bag'],
        ['label' => 'Pro',            'route' => 'pro',          'icon' => 'briefcase'],
        ['label' => 'Notre histoire', 'route' => 'notre-histoire','icon' => 'book-open'],
        ['label' => 'Avis',           'route' => 'avis',         'icon' => 'star'],
        ['label' => 'Contact',        'route' => 'contact',      'icon' => 'mail'],
    ];
@endphp

<header
    x-data="{
        mobileMenuOpen: false,
        searchOpen: false,
        scrolled: false,
    }"
    x-on:scroll.window="scrolled = window.scrollY > 10"
    :class="scrolled ? 'shadow-md' : ''"
    class="sticky top-0 z-50 bg-ivoire transition-shadow duration-200"
    role="navigation"
    aria-label="Navigation principale"
>
    <div class="max-w-screen-xl mx-auto px-3 sm:px-4 h-16 sm:h-[72px] flex items-center justify-between gap-2 sm:gap-4">

        {{-- ── Logo ───────────────────────────────── --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-2.5 min-w-0 group" aria-label="Sunu Atelier – Accueil">
            <img src="{{ asset('images/logo-sunu-atelier.png') }}" alt="Logo Sunu Atelier" class="h-9 w-9 sm:h-11 sm:w-11 rounded-xl object-contain shrink-0">
            <div class="flex flex-col leading-tight min-w-0">
                <span class="text-base sm:text-xl font-bold text-foret tracking-tight group-hover:text-terre transition-colors truncate">
                    Sunu Atelier
                </span>
                <span class="text-[9px] sm:text-[10px] text-ebene/60 tracking-wider sm:tracking-widest uppercase truncate">Artisanat d'exception</span>
            </div>
        </a>

        {{-- ── Liens desktop ─────────────────────── --}}
        <nav class="hidden lg:flex items-center gap-1" aria-label="Liens de navigation">
            @foreach ($navLinks as $link)
                <a
                    href="{{ route($link['route']) }}"
                    class="px-3 py-2 rounded-full text-sm font-medium transition-colors
                        {{ request()->routeIs($link['route'])
                            ? 'bg-foret text-ivoire'
                            : 'text-ebene hover:bg-foret/10 hover:text-foret' }}"
                    @if(request()->routeIs($link['route'])) aria-current="page" @endif
                >
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        {{-- ── Actions rapides ───────────────────── --}}
        <div class="flex items-center gap-0.5 sm:gap-1 shrink-0">

            {{-- Recherche --}}
            <button
                type="button"
                x-on:click="searchOpen = true; $nextTick(() => $refs.searchInput?.focus())"
                class="btn-touch flex items-center justify-center rounded-full hover:bg-foret/10 text-ebene hover:text-foret transition-colors"
                aria-label="Ouvrir la recherche"
            >
                <i data-lucide="search" class="size-5" aria-hidden="true"></i>
            </button>

            {{-- Favoris (desktop) --}}
            <a
                href="{{ route('favoris') }}"
                class="hidden sm:flex btn-touch items-center justify-center rounded-full hover:bg-foret/10 text-ebene hover:text-foret transition-colors"
                aria-label="Mes favoris"
            >
                <i data-lucide="heart" class="size-5" aria-hidden="true"></i>
            </a>

            {{-- Panier avec badge (Livewire) --}}
            <livewire:layout.cart-badge />

            {{-- Compte --}}
            @auth
                <a
                    href="{{ route('mon-compte') }}"
                    class="btn-touch flex items-center justify-center rounded-full hover:bg-foret/10 text-ebene hover:text-foret transition-colors"
                    aria-label="Mon compte"
                >
                    <i data-lucide="user" class="size-5" aria-hidden="true"></i>
                </a>
            @else
                <a
                    href="{{ route('login') }}"
                    class="hidden sm:flex btn-touch items-center justify-center rounded-full hover:bg-foret/10 text-ebene hover:text-foret transition-colors"
                    aria-label="Se connecter"
                >
                    <i data-lucide="user" class="size-5" aria-hidden="true"></i>
                </a>
            @endauth

            {{-- Burger mobile --}}
            <button
                type="button"
                x-on:click="mobileMenuOpen = true"
                class="lg:hidden btn-touch flex items-center justify-center rounded-full hover:bg-foret/10 text-ebene"
                aria-label="Ouvrir le menu"
                :aria-expanded="mobileMenuOpen"
                aria-controls="mobile-menu"
            >
                <i data-lucide="menu" class="size-6" aria-hidden="true"></i>
            </button>
        </div>

    </div>

    {{-- ── Overlay de recherche ──────────────────── --}}
    <div
        x-show="searchOpen"
        x-transition:enter="transition duration-200"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition duration-150"
        x-transition:leave-end="opacity-0"
        x-on:keydown.escape.window="searchOpen = false"
        x-on:click.self="searchOpen = false"
        class="fixed inset-0 z-[100] bg-ebene/60 flex items-start justify-center pt-24 px-4"
        style="display: none"
        role="dialog" aria-modal="true" aria-label="Recherche"
    >
        <div class="bg-ivoire rounded-2xl shadow-2xl w-full max-w-xl p-4">
            <livewire:layout.search-modal />
        </div>
    </div>

    {{-- ── Tiroir de navigation mobile ──────────── --}}
    <div
        id="mobile-menu"
        x-show="mobileMenuOpen"
        x-transition:enter="transition duration-300 ease-out"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition duration-200 ease-in"
        x-transition:leave-end="-translate-x-full"
        x-on:keydown.escape.window="mobileMenuOpen = false"
        class="fixed inset-0 z-[100] flex"
        style="display: none"
        role="dialog" aria-modal="true" aria-label="Menu mobile"
    >
        {{-- Arrière-plan sombre --}}
        <div
            x-on:click="mobileMenuOpen = false"
            class="absolute inset-0 bg-ebene/60"
            aria-hidden="true"
        ></div>

        {{-- Tiroir --}}
        <nav class="relative w-72 max-w-[85vw] bg-ivoire h-full flex flex-col shadow-2xl">
            {{-- En-tête tiroir --}}
            <div class="flex items-center justify-between p-4 border-b border-ebene/10">
                <div class="flex items-center gap-2">
                    <img src="{{ asset('images/logo-sunu-atelier.png') }}" alt="Logo Sunu Atelier" class="h-8 w-8 rounded-lg object-contain">
                    <span class="font-bold text-foret text-lg">Sunu Atelier</span>
                </div>
                <button
                    type="button"
                    x-on:click="mobileMenuOpen = false"
                    class="btn-touch flex items-center justify-center rounded-full hover:bg-foret/10 text-ebene"
                    aria-label="Fermer le menu"
                >
                    <i data-lucide="x" class="size-5" aria-hidden="true"></i>
                </button>
            </div>

            {{-- Liens --}}
            <ul class="flex-1 overflow-y-auto py-3" role="list">
                @foreach ($navLinks as $link)
                    <li>
                        <a
                            href="{{ route($link['route']) }}"
                            class="flex items-center gap-3 px-5 py-3 text-sm font-medium transition-colors
                                {{ request()->routeIs($link['route'])
                                    ? 'bg-foret/10 text-foret border-l-4 border-foret'
                                    : 'text-ebene hover:bg-foret/5 hover:text-foret' }}"
                            x-on:click="mobileMenuOpen = false"
                        >
                            <i data-lucide="{{ $link['icon'] }}" class="size-4 shrink-0" aria-hidden="true"></i>
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
                <li class="border-t border-ebene/10 mt-2 pt-2">
                    <a
                        href="{{ route('favoris') }}"
                        class="flex items-center gap-3 px-5 py-3 text-sm font-medium text-ebene hover:bg-foret/5 hover:text-foret transition-colors"
                        x-on:click="mobileMenuOpen = false"
                    >
                        <i data-lucide="heart" class="size-4 shrink-0" aria-hidden="true"></i>
                        Mes favoris
                    </a>
                </li>
                <li>
                    <a
                        href="{{ route('suivi') }}"
                        class="flex items-center gap-3 px-5 py-3 text-sm font-medium text-ebene hover:bg-foret/5 hover:text-foret transition-colors"
                        x-on:click="mobileMenuOpen = false"
                    >
                        <i data-lucide="package-search" class="size-4 shrink-0" aria-hidden="true"></i>
                        Suivre ma commande
                    </a>
                </li>
            </ul>

            {{-- Pied du tiroir --}}
            <div class="p-4 border-t border-ebene/10 flex flex-col gap-2">
                @auth
                    <a
                        href="{{ route('mon-compte') }}"
                        class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-foret text-ivoire text-sm font-semibold btn-touch"
                    >
                        <i data-lucide="user" class="size-4" aria-hidden="true"></i>
                        Mon compte
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="flex items-center justify-center gap-2 px-4 py-3 rounded-xl bg-foret text-ivoire text-sm font-semibold btn-touch"
                    >
                        <i data-lucide="log-in" class="size-4" aria-hidden="true"></i>
                        Se connecter
                    </a>
                @endauth
            </div>
        </nav>
    </div>

</header>
