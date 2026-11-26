# Plan du site et Architecture logicielle – Sunu Atelier

**Auteurs** : Architecte logiciel & Concepteur / analyste  
**Référence** : Cahier des charges v1.3 (sections 1 à 6, 8, 11, 13)

---

## 1. Plan du site (Routes Laravel)

### 1.1 Priorité V1 obligatoire
| Espace | Route | Méthode / Tech | Description |
| :--- | :--- | :--- | :--- |
| Public | `/` | `GET` · Blade + GSAP + Alpine + Livewire | Accueil (7 sections : Hero, 4 piliers, 4 univers, Bestsellers, Bloc Pro, WhatsApp, Footer) |
| Public | `/boutique` | `GET` · Blade + Livewire | Catalogue, recherche, tri, filtres URL (`cat`, `matiere`, `technique`, `min`, `max`, `sort`), pagination |
| Public | `/produit/{slug}` | `GET` · Blade + Livewire + Alpine | Fiche produit (galerie, variantes, disponibilité, ajout panier, WhatsApp 1-clic, onglets, avis, cross-sell) |
| Public | `/panier` | `GET` · Blade + Livewire | Panier complet + tiroir latéral global (`CartDrawer`) |
| Public | `/commande` | `GET` · Blade + Livewire | Tunnel de commande 4 étapes sur une page (coordonnées, livraison, paiement simulé, récapitulatif) |
| Compte | `/inscription` | `GET/POST` · Laravel Auth | Inscription client (nom, email, téléphone, mot de passe, CGV) |
| Compte | `/connexion` | `GET/POST` · Laravel Auth | Connexion client (anti-force brute 5/min/IP) |
| Compte | `/deconnexion` | `POST` · Laravel Auth | Déconnexion et destruction complète de session |
| Compte | `/mot-de-passe-oublie` | `GET/POST` · Laravel Auth | Demande et réinitialisation par jeton temporaire |
| Compte | `/mon-compte` | `GET` · Blade + Livewire | Profil, mot de passe, carnet d'adresses, historique commandes, favoris |
| Admin | `/admin/login` | `GET/POST` · Laravel Auth | Connexion back-office |
| Admin | `/admin` | `GET` · Blade + Livewire + Chart.js | Tableau de bord KPI (CA jour/mois, commandes, alertes, graphique 30j) |
| Admin | `/admin/produits` | `GET` · Blade + Livewire | CRUD produits, variantes, photos multiples, artisans, badges |
| Admin | `/admin/categories` | `GET` · Blade + Livewire | CRUD catégories (4 univers), ordre, visuels, filtres |
| Admin | `/admin/commandes` | `GET` · Blade + Livewire | Liste, filtres, détail, changement de statut 1-clic, affectation livreur, PDF |

### 1.2 Priorité V1 recommandée
| Espace | Route | Méthode / Tech | Description |
| :--- | :--- | :--- | :--- |
| Public | `/confirmation/{token}` | `GET` · Blade + QR + Dompdf | Confirmation commande, carte reçu, QR vers `/scan/{token}`, copie 1-clic, reçu PDF |
| Public | `/suivi` | `GET` · Blade + Livewire | Recherche N° commande + WhatsApp (limité à 5 essais/min/IP) |
| Public | `/suivi/{token}` | `GET` · Blade + Livewire | Accès direct sécurisé à la frise 6 statuts et détails de livraison |
| Public | `/scan/{token}` | `GET` · Blade | Lecture seule en V1 (affiche suivi) ; validation livreur activée en V2 |
| Public | `/favoris` | `GET` · Blade + Livewire | Grille des favoris (session invité + fusion à la connexion) |
| Public | `/notre-histoire` | `GET` · Blade + GSAP | Histoire, portraits d'artisans, savoir-faire, atelier-boutique |
| Public | `/avis` | `GET` · Blade + Livewire | Témoignages et formulaire 5 étoiles (connecté + commande livrée) |
| Public | `/contact` | `GET` · Blade + Livewire | Formulaire contact, coordonnées, horaires, FAQ express |
| Public | `/cgv` et `/mentions-legales` | `GET` · Blade | Pages juridiques (loi sénégalaise CDP, retours, livraison) |
| PDF | `/commande/{token}/recu.pdf` | `GET` · Dompdf | Téléchargement protégé du reçu client avec QR |
| Admin | `/admin/codes-promo` | `GET` · Blade + Livewire | CRUD codes promo (% ou fixe, minimum, expiration, quota) |
| Admin | `/admin/stocks` | `GET` · Blade + Livewire | Niveaux vert/orange/rouge, journal `stock_movements` |
| Admin | `/admin/rapports` | `GET` · Blade + Livewire + Chart.js | CA par période, paiement, livraison, pays, artisans rentables |
| Admin | `/admin/reglages` | `GET` · Blade + Livewire | Enseigne, WhatsApp, grille livraison, taux indicatifs, **contenus du site** (`site_contents`) |
| Admin | `/admin/clients` | `GET` · Blade + Livewire | Clients inscrits et invités, export CSV natif |

### 1.3 Priorité V2 (après validation de la V1)
- **Espace Pro** : `/pro`, `/pro/connexion`, `/pro/inscription`, `/pro/commander`, `/pro/commandes`, `/pro/factures`, `/pro/devis`, `/pro/profil` + `/admin/revendeurs` + facture pro PDF OHADA.
- **Livreur** : validation de livraison sur `/scan/{token}`, `/admin/logistique`, `/admin/equipe`, feuille de route PDF paysage avec mini-QR 60x60 px.
- **Bonus V2** : `/guide-cadeau`, blog/journal de l'atelier, commande sur mesure, coffrets cadeaux, visionneuse 3D/360° (Three.js), sélecteurs FR/EN et FCFA/EUR/USD, export Excel.

---

## 2. Architecture logicielle Laravel

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/ (LoginController, RegisterController, PasswordResetController)
│   │   ├── HomeController.php
│   │   ├── ProductController.php
│   │   ├── OrderConfirmationController.php
│   │   ├── ReceiptPdfController.php
│   │   └── PageController.php (notre-histoire, cgv, mentions-legales)
│   ├── Middleware/
│   │   └── EnsureRole.php (vérification rôle + 403)
│   └── Requests/ (FormRequests pour validation stricte serveur)
├── Livewire/
│   ├── Layout/ (NavbarSearch.php, CartBadge.php, CartDrawer.php, NewsletterForm.php)
│   ├── Shop/ (ProductCatalog.php, ProductDetail.php, FavoriteButton.php, FavoritesList.php)
│   ├── Checkout/ (CartPage.php, CheckoutWizard.php)
│   ├── Tracking/ (OrderTracking.php)
│   ├── Community/ (ReviewsSection.php, ContactForm.php)
│   └── Admin/ (Dashboard.php, ProductsManager.php, CategoriesManager.php, OrdersManager.php, ...)
├── Models/ (User, ProProfile, Address, Category, Material, Technique, Artisan, Product, ProductVariant, ProductImage, Cart, CartItem, Favorite, Order, OrderItem, OrderEvent, DeliveryZone, ShippingRate, PromoCode, Review, StockMovement, NewsletterSubscriber, ContactMessage, Setting, SiteContent)
├── Policies/ (OrderPolicy, ProductPolicy, ProProfilePolicy, AdminPolicy)
└── Services/
    ├── CartService.php (gestion session/user + fusion à la connexion)
    ├── OrderService.php (transaction SQL, compteur SA-AAMM-NNNN, lockForUpdate, order_events)
    ├── PricingService.php (calcul FCFA, promos, frais de livraison par zone)
    └── QrCodeService.php (génération QR via endroid/qr-code)
```

---

## 3. Matrice des rôles et permissions (Policies & Gates)

| Rôle (`users.role`) | Accès Front | Prix de gros | Suivi / Reçu | Scan livreur | Espace Pro | Back-office `/admin` |
| :--- | :--- | :--- | :--- | :--- | :--- | :--- |
| **Visiteur** (non connecté) | Lecture + panier session + commande invité | Non | Sur commande créée (`token` ou N°+WhatsApp) | Lecture seule | Inscription | **403 / Redirection login** |
| **`client`** | Complet + favoris + adresses + avis (si livré) | Non (jamais exposé) | Ses commandes | Lecture seule | Inscription | **403** |
| **`pro`** | Complet | Oui (si `pro_profiles.status = approved` en V2) | Ses commandes | Lecture seule | Complet (V2) | **403** |
| **`livreur`** | Lecture | Non | Consultation | Validation livraison (V2) | Non | **403** |
| **`admin`** | Complet | Supervision | Tous | Audit | Validation comptes | **Accès complet** |
