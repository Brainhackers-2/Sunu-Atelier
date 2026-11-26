<x-app-layout>
    <x-slot:title>Administration – Connexion</x-slot:title>

    <section class="max-w-md mx-auto px-4 py-14">
        <div class="bg-white rounded-2xl shadow-sm border border-ebene/10 p-6 sm:p-8">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-foret/10 text-foret text-xs font-semibold mb-4">
                <i data-lucide="shield-check" class="size-4" aria-hidden="true"></i>
                Espace Administrateur
            </div>
            <h1 class="text-2xl font-bold text-ebene mb-6">Connexion Back-Office</h1>

            <form method="POST" action="{{ route('admin.login.submit') }}" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label for="admin-email" class="block text-sm font-medium text-ebene mb-1">Email administrateur</label>
                    <input id="admin-email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm focus:outline-none focus:ring-2 focus:ring-foret/40">
                    @error('email')<p class="mt-1 text-xs text-erreur">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="admin-password" class="block text-sm font-medium text-ebene mb-1">Mot de passe</label>
                    <input id="admin-password" type="password" name="password" required
                        class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm focus:outline-none focus:ring-2 focus:ring-foret/40">
                </div>
                <button type="submit" class="w-full py-3 px-6 rounded-xl bg-foret text-ivoire font-semibold text-sm btn-touch hover:bg-foret/90 transition-colors">
                    Accéder au back-office
                </button>
            </form>
        </div>
    </section>
</x-app-layout>
