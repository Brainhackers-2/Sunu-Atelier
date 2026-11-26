<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Setting;
use App\Services\QrCodeService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;

class ReceiptPdfController extends Controller
{
    public function download(string $token, QrCodeService $qrService): Response
    {
        if (! preg_match('/^[a-f0-9]{32}$/', $token)) {
            abort(404);
        }

        $order = Order::where('tracking_token', $token)
            ->with(['items', 'deliveryZone'])
            ->firstOrFail();

        $scanUrl = route('scan', $order->tracking_token);
        $qrDataUri = $qrService->generateSvgDataUri($scanUrl, 160);
        $brandName = Setting::getValue('brand_name', 'Sunu Atelier');
        $phone = Setting::getValue('whatsapp_number', '+221 77 000 00 00');
        $address = Setting::getValue('shop_address_1', 'Dakar, Sénégal');

        $pdf = Pdf::loadView('pdf.receipt', compact('order', 'qrDataUri', 'brandName', 'phone', 'address'))
            ->setPaper('a4', 'portrait');

        return $pdf->download("Recu-{$order->order_number}.pdf");
    }
}
