<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Administration' }} – Sunu Atelier</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-ivoire text-ebene antialiased" x-data="{ sidebarOpen: false }">
    <div class="min-h-screen flex">
        {{-- Sidebar Desktop --}}
        <aside class="hidden lg:flex w-64 bg-ebene text-ivoire flex-col shrink-0">
            <div class="p-5 border-b border-ivoire/10">
                <a href="{{ route('admin.dashboard') }}" class="block">
                    <span class="text-xl font-bold text-or">Sunu Atelier</span>
                    <span class="block text-[11px] text-ivoire/60 uppercase tracking-wider">Back-Office Admin</span>
                </a>
            </div>
            <nav class="flex-1 p-3 space-y-1 text-sm overflow-y-auto">
                @foreach ([
                    ['route' => 'admin.dashboard', 'label' => 'Tableau de bord', 'icon' => 'layout-dashboard'],
                    ['route' => 'admin.commandes', 'label' => 'Commandes', 'icon' => 'shopping-bag'],
                    ['route' => 'admin.produits', 'label' => 'Produits', 'icon' => 'package'],
                    ['route' => 'admin.categories', 'label' => 'Catégories', 'icon' => 'folder-tree'],
                    ['route' => 'admin.stocks', 'label' => 'Stocks', 'icon' => 'boxes'],
                    ['route' => 'admin.codes-promo', 'label' => 'Codes promo', 'icon' => 'ticket'],
                    ['route' => 'admin.clients', 'label' => 'Clients & CRM', 'icon' => 'users'],
                    ['route' => 'admin.rapports', 'label' => 'Rapports', 'icon' => 'bar-chart-3'],
                    ['route' => 'admin.reglages', 'label' => 'Réglages & Contenus', 'icon' => 'settings'],
                ] as $item)
                    <a href="{{ route($item['route']) }}"
                       class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl transition-colors
                       {{ request()->routeIs($item['route']) ? 'bg-foret text-ivoire font-semibold' : 'text-ivoire/75 hover:bg-ivoire/10' }}">
                        <i data-lucide="{{ $item['icon'] }}" class="size-4 shrink-0" aria-hidden="true"></i>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>
            <div class="p-4 border-t border-ivoire/10 space-y-2 text-xs">
                <a href="{{ route('home') }}" class="block text-center py-2 rounded-lg bg-ivoire/10 hover:bg-ivoire/20">Voir la boutique</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full py-2 rounded-lg bg-erreur/80 text-white hover:bg-erreur">Déconnexion</button>
                </form>
            </div>
        </aside>

        {{-- Contenu principal --}}
        <div class="flex-1 flex flex-col min-w-0">
            <header class="bg-white border-b border-ebene/10 h-16 px-4 sm:px-6 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <button type="button" x-on:click="sidebarOpen = !sidebarOpen" class="lg:hidden btn-touch flex items-center justify-center rounded-lg border border-ebene/15">
                        <i data-lucide="menu" class="size-5"></i>
                    </button>
                    <h1 class="font-bold text-lg text-ebene">{{ $title ?? 'Administration' }}</h1>
                </div>
                <span class="text-xs text-ebene/60">{{ auth()->user()->name }}</span>
            </header>

            {{-- Mobile Sidebar Drawer --}}
            <div x-show="sidebarOpen" class="lg:hidden fixed inset-0 z-50 flex" style="display: none">
                <div x-on:click="sidebarOpen = false" class="absolute inset-0 bg-ebene/60"></div>
                <aside class="relative w-64 bg-ebene text-ivoire h-full p-4 space-y-2 overflow-y-auto">
                    <div class="flex justify-between items-center pb-3 border-b border-ivoire/10">
                        <span class="font-bold text-or">Admin</span>
                        <button type="button" x-on:click="sidebarOpen = false" class="text-ivoire">✕</button>
                    </div>
                    @foreach ([
                        ['route' => 'admin.dashboard', 'label' => 'Tableau de bord'],
                        ['route' => 'admin.commandes', 'label' => 'Commandes'],
                        ['route' => 'admin.produits', 'label' => 'Produits'],
                        ['route' => 'admin.categories', 'label' => 'Catégories'],
                        ['route' => 'admin.stocks', 'label' => 'Stocks'],
                        ['route' => 'admin.codes-promo', 'label' => 'Codes promo'],
                        ['route' => 'admin.clients', 'label' => 'Clients'],
                        ['route' => 'admin.rapports', 'label' => 'Rapports'],
                        ['route' => 'admin.reglages', 'label' => 'Réglages'],
                    ] as $item)
                        <a href="{{ route($item['route']) }}" class="block px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs($item['route']) ? 'bg-foret text-ivoire font-semibold' : 'text-ivoire/80' }}">
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </aside>
            </div>

            <main class="flex-1 p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>
    @livewireScripts
</body>
</html>
