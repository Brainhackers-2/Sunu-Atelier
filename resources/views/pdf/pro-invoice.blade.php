<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Facture Pro {{ $order->order_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #131622; margin: 24px; }
        .top { border-bottom: 2px solid #125B3E; padding-bottom: 10px; margin-bottom: 16px; }
        .brand { font-size: 18px; font-weight: bold; color: #125B3E; }
        .grid { width: 100%; margin-bottom: 16px; }
        .grid td { vertical-align: top; width: 50%; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        table.items th { background: #125B3E; color: #FAF8F5; padding: 7px; text-align: left; }
        table.items td { border-bottom: 1px solid #ddd; padding: 7px; }
        .right { text-align: right; }
        .stamp { margin-top: 24px; padding: 10px; border: 1px solid #125B3E; width: 220px; text-align: center; font-size: 10px; color: #125B3E; }
    </style>
</head>
<body>
    <div class="top">
        <div class="brand">{{ $brandName }} – FACTURE COMMERCIALE PRO</div>
        <div>Normes OHADA / Sénégal · Dakar, Sénégal</div>
    </div>

    <table class="grid">
        <tr>
            <td>
                <strong>Facturé à :</strong><br>
                {{ $profile?->company_name ?? $order->customer_name }}<br>
                NINEA : {{ $profile?->ninea ?? 'Non renseigné' }}<br>
                RC : {{ $profile?->trade_register ?? 'Non renseigné' }}<br>
                {{ $profile?->address ?? $order->delivery_address }}
            </td>
            <td class="right">
                <strong>Facture N° :</strong> FAC-{{ $order->order_number }}<br>
                <strong>Date :</strong> {{ $order->created_at->format('d/m/Y') }}<br>
                <strong>Statut :</strong> {{ strtoupper($order->payment_status) }}
            </td>
        </tr>
    </table>

    <table class="items">
        <thead>
            <tr>
                <th>Désignation</th>
                <th class="right">PU HT (FCFA)</th>
                <th class="right">Qté</th>
                <th class="right">Total HT (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_title }} ({{ $item->sku }})</td>
                    <td class="right">{{ number_format($item->unit_price, 0, ',', ' ') }}</td>
                    <td class="right">{{ $item->quantity }}</td>
                    <td class="right">{{ number_format($item->line_total, 0, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 45%; margin-left: auto;">
        <tr><td>Total HT</td><td class="right">{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</td></tr>
        <tr><td>TVA (exonéré / régime artisanal)</td><td class="right">0 FCFA</td></tr>
        <tr><td><strong>Total TTC</strong></td><td class="right"><strong>{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</strong></td></tr>
    </table>

    <div class="stamp">
        <strong>Cachet {{ $brandName }}</strong><br>
        Conditions : Paiement comptant ou à la livraison.
    </div>
</body>
</html>
