<x-app-layout>
    <x-slot:title>Mentions légales</x-slot:title>
    <section class="max-w-3xl mx-auto px-4 py-12 space-y-4 text-sm text-ebene/80 leading-relaxed">
        <h1 class="text-3xl font-bold text-ebene mb-4">Mentions légales</h1>
        <p><strong>Éditeur :</strong> Sunu Atelier – Plateforme e-commerce artisanale (Dakar, Sénégal).</p>
        <p><strong>Contact :</strong> {{ \App\Models\Setting::getValue('contact_email', 'contact@sunuatelier.sn') }} · {{ \App\Models\Setting::getValue('whatsapp_number', '+221 77 000 00 00') }}</p>
        <p><strong>Protection des données :</strong> Traitement conforme aux exigences de la Commission de Protection des Données Personnelles (CDP Sénégal).</p>
    </section>
</x-app-layout>
