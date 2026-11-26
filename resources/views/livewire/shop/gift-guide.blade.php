<div class="max-w-screen-xl mx-auto px-4 py-12 space-y-10">
    <div class="text-center max-w-2xl mx-auto space-y-2">
        <span class="px-3 py-1 rounded-full bg-or text-ebene text-xs font-bold">Guide Cadeau</span>
        <h1 class="text-3xl font-bold text-ebene">Trouvez la pièce artisanale idéale</h1>
        <p class="text-sm text-ebene/65">Répondez à 3 questions simples pour obtenir une sélection personnalisée.</p>
    </div>

    <div class="bg-white rounded-3xl border border-ebene/10 p-6 grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
        <div>
            <label class="block text-xs font-bold uppercase text-ebene/60 mb-1">1. Occasion</label>
            <select wire:model.live="occasion" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                <option value="anniversaire">Anniversaire</option>
                <option value="mariage">Mariage / Pendaison de crémaillère</option>
                <option value="affaires">Cadeau d'affaires</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold uppercase text-ebene/60 mb-1">2. Budget maximum</label>
            <select wire:model.live="maxBudget" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                <option value="20000">Jusqu'à 20 000 FCFA</option>
                <option value="35000">Jusqu'à 35 000 FCFA</option>
                <option value="60000">Jusqu'à 60 000 FCFA</option>
            </select>
        </div>
        <div>
            <label class="block text-xs font-bold uppercase text-ebene/60 mb-1">3. Univers préféré</label>
            <select wire:model.live="style" class="w-full px-3 py-2.5 rounded-xl border border-ebene/20">
                <option value="tous">Tous les univers</option>
                <option value="maroquinerie">Maroquinerie</option>
                <option value="textiles">Textiles &amp; tissages</option>
                <option value="bijoux">Bijoux &amp; parures</option>
                <option value="decoration">Décoration &amp; poterie</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-5">
        @foreach ($suggestions as $product)
            <x-product-card :product="$product" />
        @endforeach
    </div>
</div>
