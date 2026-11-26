<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded-2xl border border-ebene/10 p-5 space-y-3">
        <h2 class="font-bold text-ebene">Par moyen de paiement</h2>
        @foreach ($byPayment as $row)
            <div class="flex justify-between text-sm py-1.5 border-b border-ebene/10">
                <span>{{ $row->payment_method }} ({{ $row->count }})</span>
                <strong>{{ number_format((int) $row->total, 0, ',', ' ') }} FCFA</strong>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-ebene/10 p-5 space-y-3">
        <h2 class="font-bold text-ebene">Par mode de livraison</h2>
        @foreach ($byDelivery as $row)
            <div class="flex justify-between text-sm py-1.5 border-b border-ebene/10">
                <span>{{ $row->delivery_mode }} ({{ $row->count }})</span>
                <strong>{{ number_format((int) $row->total, 0, ',', ' ') }} FCFA</strong>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-ebene/10 p-5 space-y-3">
        <h2 class="font-bold text-ebene">Par pays</h2>
        @foreach ($byCountry as $row)
            <div class="flex justify-between text-sm py-1.5 border-b border-ebene/10">
                <span>{{ $row->delivery_country }} ({{ $row->count }})</span>
                <strong>{{ number_format((int) $row->total, 0, ',', ' ') }} FCFA</strong>
            </div>
        @endforeach
    </div>
</div>
