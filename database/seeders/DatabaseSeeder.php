<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Artisan;
use App\Models\Category;
use App\Models\DeliveryZone;
use App\Models\Material;
use App\Models\Order;
use App\Models\OrderCounter;
use App\Models\OrderEvent;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\PromoCode;
use App\Models\ProProfile;
use App\Models\Review;
use App\Models\Setting;
use App\Models\ShippingRate;
use App\Models\SiteContent;
use App\Models\Technique;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('SunuAtelier2026!');

        // ─── 1. Comptes de test (clairement fictifs) ────────────────────────
        $client = User::create([
            'name' => 'Awa Ndiaye (Démo Client)',
            'email' => 'client@sunuatelier.sn',
            'phone' => '+221 77 100 00 01',
            'role' => 'client',
            'is_active' => true,
            'password' => $password,
        ]);

        Address::create([
            'user_id' => $client->id,
            'label' => 'Domicile Mermoz',
            'full_name' => 'Awa Ndiaye',
            'phone' => '+221 77 100 00 01',
            'country' => 'Sénégal',
            'city' => 'Dakar',
            'district' => 'Mermoz',
            'address_line' => 'Rue MZ 42, près de la boulangerie',
            'is_default' => true,
        ]);

        $pro = User::create([
            'name' => 'Mamadou Fall (Démo Pro)',
            'email' => 'pro@sunuatelier.sn',
            'phone' => '+221 77 100 00 02',
            'role' => 'pro',
            'is_active' => true,
            'password' => $password,
        ]);

        ProProfile::create([
            'user_id' => $pro->id,
            'company_name' => 'Teranga Déco & Hôtellerie SARL',
            'ninea' => '009988776 2G3',
            'trade_register' => 'SN-DKR-2024-B-1024',
            'activity_type' => 'hotel',
            'contact_name' => 'Mamadou Fall',
            'whatsapp' => '+221 77 100 00 02',
            'address' => 'Route des Almadies, Dakar',
            'estimated_monthly_volume' => '500 000 – 1 500 000 FCFA',
            'discount_rate' => 35,
            'status' => 'valide',
        ]);

        User::create([
            'name' => 'Moussa Diop (Démo Livreur)',
            'email' => 'livreur@sunuatelier.sn',
            'phone' => '+221 77 100 00 03',
            'role' => 'livreur',
            'is_active' => true,
            'password' => $password,
        ]);

        User::create([
            'name' => 'Aminata Sow (Admin)',
            'email' => 'admin@sunuatelier.sn',
            'phone' => '+221 77 100 00 04',
            'role' => 'admin',
            'is_active' => true,
            'password' => $password,
        ]);

        // ─── 2. Catégories (4 univers du cahier 2.1) ────────────────────────
        $categories = collect([
            ['name' => 'Maroquinerie & accessoires', 'slug' => 'maroquinerie', 'sort_order' => 1, 'description' => 'Sacs, pochettes et sandales en cuir tanné artisanalement.'],
            ['name' => 'Textiles & tissages', 'slug' => 'textiles', 'sort_order' => 2, 'description' => 'Pagnes tissés, coussins et chemins de table en coton bio local.'],
            ['name' => 'Bijoux & parures', 'slug' => 'bijoux', 'sort_order' => 3, 'description' => 'Colliers, bracelets et boucles en laiton martelé et perles de verre.'],
            ['name' => 'Décoration & poterie', 'slug' => 'decoration', 'sort_order' => 4, 'description' => 'Vases en terre cuite, paniers en raphia et sculptures sur bois.'],
        ])->mapWithKeys(fn ($c) => [$c['slug'] => Category::create($c)]);

        // ─── 3. Matières & Techniques ────────────────────────────────────────
        $materials = collect(['Cuir', 'Coton', 'Bois', 'Argile', 'Laiton', 'Perles', 'Raphia'])
            ->mapWithKeys(fn ($m) => [Str::slug($m) => Material::create(['name' => $m, 'slug' => Str::slug($m)])]);

        $techniques = collect(['Maroquinerie', 'Tissage', 'Poterie', 'Forge & Bijouterie', 'Sculpture sur bois', 'Vannerie'])
            ->mapWithKeys(fn ($t) => [Str::slug($t) => Technique::create(['name' => $t, 'slug' => Str::slug($t)])]);

        // ─── 4. Artisans partenaires (fiches sans compte) ────────────────────
        $artisans = collect([
            ['name' => 'Ibrahima Ba', 'village' => 'Médina, Dakar', 'craft_specialty' => 'Maître maroquinier', 'bio' => '20 ans d’expérience dans le travail du cuir pleine fleur et la couture sellier.'],
            ['name' => 'Fatou Diène', 'village' => 'Thiès', 'craft_specialty' => 'Tisserande traditionnelle', 'bio' => 'Spécialiste du pagne tissé manjak et des teintures végétales naturelles.'],
            ['name' => 'Cheikh Mbaye', 'village' => 'Saint-Louis', 'craft_specialty' => 'Orfèvre & forgeron', 'bio' => 'Travaille le laiton recyclé et les perles anciennes selon les motifs du fleuve.'],
            ['name' => 'Mariama Coly', 'village' => 'Oussouye, Ziguinchor', 'craft_specialty' => 'Potière & céramiste', 'bio' => 'Façonne l’argile de Casamance à la main et cuit ses pièces au feu de bois.'],
            ['name' => 'Modou Gueye', 'village' => 'Saly / Mbour', 'craft_specialty' => 'Sculpteur & vannier', 'bio' => 'Crée des pièces décoratives en bois de dimb et raphia tressé.'],
        ])->map(fn ($a) => Artisan::create(array_merge($a, ['slug' => Str::slug($a['name']), 'is_active' => true])));

        // ─── 5. 14 Produits artisanaux ───────────────────────────────────────
        $catalog = [
            ['cat' => 'maroquinerie', 'art' => 0, 'tech' => 'maroquinerie', 'mats' => ['cuir'], 'title' => 'Sac Cabas Ndar en Cuir Camel', 'sku' => 'SA-MAR-001', 'type' => 'en_stock', 'price' => 45000, 'compare' => 52000, 'pro' => 29000, 'best' => true, 'new' => false, 'stock' => 8, 'variants' => [['size' => 'Grand', 'color' => 'Camel', 'stock' => 5], ['size' => 'Moyen', 'color' => 'Ebène', 'stock' => 3]]],
            ['cat' => 'maroquinerie', 'art' => 0, 'tech' => 'maroquinerie', 'mats' => ['cuir'], 'title' => 'Pochette Gorée Cousue Main', 'sku' => 'SA-MAR-002', 'type' => 'en_stock', 'price' => 18500, 'compare' => null, 'pro' => 12000, 'best' => true, 'new' => true, 'stock' => 12, 'variants' => [['size' => 'Unique', 'color' => 'Terre cuite', 'stock' => 7], ['size' => 'Unique', 'color' => 'Noir', 'stock' => 5]]],
            ['cat' => 'maroquinerie', 'art' => 0, 'tech' => 'maroquinerie', 'mats' => ['cuir'], 'title' => 'Sandales Saloum Cuir Naturel', 'sku' => 'SA-MAR-003', 'type' => 'en_stock', 'price' => 22000, 'compare' => null, 'pro' => 14500, 'best' => false, 'new' => true, 'stock' => 10, 'variants' => [['size' => '39', 'color' => 'Naturel', 'stock' => 4], ['size' => '41', 'color' => 'Naturel', 'stock' => 6]]],
            ['cat' => 'textiles', 'art' => 1, 'tech' => 'tissage', 'mats' => ['coton'], 'title' => 'Pagne Tissé Manjak Royal', 'sku' => 'SA-TEX-001', 'type' => 'piece_unique', 'price' => 55000, 'compare' => null, 'pro' => 36000, 'best' => true, 'new' => false, 'stock' => 1, 'variants' => [['size' => '210×120 cm', 'color' => 'Indigo & Or', 'stock' => 1]]],
            ['cat' => 'textiles', 'art' => 1, 'tech' => 'tissage', 'mats' => ['coton'], 'title' => 'Housse de Coussin Thiès Tissage Géométrique', 'sku' => 'SA-TEX-002', 'type' => 'en_stock', 'price' => 14000, 'compare' => 17000, 'pro' => 9000, 'best' => false, 'new' => false, 'stock' => 15, 'variants' => [['size' => '45×45 cm', 'color' => 'Ocre & Écru', 'stock' => 15]]],
            ['cat' => 'textiles', 'art' => 1, 'tech' => 'tissage', 'mats' => ['coton'], 'title' => 'Chemin de Table Casamance Indigo', 'sku' => 'SA-TEX-003', 'type' => 'sur_commande', 'days' => 7, 'price' => 24000, 'compare' => null, 'pro' => 15500, 'best' => false, 'new' => true, 'stock' => 0, 'variants' => [['size' => '180×40 cm', 'color' => 'Indigo', 'stock' => 0]]],
            ['cat' => 'textiles', 'art' => 1, 'tech' => 'tissage', 'mats' => ['coton'], 'title' => 'Plaid Coton Bio Filé Main', 'sku' => 'SA-TEX-004', 'type' => 'en_stock', 'price' => 38000, 'compare' => null, 'pro' => 25000, 'best' => false, 'new' => false, 'stock' => 6, 'variants' => [['size' => '150×200 cm', 'color' => 'Écru & Terre', 'stock' => 6]]],
            ['cat' => 'bijoux', 'art' => 2, 'tech' => 'forge-bijouterie', 'mats' => ['laiton', 'perles'], 'title' => 'Collier Plastron Linguère Laiton & Perles', 'sku' => 'SA-BIJ-001', 'type' => 'piece_unique', 'price' => 32000, 'compare' => null, 'pro' => 21000, 'best' => true, 'new' => false, 'stock' => 1, 'variants' => [['size' => 'Ajustable', 'color' => 'Doré patiné', 'stock' => 1]]],
            ['cat' => 'bijoux', 'art' => 2, 'tech' => 'forge-bijouterie', 'mats' => ['laiton'], 'title' => 'Jonc Martelé Fleuve Sénégal', 'sku' => 'SA-BIJ-002', 'type' => 'en_stock', 'price' => 12500, 'compare' => 15000, 'pro' => 8000, 'best' => true, 'new' => true, 'stock' => 18, 'variants' => [['size' => 'M', 'color' => 'Laiton', 'stock' => 10], ['size' => 'L', 'color' => 'Laiton', 'stock' => 8]]],
            ['cat' => 'bijoux', 'art' => 2, 'tech' => 'forge-bijouterie', 'mats' => ['perles', 'laiton'], 'title' => 'Boucles d’Oreilles Perles de Verre Kiffa', 'sku' => 'SA-BIJ-003', 'type' => 'en_stock', 'price' => 16000, 'compare' => null, 'pro' => 10500, 'best' => false, 'new' => false, 'stock' => 9, 'variants' => [['size' => 'Unique', 'color' => 'Ambre & Laiton', 'stock' => 9]]],
            ['cat' => 'decoration', 'art' => 3, 'tech' => 'poterie', 'mats' => ['argile'], 'title' => 'Vase Canari Oussouye Terre Cuite Gravée', 'sku' => 'SA-DEC-001', 'type' => 'en_stock', 'price' => 28000, 'compare' => 33000, 'pro' => 18000, 'best' => true, 'new' => false, 'stock' => 5, 'variants' => [['size' => '32 cm', 'color' => 'Terre brûlée', 'stock' => 5]]],
            ['cat' => 'decoration', 'art' => 4, 'tech' => 'vannerie', 'mats' => ['raphia'], 'title' => 'Grand Panier Vannerie Raphia Tressé', 'sku' => 'SA-DEC-002', 'type' => 'en_stock', 'price' => 19500, 'compare' => null, 'pro' => 12500, 'best' => false, 'new' => true, 'stock' => 11, 'variants' => [['size' => '40 cm', 'color' => 'Naturel & Noir', 'stock' => 11]]],
            ['cat' => 'decoration', 'art' => 4, 'tech' => 'sculpture-sur-bois', 'mats' => ['bois'], 'title' => 'Coupe Sculptée en Bois de Dimb', 'sku' => 'SA-DEC-003', 'type' => 'piece_unique', 'price' => 42000, 'compare' => null, 'pro' => 27000, 'best' => false, 'new' => false, 'stock' => 1, 'variants' => [['size' => '35 cm', 'color' => 'Bois brun', 'stock' => 1]]],
            ['cat' => 'decoration', 'art' => 3, 'tech' => 'poterie', 'mats' => ['argile'], 'title' => 'Service de 4 Tasses Argile Émaillée', 'sku' => 'SA-DEC-004', 'type' => 'sur_commande', 'days' => 10, 'price' => 26000, 'compare' => null, 'pro' => 17000, 'best' => false, 'new' => true, 'stock' => 0, 'variants' => [['size' => 'Lot de 4', 'color' => 'Vert forêt', 'stock' => 0]]],
        ];

        $createdProducts = [];
        foreach ($catalog as $item) {
            $product = Product::create([
                'category_id' => $categories[$item['cat']]->id,
                'artisan_id' => $artisans[$item['art']]->id,
                'technique_id' => $techniques[$item['tech']]->id,
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'sku' => $item['sku'],
                'availability_type' => $item['type'],
                'manufacturing_days' => $item['days'] ?? null,
                'price_public' => $item['price'],
                'price_compare_at' => $item['compare'],
                'price_pro' => $item['pro'],
                'weight_grams' => 650,
                'dimensions' => 'Format artisanal standard',
                'short_description' => 'Pièce façonnée à la main au Sénégal avec des matières locales sélectionnées.',
                'description' => "Création authentique réalisée dans l'atelier de {$artisans[$item['art']]->name} ({$artisans[$item['art']]->village}). Chaque détail reflète un savoir-faire transmis de génération en génération.",
                'materials_story' => 'Matières naturelles sourcées localement au Sénégal, finitions soignées à la main.',
                'care_instructions' => 'Nettoyer délicatement avec un chiffon sec ou légèrement humide. Éviter une exposition prolongée à l’humidité.',
                'authenticity_guarantee' => 'Certificat d’authenticité Sunu Atelier inclus · Savoir-faire local garanti.',
                'is_bestseller' => $item['best'],
                'is_new' => $item['new'],
                'is_active' => true,
            ]);

            $product->materials()->sync(collect($item['mats'])->map(fn ($m) => $materials[$m]->id));

            foreach ($item['variants'] as $v) {
                $product->variants()->create([
                    'size' => $v['size'],
                    'color' => $v['color'],
                    'stock_quantity' => $v['stock'],
                    'low_stock_threshold' => 3,
                    'is_active' => true,
                ]);
            }

            $createdProducts[] = $product;
        }

        // ─── 6. Zones de livraison & tarifs fixes ───────────────────────────
        $zones = [
            ['name' => 'Zone 1 – Dakar Plateau / Centre-ville', 'type' => 'local_senegal', 'delay' => '24h', 'rate' => 1500],
            ['name' => 'Zone 2 – Grand Dakar, Almadies, Mermoz, Ouakam, Yoff', 'type' => 'local_senegal', 'delay' => '24h', 'rate' => 2000],
            ['name' => 'Zone 3 – Banlieue (Pikine, Guédiawaye, Keur Massar, Rufisque)', 'type' => 'local_senegal', 'delay' => '24-48h', 'rate' => 3000],
            ['name' => 'Zone 4 – Régions (Thiès, Saint-Louis, Mbour, Ziguinchor…)', 'type' => 'local_senegal', 'delay' => '48-72h', 'rate' => 4500],
            ['name' => 'Retrait gratuit – Atelier-boutique Dakar', 'type' => 'pickup', 'delay' => 'Sous 2h ouvrées', 'rate' => 0],
            ['name' => 'International – Afrique de l’Ouest', 'type' => 'international', 'delay' => '3-5 jours', 'rate' => 15000],
            ['name' => 'International – Europe', 'type' => 'international', 'delay' => '4-7 jours', 'rate' => 25000],
            ['name' => 'International – Amérique du Nord', 'type' => 'international', 'delay' => '5-8 jours', 'rate' => 32000],
            ['name' => 'International – Reste du monde', 'type' => 'international', 'delay' => '6-10 jours', 'rate' => 38000],
        ];

        $zoneModels = [];
        foreach ($zones as $z) {
            $zone = DeliveryZone::create([
                'name' => $z['name'],
                'type' => $z['type'],
                'estimated_delay' => $z['delay'],
                'is_active' => true,
            ]);
            ShippingRate::create([
                'delivery_zone_id' => $zone->id,
                'label' => $z['name'],
                'flat_rate' => $z['rate'],
                'is_active' => true,
            ]);
            $zoneModels[] = $zone;
        }

        // ─── 7. Codes promo de démo ─────────────────────────────────────────
        PromoCode::create([
            'code' => 'BIENVENUE10',
            'type' => 'percentage',
            'value' => 10,
            'min_order_amount' => 15000,
            'max_uses' => 500,
            'is_active' => true,
        ]);

        PromoCode::create([
            'code' => 'TABASKI5000',
            'type' => 'fixed',
            'value' => 5000,
            'min_order_amount' => 30000,
            'max_uses' => 200,
            'is_active' => true,
        ]);

        // ─── 8. Commande livrée de démo + Avis vérifié ──────────────────────
        OrderCounter::create(['year_month' => '2611', 'last_sequence' => 1]);
        $firstProduct = $createdProducts[0];
        $firstVariant = $firstProduct->variants()->first();

        $demoOrder = Order::create([
            'order_number' => 'SA-2611-0001',
            'tracking_token' => bin2hex(random_bytes(16)),
            'user_id' => $client->id,
            'delivery_zone_id' => $zoneModels[1]->id,
            'civility' => 'Mme',
            'customer_name' => 'Awa Ndiaye',
            'customer_phone' => '+221 77 100 00 01',
            'customer_email' => $client->email,
            'delivery_mode' => 'domicile',
            'delivery_country' => 'Sénégal',
            'delivery_city' => 'Dakar',
            'delivery_address' => 'Mermoz, Rue MZ 42',
            'delivery_slot' => 'Après-midi (14h-18h)',
            'subtotal' => 45000,
            'discount_amount' => 0,
            'shipping_amount' => 2000,
            'total_amount' => 47000,
            'payment_method' => 'wave_simule',
            'payment_status' => 'paye',
            'is_simulated_payment' => true,
            'status' => 'livree',
        ]);

        OrderItem::create([
            'order_id' => $demoOrder->id,
            'product_id' => $firstProduct->id,
            'product_variant_id' => $firstVariant->id,
            'product_title' => $firstProduct->title,
            'variant_label' => $firstVariant->displayLabel(),
            'sku' => $firstProduct->sku,
            'unit_price' => $firstProduct->price_public,
            'quantity' => 1,
            'line_total' => $firstProduct->price_public,
        ]);

        OrderEvent::create([
            'order_id' => $demoOrder->id,
            'user_id' => $client->id,
            'event_type' => 'status_changed',
            'status_from' => 'nouvelle',
            'status_to' => 'livree',
            'note' => 'Commande de démonstration livrée.',
        ]);

        Review::create([
            'product_id' => $firstProduct->id,
            'user_id' => $client->id,
            'order_id' => $demoOrder->id,
            'rating' => 5,
            'comment' => 'Cuir magnifique et finitions impeccables, livré le lendemain à Mermoz !',
            'is_approved' => true,
        ]);

        // ─── 9. Réglages et contenus modifiables ────────────────────────────
        $settings = [
            ['key' => 'brand_name', 'value' => 'Sunu Atelier', 'group' => 'general'],
            ['key' => 'whatsapp_number', 'value' => '+221 77 000 00 00', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'contact@sunuatelier.sn', 'group' => 'contact'],
            ['key' => 'shop_address_1', 'value' => 'Atelier-boutique Dakar Plateau, Avenue Léopold Sédar Senghor', 'group' => 'contact'],
            ['key' => 'eur_rate', 'value' => '655.957', 'group' => 'currency'],
            ['key' => 'usd_rate', 'value' => '605', 'group' => 'currency'],
        ];
        foreach ($settings as $s) {
            Setting::create($s);
        }

        SiteContent::create([
            'section_key' => 'hero',
            'title' => "L'Art des Mains d'Afrique",
            'subtitle' => 'Pièces artisanales authentiques du Sénégal : maroquinerie, textiles, bijoux et poteries façonnés à la main.',
        ]);

        SiteContent::create([
            'section_key' => 'notre_histoire',
            'title' => 'Notre Histoire & Nos Artisans',
            'subtitle' => 'Relier les ateliers du Sénégal au monde avec une rémunération juste et des matières durables.',
            'body' => 'Sunu Atelier valorise le savoir-faire des maîtres artisans de Dakar, Thiès, Saint-Louis, Ziguinchor et du Sine-Saloum.',
        ]);
    }
}
