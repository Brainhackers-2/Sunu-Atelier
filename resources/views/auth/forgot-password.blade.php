<x-app-layout>
    <x-slot:title>Mot de passe oublié</x-slot:title>

    <section class="max-w-md mx-auto px-4 py-14">
        <div class="bg-white rounded-2xl shadow-sm border border-ebene/10 p-6 sm:p-8">
            <h1 class="text-2xl font-bold text-ebene mb-2">Mot de passe oublié</h1>
            <p class="text-sm text-ebene/60 mb-6">Entrez votre adresse email pour recevoir un lien de réinitialisation.</p>

            <form method="POST" action="{{ route('password.request') }}" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-ebene mb-1">Email</label>
                    <input id="email" type="email" name="email" required autocomplete="email"
                        class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm focus:outline-none focus:ring-2 focus:ring-foret/40">
                </div>
                <button type="submit" class="w-full py-3 px-6 rounded-xl bg-terre text-white font-semibold text-sm btn-touch hover:bg-terre/90 transition-colors">
                    Envoyer le lien
                </button>
            </form>
        </div>
    </section>
</x-app-layout>
