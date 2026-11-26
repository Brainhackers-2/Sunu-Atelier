{{--
    Bandeau supérieur – Sunu Atelier
    Référence BéaLux : barre sombre pleine largeur, mentions livraison/paiement, lien téléphone.
    Différence cahier v1.3 : ticker de réassurance animé (CSS marquee) + lien WhatsApp.
--}}
@php
    $items = [
        'Livraison Dakar 24h &amp; régions',
        'Expédition internationale',
        'Paiement sécurisé',
        'Pièces faites main',
    ];
    $phone = config('app.phone', '+221 XX XXX XX XX');
    $whatsapp = config('app.whatsapp_number', '221XXXXXXXXX');
@endphp

<div class="bg-foret text-ivoire text-xs" role="banner">
    <div class="max-w-screen-xl mx-auto px-4 h-9 flex items-center justify-between gap-4">

        {{-- Ticker de réassurance (desktop) --}}
        <div class="hidden xs:flex items-center gap-6 overflow-hidden">
            @foreach ($items as $item)
                <span class="flex items-center gap-1.5 shrink-0">
                    <i data-lucide="check-circle" class="size-3.5 text-or shrink-0" aria-hidden="true"></i>
                    {!! $item !!}
                </span>
            @endforeach
        </div>

        {{-- Mobile : un seul message rotatif --}}
        <div
            class="xs:hidden overflow-hidden h-full flex items-center"
            x-data="{ items: @js($items), current: 0 }"
            x-init="setInterval(() => { current = (current + 1) % items.length }, 3000)"
        >
            <template x-for="(item, i) in items" :key="i">
                <span
                    x-show="current === i"
                    x-transition:enter="transition duration-300"
                    x-transition:enter-start="opacity-0 -translate-y-2"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-html="item"
                    class="flex items-center gap-1.5"
                ></span>
            </template>
        </div>

        {{-- Contact + WhatsApp --}}
        <div class="flex items-center gap-3 shrink-0">
            <a
                href="tel:{{ preg_replace('/\s+/', '', $phone) }}"
                class="flex items-center gap-1 hover:text-or transition-colors"
                aria-label="Appeler le {{ $phone }}"
            >
                <i data-lucide="phone" class="size-3.5" aria-hidden="true"></i>
                <span class="hidden sm:inline">{{ $phone }}</span>
            </a>
            <a
                href="https://wa.me/{{ $whatsapp }}?text={{ rawurlencode('Bonjour Sunu Atelier, je souhaite renseignements sur vos créations artisanales.') }}"
                target="_blank" rel="noopener noreferrer"
                class="flex items-center gap-1 text-whatsapp hover:text-green-300 transition-colors"
                aria-label="Contacter par WhatsApp"
            >
                <i data-lucide="message-circle" class="size-3.5" aria-hidden="true"></i>
                <span class="hidden sm:inline">WhatsApp</span>
            </a>
        </div>

    </div>
</div>
