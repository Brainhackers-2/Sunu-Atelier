<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    {{-- Profil & Mot de passe --}}
    <div class="lg:col-span-5 space-y-6">
        <form wire:submit="updateProfile" class="bg-white rounded-2xl border border-ebene/10 p-6 space-y-4">
            <h2 class="font-bold text-ebene">Mon profil</h2>
            <div>
                <label class="block text-xs font-medium mb-1">Nom complet</label>
                <input type="text" wire:model="name" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20 text-sm">
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Téléphone / WhatsApp</label>
                <input type="text" wire:model="phone" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20 text-sm">
            </div>
            <button type="submit" class="px-5 py-2.5 rounded-xl bg-foret text-ivoire text-sm font-semibold btn-touch">Enregistrer</button>
        </form>

        <form wire:submit="updatePassword" class="bg-white rounded-2xl border border-ebene/10 p-6 space-y-4">
            <h2 class="font-bold text-ebene">Changer mon mot de passe</h2>
            <input type="password" wire:model="new_password" placeholder="Nouveau mot de passe (8 car. min)" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20 text-sm">
            @error('new_password')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
            <input type="password" wire:model="new_password_confirmation" placeholder="Confirmer" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20 text-sm">
            <button type="submit" class="px-5 py-2.5 rounded-xl border border-ebene/20 text-sm font-semibold btn-touch">Mettre à jour</button>
        </form>

        {{-- Carnet d'adresses --}}
        <div class="bg-white rounded-2xl border border-ebene/10 p-6 space-y-4">
            <h2 class="font-bold text-ebene">Carnet d'adresses</h2>
            @foreach ($addresses as $addr)
                <div class="p-3 rounded-xl bg-ivoire flex items-start justify-between gap-2 text-sm">
                    <div>
                        <p class="font-semibold">{{ $addr->label }} · {{ $addr->city }}</p>
                        <p class="text-xs text-ebene/65">{{ $addr->address_line }}</p>
                    </div>
                    <button wire:click="deleteAddress({{ $addr->id }})" class="text-xs text-erreur hover:underline">Supprimer</button>
                </div>
            @endforeach

            <form wire:submit="addAddress" class="space-y-2 pt-2 border-t border-ebene/10">
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" wire:model="addr_label" placeholder="Libellé" class="px-3 py-2 rounded-xl border border-ebene/20 text-xs">
                    <input type="text" wire:model="addr_city" placeholder="Ville" class="px-3 py-2 rounded-xl border border-ebene/20 text-xs">
                </div>
                <input type="text" wire:model="addr_line" placeholder="Adresse complète" class="w-full px-3 py-2 rounded-xl border border-ebene/20 text-xs">
                <button type="submit" class="px-4 py-2 rounded-xl bg-ebene text-ivoire text-xs font-semibold">Ajouter une adresse</button>
            </form>
        </div>
    </div>

    {{-- Historique des commandes --}}
    <div class="lg:col-span-7 bg-white rounded-2xl border border-ebene/10 p-6 space-y-4">
        <h2 class="font-bold text-ebene">Historique de mes commandes ({{ $orders->count() }})</h2>
        @forelse ($orders as $order)
            <div class="p-4 rounded-2xl border border-ebene/10 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div>
                    <p class="font-bold text-ebene">{{ $order->order_number }}</p>
                    <p class="text-xs text-ebene/60">{{ $order->created_at->format('d/m/Y H:i') }} · {{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</p>
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <span class="px-2.5 py-1 rounded-full bg-foret/10 text-foret text-xs font-semibold">{{ ucfirst(str_replace('_', ' ', $order->status)) }}</span>
                    <a href="{{ route('suivi.token', $order->tracking_token) }}" class="px-3 py-1.5 rounded-lg border border-ebene/20 text-xs font-semibold hover:bg-ebene/5">Suivi</a>
                    <a href="{{ route('confirmation', $order->tracking_token) }}" class="px-3 py-1.5 rounded-lg bg-terre text-white text-xs font-semibold">Reçu</a>
                </div>
            </div>
        @empty
            <p class="text-sm text-ebene/60">Vous n'avez pas encore passé de commande.</p>
        @endforelse
    </div>
</div>
