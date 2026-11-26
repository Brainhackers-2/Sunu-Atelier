<x-app-layout>
    <x-slot:title>Notre histoire</x-slot:title>
    <section class="bg-foret text-ivoire py-14">
        <div class="max-w-screen-xl mx-auto px-4 space-y-3">
            <h1 class="text-3xl sm:text-4xl font-bold">{{ $content?->title ?? 'Notre Histoire & Nos Artisans' }}</h1>
            <p class="text-sm sm:text-base text-ivoire/80 max-w-2xl">{{ $content?->subtitle ?? 'Rémunération juste, matières durables et savoir-faire transmis.' }}</p>
        </div>
    </section>

    <section class="max-w-screen-xl mx-auto px-4 py-12 space-y-12">
        <div class="bg-white rounded-3xl border border-ebene/10 p-6 sm:p-10 text-ebene/80 leading-relaxed">
            {{ $content?->body }}
        </div>

        <div>
            <h2 class="text-2xl font-bold text-ebene mb-6">Nos Maîtres Artisans Partenaires</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($artisans as $artisan)
                    <article class="bg-white rounded-2xl border border-ebene/10 p-6 space-y-2">
                        <span class="px-2.5 py-1 rounded-full bg-or text-ebene text-xs font-bold">{{ $artisan->village }}</span>
                        <h3 class="text-lg font-bold text-ebene pt-1">{{ $artisan->name }}</h3>
                        <p class="text-xs font-semibold text-foret">{{ $artisan->craft_specialty }}</p>
                        <p class="text-sm text-ebene/75">{{ $artisan->bio }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-app-layout>
