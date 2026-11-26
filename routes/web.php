<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Routes publiques – Sunu Atelier
|--------------------------------------------------------------------------
| Cahier des charges v1.3 – sections 13.1 et 2 (front-office)
*/

// ─── Accueil ─────────────────────────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');

// ─── Boutique et produits (Phase 5) ──────────────────────────────────────
Route::get('/boutique', [PageController::class, 'boutique'])->name('boutique');
Route::get('/produit/{slug}', [PageController::class, 'produit'])->name('produit');

// ─── Panier et commande (Phase 6) ────────────────────────────────────────
Route::get('/panier', [PageController::class, 'panier'])->name('panier');
Route::get('/commande', [PageController::class, 'commande'])->name('commande');
Route::get('/confirmation/{token}', [PageController::class, 'confirmation'])->name('confirmation');
Route::get('/commande/{token}/recu.pdf', [\App\Http\Controllers\ReceiptPdfController::class, 'download'])->name('commande.recu');

// ─── Suivi et scan (Phase 7) ─────────────────────────────────────────────
Route::get('/suivi', [PageController::class, 'suivi'])->name('suivi');
Route::get('/suivi/{token}', [PageController::class, 'suiviToken'])->name('suivi.token');
Route::get('/scan/{token}', [PageController::class, 'scan'])->name('scan');

// ─── Pages V1 recommandées ───────────────────────────────────────────────
Route::get('/favoris',        [PageController::class, 'favoris'])->name('favoris');
Route::get('/notre-histoire', [PageController::class, 'notreHistoire'])->name('notre-histoire');
Route::get('/avis',           [PageController::class, 'avis'])->name('avis');
Route::get('/contact',        [PageController::class, 'contact'])->name('contact');

// ─── Pages bonus ─────────────────────────────────────────────────────────
Route::get('/guide-cadeau',   [PageController::class, 'guideCadeau'])->name('guide-cadeau');

// ─── Pages juridiques ────────────────────────────────────────────────────
Route::get('/cgv',              [PageController::class, 'cgv'])->name('cgv');
Route::get('/mentions-legales', [PageController::class, 'mentionsLegales'])->name('mentions-legales');

// ─── Authentification client (Phase 4) ───────────────────────────────────
Route::get('/inscription',          [PageController::class, 'inscription'])->name('register')->middleware('guest');
Route::post('/inscription',         [AuthController::class, 'register'])->name('register.submit')->middleware('guest');
Route::get('/connexion',            [PageController::class, 'connexion'])->name('login')->middleware('guest');
Route::post('/connexion',           [AuthController::class, 'login'])->name('login.submit')->middleware('guest');
Route::post('/deconnexion',         [AuthController::class, 'logout'])->name('logout')->middleware('auth');
Route::get('/mot-de-passe-oublie',  [PageController::class, 'motDePasseOublie'])->name('password.request');
Route::get('/mon-compte',           [PageController::class, 'monCompte'])->name('mon-compte')->middleware('auth');

// ─── Espace Pro (Phase V2) ───────────────────────────────────────────────
Route::prefix('pro')->name('pro.')->group(function () {
    Route::get('/',           [PageController::class, 'proIndex'])->name('index');
    Route::get('/connexion',  [PageController::class, 'proConnexion'])->name('connexion');
    Route::get('/inscription',[PageController::class, 'proInscription'])->name('inscription');
    Route::get('/commander',  [PageController::class, 'proCommander'])->name('commander');
    Route::get('/commandes',  [PageController::class, 'proCommandes'])->name('commandes');
    Route::get('/factures',   [PageController::class, 'proFactures'])->name('factures');
    Route::get('/devis',      [PageController::class, 'proDevis'])->name('devis');
    Route::get('/profil',     [PageController::class, 'proProfil'])->name('profil');
});

// Alias simple pour route('pro')
Route::get('/pro', [PageController::class, 'proIndex'])->name('pro');

// ─── Back-office admin (Phase 8) ─────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/',          [PageController::class, 'adminDashboard'])->name('dashboard');
    Route::get('/produits',  [PageController::class, 'adminProduits'])->name('produits');
    Route::get('/categories',[PageController::class, 'adminCategories'])->name('categories');
    Route::get('/commandes', [PageController::class, 'adminCommandes'])->name('commandes');
    Route::get('/clients',   [PageController::class, 'adminClients'])->name('clients');
    Route::get('/stocks',    [PageController::class, 'adminStocks'])->name('stocks');
    Route::get('/codes-promo',[PageController::class, 'adminCodes'])->name('codes-promo');
    Route::get('/rapports',  [PageController::class, 'adminRapports'])->name('rapports');
    Route::get('/reglages',  [PageController::class, 'adminReglages'])->name('reglages');
    Route::get('/login',     [PageController::class, 'adminLogin'])->name('login')->withoutMiddleware(['auth', 'role:admin']);
    Route::post('/login',    [AuthController::class, 'adminLogin'])->name('login.submit')->withoutMiddleware(['auth', 'role:admin']);
});
