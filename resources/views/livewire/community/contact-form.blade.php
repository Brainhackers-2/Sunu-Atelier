<div>
    @if ($sent)
        <div class="p-4 rounded-xl bg-foret/10 text-foret text-sm font-semibold">Merci ! Votre message a bien été envoyé à notre équipe.</div>
    @else
        <form wire:submit="send" class="space-y-4 text-sm">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium mb-1">Nom complet *</label>
                    <input type="text" wire:model="name" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                    @error('name')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Email *</label>
                    <input type="email" wire:model="email" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                    @error('email')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-medium mb-1">Téléphone / WhatsApp</label>
                    <input type="tel" wire:model="phone" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Sujet *</label>
                    <input type="text" wire:model="subject" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                    @error('subject')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Message *</label>
                <textarea wire:model="message" rows="4" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20"></textarea>
                @error('message')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
            </div>
            <button type="submit" class="px-6 py-3 rounded-xl bg-terre text-white font-semibold btn-touch">Envoyer le message</button>
        </form>
    @endif
</div>
