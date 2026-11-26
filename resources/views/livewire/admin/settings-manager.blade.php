<form wire:submit="save" class="max-w-3xl bg-white rounded-2xl border border-ebene/10 p-6 space-y-6 text-sm">
    @if ($saved)
        <div class="p-3 rounded-xl bg-foret/10 text-foret font-semibold">Réglages et contenus enregistrés.</div>
    @endif

    <div class="space-y-4">
        <h2 class="font-bold text-base text-ebene">Coordonnées de l'enseigne</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-medium mb-1">Nom de l'enseigne</label>
                <input type="text" wire:model="brand_name" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Numéro WhatsApp</label>
                <input type="text" wire:model="whatsapp_number" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Email officiel</label>
                <input type="email" wire:model="contact_email" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Adresse atelier-boutique</label>
                <input type="text" wire:model="shop_address_1" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
            </div>
        </div>
    </div>

    <div class="space-y-4 border-t border-ebene/10 pt-4">
        <h2 class="font-bold text-base text-ebene">Contenus du site modifiables</h2>
        <div>
            <label class="block text-xs font-medium mb-1">Titre du Hero (Accueil)</label>
            <input type="text" wire:model="hero_title" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
        </div>
        <div>
            <label class="block text-xs font-medium mb-1">Sous-titre du Hero</label>
            <textarea wire:model="hero_subtitle" rows="2" class="w-full px-3 py-2 rounded-xl border border-ebene/20"></textarea>
        </div>
        <div>
            <label class="block text-xs font-medium mb-1">Titre « Notre histoire »</label>
            <input type="text" wire:model="history_title" class="w-full px-3 py-2 rounded-xl border border-ebene/20">
        </div>
        <div>
            <label class="block text-xs font-medium mb-1">Texte « Notre histoire »</label>
            <textarea wire:model="history_body" rows="3" class="w-full px-3 py-2 rounded-xl border border-ebene/20"></textarea>
        </div>
    </div>

    <button type="submit" class="px-6 py-3 rounded-xl bg-foret text-ivoire font-semibold btn-touch">Enregistrer</button>
</form>
