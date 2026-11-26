<div>
    @if ($submitted)
        <div class="flex items-center gap-3 p-4 rounded-xl bg-foret/20 text-ivoire text-sm" role="alert">
            <i data-lucide="circle-check" class="size-5 text-or shrink-0" aria-hidden="true"></i>
            <span>Merci ! Vous êtes inscrit à notre newsletter.</span>
        </div>
    @else
        <form wire:submit="subscribe" class="flex flex-col gap-3" novalidate>
            <div>
                <label for="newsletter-email" class="sr-only">Votre adresse email</label>
                <input
                    id="newsletter-email"
                    type="email"
                    wire:model="email"
                    placeholder="votre@email.com"
                    class="w-full px-4 py-3 rounded-xl bg-white/10 border border-ivoire/20 text-ivoire placeholder-ivoire/40 text-sm focus:outline-none focus:ring-2 focus:ring-or/50"
                    autocomplete="email"
                    required
                    aria-describedby="newsletter-error"
                >
                @error('email')
                    <p id="newsletter-error" class="mt-1 text-xs text-red-300" role="alert">{{ $message }}</p>
                @enderror
            </div>
            <button
                type="submit"
                class="flex items-center justify-center gap-2 py-3 px-5 rounded-xl bg-or text-ebene font-semibold text-sm btn-touch hover:bg-or/90 transition-colors"
            >
                <i data-lucide="send" class="size-4" aria-hidden="true"></i>
                S'inscrire
            </button>
        </form>
    @endif
</div>
