<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Reçu {{ $order->order_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #131622; margin: 24px; }
        .header { border-bottom: 2px solid #125B3E; padding-bottom: 12px; margin-bottom: 18px; }
        .brand { font-size: 20px; font-weight: bold; color: #125B3E; }
        .meta { font-size: 11px; color: #555; }
        .box { background: #FAF8F5; border: 1px solid #ddd; padding: 12px; border-radius: 6px; margin-bottom: 16px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
        th { background: #125B3E; color: #FAF8F5; text-align: left; padding: 8px; font-size: 11px; }
        td { border-bottom: 1px solid #e5e5e5; padding: 8px; }
        .right { text-align: right; }
        .total { font-size: 15px; font-weight: bold; color: #125B3E; }
        .qr-box { text-align: center; margin-top: 20px; padding: 14px; border: 1px dashed #125B3E; }
    </style>
</head>
<body>
    <div class="header">
        <div class="brand">{{ $brandName }}</div>
        <div class="meta">Artisanat d'exception · {{ $address }} · {{ $phone }}</div>
    </div>

    <div class="box">
        <strong>Reçu de commande : {{ $order->order_number }}</strong><br>
        Date : {{ $order->created_at->format('d/m/Y à H:i') }}<br>
        Client : {{ $order->civility }} {{ $order->customer_name }} ({{ $order->customer_phone }})<br>
        Livraison : {{ ucfirst($order->delivery_mode) }} – {{ $order->delivery_city }}, {{ $order->delivery_country }} {{ $order->delivery_address }}<br>
        Paiement : {{ str_replace('_', ' ', ucfirst($order->payment_method)) }} ({{ strtoupper($order->payment_status) }} – Simulation)
    </div>

    <table>
        <thead>
            <tr>
                <th>Création</th>
                <th>Variante</th>
                <th class="right">PU (FCFA)</th>
                <th class="right">Qté</th>
                <th class="right">Total (FCFA)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product_title }}</td>
                    <td>{{ $item->variant_label }}</td>
                    <td class="right">{{ number_format($item->unit_price, 0, ',', ' ') }}</td>
                    <td class="right">{{ $item->quantity }}</td>
                    <td class="right">{{ number_format($item->line_total, 0, ',', ' ') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table style="width: 45%; margin-left: auto;">
        <tr><td>Sous-total</td><td class="right">{{ number_format($order->subtotal, 0, ',', ' ') }} FCFA</td></tr>
        @if ($order->discount_amount > 0)
            <tr><td>Remise</td><td class="right">-{{ number_format($order->discount_amount, 0, ',', ' ') }} FCFA</td></tr>
        @endif
        <tr><td>Frais de livraison</td><td class="right">{{ number_format($order->shipping_amount, 0, ',', ' ') }} FCFA</td></tr>
        <tr class="total"><td>Total TTC</td><td class="right">{{ number_format($order->total_amount, 0, ',', ' ') }} FCFA</td></tr>
    </table>

    <div class="qr-box">
        <img src="{{ $qrDataUri }}" alt="QR Code suivi" style="width: 140px; height: 140px;"><br>
        <div style="font-size: 11px; margin-top: 6px;">À présenter au livreur lors de la remise du colis</div>
    </div>
</body>
</html>
