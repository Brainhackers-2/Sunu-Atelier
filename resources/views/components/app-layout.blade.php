<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name') }} – Artisanat d'exception</title>
    <meta name="description" content="{{ $metaDescription ?? 'Sunu Atelier – Découvrez des créations artisanales authentiques du Sénégal : maroquinerie, textiles, bijoux et décoration. Pièces faites main, livraison Dakar et international.' }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    {{-- CSS + JS compilés par Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Livewire styles --}}
    @livewireStyles
</head>
<body class="bg-ivoire text-ebene antialiased overflow-x-hidden">

    {{-- ═══════════════════════════════════════════
         Bandeau supérieur (ticker de réassurance)
    ═══════════════════════════════════════════ --}}
    <x-layout.top-bar />

    {{-- ═══════════════════════════════════════════
         Navigation principale (sticky)
    ═══════════════════════════════════════════ --}}
    <x-layout.navbar />

    {{-- ═══════════════════════════════════════════
         Tiroir panier (global, Livewire)
    ═══════════════════════════════════════════ --}}
    <livewire:layout.cart-drawer />

    {{-- ═══════════════════════════════════════════
         Contenu principal
    ═══════════════════════════════════════════ --}}
    <main id="main-content">
        {{ $slot }}
    </main>

    {{-- ═══════════════════════════════════════════
         Pied de page
    ═══════════════════════════════════════════ --}}
    <x-layout.footer />

    {{-- Notifications / toasts (Alpine.js) --}}
    <div
        x-data="{ toasts: [] }"
        x-on:toast.window="toasts.push($event.detail); setTimeout(() => toasts.shift(), 3500)"
        class="fixed top-20 right-4 z-[200] flex flex-col gap-2"
        role="status" aria-live="polite"
    >
        <template x-for="toast in toasts" :key="toast.id">
            <div
                x-show="true"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-end="opacity-0 translate-x-8"
                :class="toast.type === 'success' ? 'bg-foret text-ivoire' : 'bg-erreur text-white'"
                class="flex items-center gap-3 px-4 py-3 rounded-xl shadow-lg text-sm font-medium min-w-[260px]"
            >
                <i :data-lucide="toast.type === 'success' ? 'circle-check' : 'circle-x'" class="size-5 shrink-0"></i>
                <span x-text="toast.message"></span>
            </div>
        </template>
    </div>

    {{-- Livewire scripts --}}
    @livewireScripts
</body>
</html>
