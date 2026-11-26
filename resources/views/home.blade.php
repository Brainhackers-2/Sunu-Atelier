<x-app-layout>
    <x-slot:title>Accueil</x-slot:title>

    {{-- Section 1 : Hero (sera enrichi Phase 5) --}}
    <section class="bg-ivoire min-h-[60vh] flex items-center justify-center">
        <div class="text-center max-w-2xl mx-auto px-4 py-24">
            <h1 class="text-4xl sm:text-5xl font-bold text-ebene mb-4">L'Art des Mains d'Afrique</h1>
            <p class="text-ebene/60 text-lg mb-8">Pièces artisanales authentiques du Sénégal</p>
            <a href="{{ route('boutique') }}" class="inline-flex items-center gap-2 px-8 py-4 rounded-xl bg-terre text-white font-semibold text-sm btn-touch hover:bg-terre/90 transition-colors">
                Explorer la collection
            </a>
        </div>
    </section>

</x-app-layout>
