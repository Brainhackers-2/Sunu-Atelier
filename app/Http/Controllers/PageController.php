<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * PageController – Toutes les pages statiques et en cours de construction.
 * Chaque méthode retourne la vue correspondante.
 * Les méthodes seront étoffées phase par phase.
 */
class PageController extends Controller
{
    // ─── Front-office ────────────────────────────────────────────
    public function boutique(): View        { return view('boutique'); }
    public function produit(string $slug): View
    {
        $product = \App\Models\Product::where('slug', $slug)->where('is_active', true)->firstOrFail();
        return view('produit', compact('product'));
    }
    public function panier(): View          { return view('panier'); }
    public function commande(): View        { return view('commande'); }
    public function confirmation(string $token, \App\Services\QrCodeService $qrService): View
    {
        if (! preg_match('/^[a-f0-9]{32}$/', $token)) {
            abort(404);
        }
        $order = \App\Models\Order::where('tracking_token', $token)->with('items')->firstOrFail();
        $qrDataUri = $qrService->generatePngDataUri(route('scan', $order->tracking_token), 220);
        $whatsappNumber = preg_replace('/\D+/', '', \App\Models\Setting::getValue('whatsapp_number', '221770000000'));
        return view('confirmation', compact('order', 'qrDataUri', 'whatsappNumber'));
    }
    public function suivi(): View           { return view('suivi'); }
    public function suiviToken(string $token): View   { return view('suivi-token', compact('token')); }
    public function scan(string $token): View
    {
        if (! preg_match('/^[a-f0-9]{32}$/', $token)) {
            abort(404);
        }
        $order = \App\Models\Order::where('tracking_token', $token)->firstOrFail();
        return view('scan', compact('token', 'order'));
    }
    public function favoris(): View         { return view('favoris'); }
    public function notreHistoire(): View
    {
        $content = \App\Models\SiteContent::where('section_key', 'notre_histoire')->first();
        $artisans = \App\Models\Artisan::where('is_active', true)->get();
        return view('notre-histoire', compact('content', 'artisans'));
    }
    public function avis(): View            { return view('avis'); }
    public function contact(): View         { return view('contact'); }
    public function guideCadeau(): View     { return view('guide-cadeau'); }
    public function cgv(): View             { return view('cgv'); }
    public function mentionsLegales(): View { return view('mentions-legales'); }

    // ─── Authentification ────────────────────────────────────────
    public function inscription(): View     { return view('auth.register'); }
    public function connexion(): View       { return view('auth.login'); }
    public function motDePasseOublie(): View{ return view('auth.forgot-password'); }
    public function monCompte(): View       { return view('mon-compte'); }

    // ─── Espace Pro (V2) ─────────────────────────────────────────
    public function proIndex(): View        { return view('pro.index'); }
    public function proConnexion(): View    { return view('pro.connexion'); }
    public function proInscription(): View  { return view('pro.inscription'); }
    public function proCommander(): View    { return view('pro.commander'); }
    public function proCommandes(): View    { return view('pro.commandes'); }
    public function proFactures(): View     { return view('pro.factures'); }
    public function proFacturePdf(string $token): \Illuminate\Http\Response
    {
        if (! preg_match('/^[a-f0-9]{32}$/', $token)) {
            abort(404);
        }
        $order = \App\Models\Order::where('tracking_token', $token)->with('items')->firstOrFail();
        $user = auth()->user();
        if (! $user || (! $user->isAdmin() && $order->user_id !== $user->id)) {
            abort(403);
        }
        $profile = $order->user?->proProfile;
        $brandName = \App\Models\Setting::getValue('brand_name', 'Sunu Atelier');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.pro-invoice', compact('order', 'profile', 'brandName'))
            ->setPaper('a4', 'portrait');
        return $pdf->download("Facture-Pro-{$order->order_number}.pdf");
    }
    public function proDevis(): View        { return view('pro.devis'); }
    public function proProfil(): View       { return view('pro.profil'); }

    // ─── Admin (Phase 8) ─────────────────────────────────────────
    public function adminDashboard(): View  { return view('admin.dashboard'); }
    public function adminProduits(): View   { return view('admin.produits'); }
    public function adminCategories(): View { return view('admin.categories'); }
    public function adminCommandes(): View  { return view('admin.commandes'); }
    public function adminClients(): View    { return view('admin.clients'); }
    public function adminClientsCsv(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        $clients = \App\Models\User::where('role', 'client')->withCount('orders')->withSum('orders', 'total_amount')->get();
        return response()->streamDownload(function () use ($clients) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Nom', 'Email', 'Telephone', 'Commandes', 'Total FCFA']);
            foreach ($clients as $c) {
                fputcsv($out, [$c->name, $c->email, $c->phone, $c->orders_count, (int) $c->orders_sum_total_amount]);
            }
            fclose($out);
        }, 'clients-sunu-atelier.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
    public function adminStocks(): View     { return view('admin.stocks'); }
    public function adminCodes(): View      { return view('admin.codes-promo'); }
    public function adminRapports(): View   { return view('admin.rapports'); }
    public function adminReglages(): View   { return view('admin.reglages'); }
    public function adminRevendeurs(): View { return view('admin.revendeurs'); }
    public function adminRouteSheetPdf(\App\Services\QrCodeService $qrService): \Illuminate\Http\Response
    {
        $orders = \App\Models\Order::whereIn('status', ['confirmee', 'en_preparation', 'livraison_programmee', 'en_cours_de_livraison'])
            ->latest()->get();
        $rows = $orders->map(fn ($o) => [
            'order' => $o,
            'qr' => $qrService->generateSvgDataUri(route('scan', $o->tracking_token), 60),
        ]);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.route-sheet', compact('rows'))
            ->setPaper('a4', 'landscape');
        return $pdf->download('Feuille-de-route-' . now()->format('Ymd') . '.pdf');
    }
    public function adminLogin(): View      { return view('admin.login'); }
}
