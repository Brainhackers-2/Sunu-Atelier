<x-app-layout>
    <x-slot:title>Contact &amp; Atelier-boutique</x-slot:title>
    @php
        $shopAddress = \App\Models\Setting::getValue('shop_address_1', 'Dakar Plateau, Sénégal');
        $waPhone = \App\Models\Setting::getValue('whatsapp_number', '+221 77 000 00 00');
        $waDigits = preg_replace('/\D+/', '', $waPhone);
        $contactEmail = \App\Models\Setting::getValue('contact_email', 'contact@sunuatelier.sn');
    @endphp

    <section class="bg-gradient-to-br from-foret to-ebene text-ivoire py-12">
        <div class="max-w-screen-xl mx-auto px-4 space-y-2">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-or text-ebene text-xs font-bold">
                <i data-lucide="message-circle" class="size-3.5" aria-hidden="true"></i>
                Atelier-boutique Dakar
            </span>
            <h1 class="text-3xl sm:text-4xl font-bold">Contactez Sunu Atelier</h1>
            <p class="text-sm sm:text-base text-ivoire/80 max-w-2xl">Une question sur une pièce, une commande sur mesure ou une livraison au Sénégal et à l'international ?</p>
        </div>
    </section>

    <section class="max-w-screen-xl mx-auto px-4 py-12 grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        <div class="lg:col-span-5 space-y-4">
            <div class="bg-white rounded-2xl border border-ebene/10 p-5 flex items-start gap-4 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-foret/10 text-foret flex items-center justify-center shrink-0">
                    <i data-lucide="map-pin" class="size-5" aria-hidden="true"></i>
                </div>
                <div>
                    <h2 class="font-bold text-ebene text-sm">Atelier-boutique</h2>
                    <p class="text-sm text-ebene/75 mt-0.5">{{ $shopAddress }}</p>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-ebene/10 p-5 flex items-start gap-4 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-whatsapp/15 text-foret flex items-center justify-center shrink-0">
                    <i data-lucide="phone" class="size-5" aria-hidden="true"></i>
                </div>
                <div class="space-y-2">
                    <h2 class="font-bold text-ebene text-sm">WhatsApp &amp; Téléphone</h2>
                    <p class="text-sm text-ebene/75">{{ $waPhone }}</p>
                    <a href="https://wa.me/{{ $waDigits }}" target="_blank" rel="noopener noreferrer"
                       class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-whatsapp text-white text-xs font-semibold hover:opacity-90 transition-opacity">
                        <i data-lucide="message-circle" class="size-4" aria-hidden="true"></i>
                        Discuter sur WhatsApp
                    </a>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-ebene/10 p-5 flex items-start gap-4 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-terre/10 text-terre flex items-center justify-center shrink-0">
                    <i data-lucide="mail" class="size-5" aria-hidden="true"></i>
                </div>
                <div>
                    <h2 class="font-bold text-ebene text-sm">Email</h2>
                    <a href="mailto:{{ $contactEmail }}" class="text-sm text-terre font-medium hover:underline mt-0.5 inline-block">{{ $contactEmail }}</a>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-ebene/10 p-5 flex items-start gap-4 shadow-sm">
                <div class="w-10 h-10 rounded-xl bg-or/20 text-ebene flex items-center justify-center shrink-0">
                    <i data-lucide="clock" class="size-5" aria-hidden="true"></i>
                </div>
                <div>
                    <h2 class="font-bold text-ebene text-sm">Horaires d'ouverture</h2>
                    <p class="text-sm text-ebene/75 mt-0.5">Lundi – Samedi, 9h – 18h (Africa/Dakar)</p>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8 shadow-sm">
            <h2 class="text-xl font-bold text-ebene mb-1">Envoyer un message</h2>
            <p class="text-xs text-ebene/60 mb-5">Notre équipe vous répond sous 24h ouvrées.</p>
            <livewire:community.contact-form />
        </div>
    </section>
</x-app-layout>
