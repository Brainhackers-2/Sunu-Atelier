<x-app-layout>
    <x-slot:title>Mon compte</x-slot:title>

    <section class="max-w-screen-xl mx-auto px-4 py-12">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-ebene">Bonjour, {{ auth()->user()->name }}</h1>
                <p class="text-sm text-ebene/60">{{ auth()->user()->email }} · {{ auth()->user()->phone ?? 'Téléphone non renseigné' }}</p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl border border-ebene/20 text-sm font-medium hover:bg-ebene/5 btn-touch">
                    <i data-lucide="log-out" class="size-4" aria-hidden="true"></i>
                    Se déconnecter
                </button>
            </form>
        </div>

        <livewire:account.account-dashboard />
    </section>
</x-app-layout>
