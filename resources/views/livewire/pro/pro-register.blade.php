<div class="max-w-2xl mx-auto px-4 py-12">
    @if ($submitted)
        <div class="bg-foret text-ivoire rounded-3xl p-8 text-center space-y-3">
            <h1 class="text-2xl font-bold">Demande enregistrée !</h1>
            <p class="text-sm text-ivoire/85">Votre dossier professionnel est actuellement <strong>en attente de validation</strong> par notre équipe.</p>
            <a href="{{ route('pro.index') }}" class="inline-flex px-6 py-3 rounded-xl bg-or text-ebene font-bold text-sm btn-touch">Accéder à mon espace Pro</a>
        </div>
    @else
        <div class="bg-white rounded-3xl border border-ebene/10 p-6 sm:p-8 shadow-sm">
            <h1 class="text-2xl font-bold text-ebene mb-2">Devenir Revendeur Agréé</h1>
            <p class="text-sm text-ebene/65 mb-6">Boutiques, hôtels, décorateurs et exportateurs : bénéficiez de -25 % à -45 % sur nos créations.</p>

            <form wire:submit="register" class="space-y-4 text-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium mb-1">Raison sociale *</label>
                        <input type="text" wire:model="company_name" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                        @error('company_name')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Type d'activité *</label>
                        <select wire:model="activity_type" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                            <option value="boutique">Boutique</option>
                            <option value="hotel">Hôtel / Restaurant</option>
                            <option value="decorateur">Décorateur / Architecte</option>
                            <option value="exportateur">Exportateur / Grossiste</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">NINEA</label>
                        <input type="text" wire:model="ninea" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Registre de commerce</label>
                        <input type="text" wire:model="trade_register" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Responsable *</label>
                        <input type="text" wire:model="contact_name" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                        @error('contact_name')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">WhatsApp *</label>
                        <input type="tel" wire:model="whatsapp" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                        @error('whatsapp')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Email professionnel *</label>
                        <input type="email" wire:model="email" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                        @error('email')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Volume mensuel estimé</label>
                        <input type="text" wire:model="estimated_monthly_volume" placeholder="Ex. 500 000 FCFA" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                    </div>
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Adresse complète *</label>
                    <input type="text" wire:model="address" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                    @error('address')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-medium mb-1">Mot de passe *</label>
                        <input type="password" wire:model="password" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                        @error('password')<p class="text-xs text-erreur">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium mb-1">Confirmer *</label>
                        <input type="password" wire:model="password_confirmation" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                    </div>
                </div>
                <button type="submit" class="w-full py-3.5 rounded-xl bg-foret text-ivoire font-bold btn-touch">Envoyer ma demande Pro</button>
            </form>
        </div>
    @endif
</div>
