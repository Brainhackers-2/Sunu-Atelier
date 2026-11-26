<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Feuille de route livreur – Sunu Atelier</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; color: #131622; }
        h1 { color: #125B3E; font-size: 16px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th { background: #125B3E; color: #FAF8F5; padding: 6px; text-align: left; }
        td { border-bottom: 1px solid #ddd; padding: 6px; vertical-align: middle; }
        .cash { font-weight: bold; color: #C2410C; }
    </style>
</head>
<body>
    <h1>Feuille de route livreur – {{ now()->format('d/m/Y') }}</h1>
    <table>
        <thead>
            <tr>
                <th>QR</th>
                <th>N° Commande</th>
                <th>Client &amp; Téléphone</th>
                <th>Adresse &amp; Repère</th>
                <th>À encaisser</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    <td><img src="{{ $row['qr'] }}" style="width: 60px; height: 60px;"></td>
                    <td><strong>{{ $row['order']->order_number }}</strong></td>
                    <td>{{ $row['order']->customer_name }}<br>{{ $row['order']->customer_phone }}</td>
                    <td>{{ $row['order']->delivery_city }}, {{ $row['order']->delivery_address }}<br>{{ $row['order']->gps_landmark }}</td>
                    <td class="cash">
                        {{ $row['order']->payment_status === 'paye' ? 'PAYÉE' : number_format($row['order']->total_amount, 0, ',', ' ') . ' FCFA' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
