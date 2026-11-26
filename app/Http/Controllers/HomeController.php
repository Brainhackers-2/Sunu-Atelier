<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

/**
 * HomeController – Page d'accueil (Phase 5)
 * Pour l'instant retourne la vue d'accueil avec données vides.
 * Sera enrichi en Phase 5 avec les produits bestsellers.
 */
class HomeController extends Controller
{
    public function index(): View
    {
        return view('home');
    }
}
