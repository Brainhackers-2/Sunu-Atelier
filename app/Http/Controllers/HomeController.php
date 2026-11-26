<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use App\Models\SiteContent;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $hero = SiteContent::where('section_key', 'hero')->first();

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->limit(4)
            ->get();

        $bestsellers = Product::query()
            ->where('is_active', true)
            ->where('is_bestseller', true)
            ->with(['category', 'artisan', 'variants' => fn ($q) => $q->where('is_active', true), 'images'])
            ->withAvg(['reviews as approved_reviews_avg' => fn ($q) => $q->where('is_approved', true)], 'rating')
            ->limit(6)
            ->get();

        $whatsappNumber = preg_replace('/\D+/', '', Setting::getValue('whatsapp_number', '221770000000'));

        return view('home', compact('hero', 'categories', 'bestsellers', 'whatsappNumber'));
    }
}
