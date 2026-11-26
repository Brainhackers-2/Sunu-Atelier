<x-app-layout>
    <x-slot:title>Demande de devis Pro</x-slot:title>
    <section class="max-w-2xl mx-auto px-4 py-10 space-y-6">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-bold text-ebene">Demande de devis grand volume / export</h1>
            <a href="{{ route('pro.index') }}" class="text-sm text-terre font-semibold hover:underline">← Retour</a>
        </div>
        <div class="bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8">
            <livewire:community.contact-form />
        </div>
    </section>
</x-app-layout>
