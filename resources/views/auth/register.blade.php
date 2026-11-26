<x-app-layout>
    <x-slot:title>Inscription</x-slot:title>

    <section class="max-w-md mx-auto px-4 py-14">
        <div class="bg-white rounded-2xl shadow-sm border border-ebene/10 p-6 sm:p-8">
            <h1 class="text-2xl font-bold text-ebene mb-2">Créer un compte</h1>
            <p class="text-sm text-ebene/60 mb-6">Rejoignez Sunu Atelier pour suivre vos commandes et sauvegarder vos favoris.</p>

            <form method="POST" action="{{ route('register.submit') }}" class="flex flex-col gap-4">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-ebene mb-1">Nom complet</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autocomplete="name"
                        class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm focus:outline-none focus:ring-2 focus:ring-foret/40">
                    @error('name')<p class="mt-1 text-xs text-erreur">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-ebene mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm focus:outline-none focus:ring-2 focus:ring-foret/40">
                    @error('email')<p class="mt-1 text-xs text-erreur">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-ebene mb-1">Téléphone / WhatsApp</label>
                    <input id="phone" type="tel" name="phone" value="{{ old('phone') }}" placeholder="+221 77 000 00 00" required autocomplete="tel"
                        class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm focus:outline-none focus:ring-2 focus:ring-foret/40">
                    @error('phone')<p class="mt-1 text-xs text-erreur">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-ebene mb-1">Mot de passe (8 caractères min.)</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm focus:outline-none focus:ring-2 focus:ring-foret/40">
                    @error('password')<p class="mt-1 text-xs text-erreur">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-ebene mb-1">Confirmer le mot de passe</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                        class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm focus:outline-none focus:ring-2 focus:ring-foret/40">
                </div>

                <div>
                    <label class="inline-flex items-start gap-2 text-xs text-ebene/80">
                        <input type="checkbox" name="accept_cgv" value="1" class="mt-0.5 rounded border-ebene/30 text-foret focus:ring-foret" required>
                        <span>J'accepte les <a href="{{ route('cgv') }}" class="text-terre underline">Conditions Générales de Vente</a>.</span>
                    </label>
                    @error('accept_cgv')<p class="mt-1 text-xs text-erreur">{{ $message }}</p>@enderror
                </div>

                <button type="submit" class="w-full py-3 px-6 rounded-xl bg-terre text-white font-semibold text-sm btn-touch hover:bg-terre/90 transition-colors">
                    Créer mon compte
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-ebene/60">
                Déjà inscrit ?
                <a href="{{ route('login') }}" class="text-terre font-semibold hover:underline">Se connecter</a>
            </p>
        </div>
    </section>
</x-app-layout>
