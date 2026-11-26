<x-app-layout>
    <x-slot:title>Contact &amp; Atelier-boutique</x-slot:title>
    <section class="max-w-screen-xl mx-auto px-4 py-12 grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-5 space-y-6">
            <h1 class="text-3xl font-bold text-ebene">Contactez Sunu Atelier</h1>
            <p class="text-sm text-ebene/70">Une question sur une pièce, une livraison au Sénégal ou à l'international ?</p>
            <div class="bg-white rounded-2xl border border-ebene/10 p-6 space-y-3 text-sm">
                <p><strong>Atelier-boutique :</strong> {{ \App\Models\Setting::getValue('shop_address_1', 'Dakar Plateau, Sénégal') }}</p>
                <p><strong>WhatsApp :</strong> {{ \App\Models\Setting::getValue('whatsapp_number', '+221 77 000 00 00') }}</p>
                <p><strong>Email :</strong> {{ \App\Models\Setting::getValue('contact_email', 'contact@sunuatelier.sn') }}</p>
                <p><strong>Horaires :</strong> Lundi – Samedi, 9h – 18h (Africa/Dakar)</p>
            </div>
        </div>
        <div class="lg:col-span-7 bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8">
            <h2 class="text-xl font-bold text-ebene mb-4">Envoyer un message</h2>
            <livewire:community.contact-form />
        </div>
    </section>
</x-app-layout>
