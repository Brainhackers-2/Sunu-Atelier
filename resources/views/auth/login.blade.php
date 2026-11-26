<x-app-layout>
    <x-slot:title>Connexion</x-slot:title>

    <section class="max-w-md mx-auto px-4 py-14">
        <div class="bg-white rounded-2xl shadow-sm border border-ebene/10 p-6 sm:p-8">
            <h1 class="text-2xl font-bold text-ebene mb-2">Connexion</h1>
            <p class="text-sm text-ebene/60 mb-6">Accédez à vos commandes, adresses et favoris.</p>

            @if (session('status'))
                <div class="mb-4 p-3 rounded-xl bg-foret/10 text-foret text-sm flex items-center gap-2" role="status">
                    <i data-lucide="circle-check" class="size-4 shrink-0" aria-hidden="true"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('login.submit') }}" class="flex flex-col gap-4">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-ebene mb-1">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="email"
                        class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm focus:outline-none focus:ring-2 focus:ring-foret/40">
                    @error('email')
                        <p class="mt-1 text-xs text-erreur flex items-center gap-1" role="alert">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-ebene mb-1">Mot de passe</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-3 rounded-xl border border-ebene/20 bg-ivoire/40 text-sm focus:outline-none focus:ring-2 focus:ring-foret/40">
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="inline-flex items-center gap-2 text-ebene/80">
                        <input type="checkbox" name="remember" class="rounded border-ebene/30 text-foret focus:ring-foret">
                        Se souvenir de moi
                    </label>
                    <a href="{{ route('password.request') }}" class="text-terre hover:underline">Mot de passe oublié ?</a>
                </div>

                <button type="submit" class="w-full py-3 px-6 rounded-xl bg-terre text-white font-semibold text-sm btn-touch hover:bg-terre/90 transition-colors">
                    Se connecter
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-ebene/60">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="text-terre font-semibold hover:underline">Créer un compte</a>
            </p>
        </div>
    </section>
</x-app-layout>
