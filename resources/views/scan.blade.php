<x-app-layout>
    <x-slot:title>Scan commande</x-slot:title>
    <div class="max-w-3xl mx-auto px-4 pt-6">
        <div class="p-3 rounded-xl bg-foret/10 text-foret text-xs font-semibold text-center">
            Consultation QR en lecture seule (V1) · La validation livreur est réservée au rôle livreur en V2.
        </div>
    </div>
    <livewire:tracking.order-tracking :token="$token" />
</x-app-layout>
