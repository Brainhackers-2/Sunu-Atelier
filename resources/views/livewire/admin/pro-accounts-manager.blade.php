<div class="bg-white rounded-2xl border border-ebene/10 p-5 overflow-x-auto">
    <h2 class="font-bold text-ebene mb-4">Comptes Professionnels &amp; Revendeurs</h2>
    <table class="w-full text-sm text-left">
        <thead class="text-xs uppercase text-ebene/50 border-b border-ebene/10">
            <tr>
                <th class="py-2 pr-4">Entreprise</th>
                <th class="py-2 pr-4">Activité / NINEA</th>
                <th class="py-2 pr-4">Remise</th>
                <th class="py-2 pr-4">Statut</th>
                <th class="py-2">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-ebene/10">
            @foreach ($profiles as $prof)
                <tr>
                    <td class="py-2.5 pr-4 font-semibold">{{ $prof->company_name }} <span class="block text-xs text-ebene/50">{{ $prof->whatsapp }}</span></td>
                    <td class="py-2.5 pr-4">{{ $prof->activity_type }} · {{ $prof->ninea ?? '—' }}</td>
                    <td class="py-2.5 pr-4">{{ $prof->discount_rate }} %</td>
                    <td class="py-2.5 pr-4"><span class="px-2.5 py-1 rounded-full text-xs font-semibold bg-foret/10 text-foret">{{ $prof->status }}</span></td>
                    <td class="py-2.5 space-x-2">
                        <button wire:click="approve({{ $prof->id }}, 35)" class="text-foret font-semibold hover:underline">Valider (35%)</button>
                        <button wire:click="reject({{ $prof->id }})" class="text-erreur hover:underline">Refuser</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
