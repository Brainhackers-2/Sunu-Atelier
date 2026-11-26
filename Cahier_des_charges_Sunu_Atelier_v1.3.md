# Cahier des charges complet – Sunu Atelier

**Plateforme e-commerce artisanale** · Version 1.3 · Pile Laravel · Adapté du cahier des charges BéaLux

> Ce document reprend **toutes les pages et fonctionnalités** du cahier des charges Sunu Atelier v1.0, sans en ajouter. Il y intègre la pile technique, l'ordre de construction et les critères de validation du document de référence SUNU ARTISANAT. Chaque page indique la technologie utilisée (`Tech :`). Les chemins `.php` de la v1.0 deviennent des **routes Laravel** (une route, une vue Blade, et si besoin un composant Livewire).

### Changements de la version 1.3

| # | Changement | Sections |
| :-: | :-- | :-- |
| 1 | Le site BéaLux devient une référence officielle du projet : adresse, ordre de priorité des sources, ce qui est repris ou non, correspondance des pages, protocole de conformité page par page | 0.5, 9.1, 10, 12 |

### Changements de la version 1.2

Cette version intègre les corrections issues de l'analyse de la v1.1.

| # | Changement | Sections |
| :-: | :-- | :-- |
| 1 | Panier et favoris stockés en base (session pour l'invité, fusion à la connexion) au lieu du LocalStorage | 2.4, 2.7, 2.10 |
| 2 | Reçu PDF avec QR en V1 recommandée ; la validation de livraison par le livreur reste en V2 | 2.7, 2.9, 11 |
| 3 | Sélecteurs de langue et de devise masqués en V1 | 1.2 |
| 4 | L'artisan est une fiche liée aux produits, sans compte en V1 (fin des « permissions multi-artisans ») | 6, 9.2 |
| 5 | Suivi de commande protégé : limite de tentatives, message d'erreur identique, lien sécurisé | 2.8 |
| 6 | Numéro de commande avec compteur mensuel ; stock verrouillé dans la transaction | 2.6 |
| 7 | Avis réservés aux acheteurs connectés, liés à une commande livrée | 2.12 |
| 8 | Emails, sauvegarde, taille des photos et données personnelles précisés | 2.14, 7, 8.4 |
| 9 | Export CSV en V1, Excel en V2 | 4.8, 8.2 |
| 10 | Livraison internationale : grille de tarifs fixes par zone en V1 | 2.6 |
| 11 | Type de disponibilité par produit et stock par variante | 2.3 |
| 12 | Contenus du site (textes et images) modifiables par l'administrateur | 4.12 |
| 13 | Nouvelles sections : conception, planning, coût, plan B d'hébergement, alignement sur les critères CPS | 13, 14, 15 |

---

## 0. Contexte et principe d'adaptation

Une start-up locale vend des produits artisanaux (maroquinerie, textiles et tissages, bijoux, poterie, sculpture sur bois, vannerie, décoration, etc.). Elle veut une plateforme e-commerce pour valoriser ses créations auprès d'un public **national et international**.

Le site reprend la structure, les pages, les fonctionnalités et les positionnements visuels du site BéaLux (hero, piliers de réassurance, grille de catégories, bestsellers, bloc revendeurs, bandeau WhatsApp, panier, tunnel de commande, QR de livraison, suivi, back-office, PDF), avec un contenu artisanal.

### 0.1 Table de correspondance BéaLux → Artisanat

| BéaLux (beauté) | Sunu Atelier (artisanat) |
| :-- | :-- |
| Soins visage / corps / teint / cheveux | Maroquinerie / Textiles / Bijoux / Décoration & poterie |
| Filtre type de peau | Filtre **matière** (cuir, bois, argile, coton, perles…) et **origine / technique** |
| Diagnostic de peau IA | **Guide cadeau** : questionnaire (occasion, budget, style) qui propose des pièces |
| Ingrédients actifs (INCI) | **Matériaux & savoir-faire** (matières, techniques, temps de fabrication) |
| Protocole d'application | **Conseils d'entretien** et d'utilisation |
| Précautions & tolérance cutanée | **Garanties & authenticité** (pièce unique, finitions, durabilité) |
| Visionneuse 3D du flacon | Visionneuse 3D / 360° de la pièce |
| Showrooms Néma 2 et Mermoz | **Atelier-boutique** (adresses à renseigner) |
| Revendeurs B2B (salons, spas) | **Professionnels** : boutiques, décorateurs, hôtels, exportateurs |
| Conseillères beauté (WhatsApp) | **Conseiller artisan** (WhatsApp) |
| Avant/après des clientes | Photos « chez vous » des clientes et clients |

### 0.2 Exigences du sujet couvertes

| Exigence | Où dans ce document |
| :-- | :-- |
| Catalogue avec images, prix, description | 2.2, 2.3 |
| Inscription, connexion, gestion du panier | 2.4, 2.5, 2.15 |
| Commande en ligne avec choix du mode de livraison | 2.6 |
| Interface d'administration (produits, catégories, commandes) | 4 |
| Paiement simulé | 2.6 (étape 3), 2.7 |
| Pages et fonctionnalités attractives en plus | 2.9 à 2.15, 3, 5 |
| Site responsive | 1.4, 7 |

### 0.3 Paramètres généraux

- **Monnaie principale** : Franc CFA (FCFA/XOF). Affichage indicatif en EUR et USD pour les visiteurs internationaux (taux défini dans les réglages).
- **Contact officiel et WhatsApp** : `[+221 XX XXX XX XX]` (à renseigner) · `contact@[domaine]`
- **Lieux** : Atelier-boutique `[Ville / quartier]`, éventuellement une seconde boutique.
- **Fuseau et langue** : `Africa/Dakar`, français par défaut, anglais en option.
- **Budget initial** : 0 FCFA. Développement sur Windows.

### 0.4 Règle de périmètre

- Aucune page, fonctionnalité ou module n'est ajouté en dehors de ce cahier des charges.
- En cas de conflit entre deux exigences, le conflit est signalé et la validation du porteur du projet est demandée avant de continuer.
- Les ajouts de la v1.2 (contenus du site modifiables en 4.12, sections 13 à 15) ont été demandés par le porteur du projet.

### 0.5 Site de référence : BéaLux

**Adresse** : https://bealux.infinityfreeapp.com/

**Rôle** : référence visuelle et de déroulement. Sunu Atelier reprend la structure, les pages, les fonctionnalités et les positionnements visuels de BéaLux (section 0), avec un contenu artisanal. Antigravity s'appuie sur ce site pour ne pas se tromper sur la place et l'ordre des éléments.

**Ordre de priorité en cas de désaccord**
1. Les instructions explicites du porteur du projet.
2. Ce cahier des charges : contenu, textes, fonctionnalités, périmètre, charte graphique (1.5), pile technique.
3. Le site BéaLux : structure des pages, ordre et position des sections, nombre de colonnes, déroulement des parcours, comportement des composants.

- Si BéaLux contient une page ou une fonction absente de ce cahier, elle n'est **pas créée** : elle est signalée au porteur du projet.
- Si ce cahier décrit un élément absent de BéaLux, le cahier fait foi.

**Ce qui est repris, ce qui ne l'est pas**

| Repris de BéaLux | Non repris |
| :-- | :-- |
| Ordre des sections de chaque page | Textes, produits et vocabulaire de la cosmétique (peau, ingrédients, diagnostic) |
| Position des images et des blocs, hiérarchie des titres et des boutons | Images, logo, nom de marque |
| Nombre de colonnes des grilles et passage mobile | Couleurs : la palette de la section 1.5 s'applique |
| Parcours (tunnel de commande, suivi, scan, administration) | Code PHP : tout est refait en Laravel, Blade et Livewire |
| Comportement des composants (ticker, badge du panier, tiroir, filtres, onglets) | |

Les images, textes, logo et code de BéaLux ne sont jamais copiés dans Sunu Atelier sans l'accord de leur propriétaire.

**Correspondance des pages** (les noms de pages BéaLux viennent du cahier v1.0 ; Antigravity les confirme en parcourant le site)

| Page Sunu Atelier | Page BéaLux à consulter | Éléments à comparer |
| :-- | :-- | :-- |
| Accueil `/` | `index.php` | Les 7 sections (2.1), leur ordre et leurs positions d'images |
| Boutique `/boutique` | `boutique.php` | Bannière, barre de contrôle, filtres, grille, pagination (2.2) |
| Fiche produit `/produit/{slug}` | `produit.php` | Galerie, panneau d'achat, onglets, avis, carrousel (2.3) |
| Panier `/panier` | `panier.php` | Tableau, code promo, récapitulatif, rassurance (2.4) |
| Commande `/commande` | `commande.php` | Les 4 étapes et leur enchaînement (2.6) |
| Confirmation | `confirmation.php` | Bannière, carte du reçu, QR, boutons de copie (2.7) |
| Suivi | `suivi.php` | Formulaire, frise de statuts, détails de livraison (2.8) |
| Scan livreur | `scan.php` | Fiche destinataire, encaissement, validation (2.9) |
| Favoris, histoire, avis, contact | `favoris.php`, `a-propos.php`, `avis.php`, `contact.php` | Structure des pages (2.10 à 2.13) |
| Espace pro | `pro/*` | Pages et tableau de bord (3) |
| Administration | `admin/*` | Menu, tableaux, formulaires (4) |
| PDF | `pdf/*` | Mise en page des reçus, factures, feuilles de route (5) |

**Protocole de conformité (pour chaque page, avant de passer à la suivante)**
1. Ouvrir la page BéaLux correspondante sur mobile (480 px ou moins) et sur desktop (1024 px ou plus). Noter dans `docs/reference/{page}.md` : l'ordre des sections, le nombre de colonnes, les éléments interactifs et leurs états.
2. Relire la section du cahier et la table de correspondance 0.1 pour repérer les adaptations autorisées.
3. Construire la page.
4. Comparer côte à côte et remplir la fiche de conformité (ci-dessous).
5. Un écart non justifié est corrigé. Un écart nécessaire est signalé et soumis au porteur du projet.
6. Passer à la page suivante seulement après validation.

Modèle de fiche de conformité (une par page, dans `docs/reference/`) :

| Élément | Sur BéaLux | Sur Sunu Atelier | Écart | Justifié ? |
| :-- | :-- | :-- | :-- | :-- |
| (ex. ordre des sections) | | | | |

**Si le site de référence est inaccessible** (hors ligne, blocage, quota de l'hébergement) : Antigravity ne devine pas. Il le signale, demande des captures d'écran au porteur du projet, construit la page d'après le cahier seul et la marque « à comparer ».

---

## 1. Composants transverses (layout global)

*Tech : Blade (composants), Tailwind CSS, Alpine.js, Livewire, Lucide Icons.*

### 1.1 Bandeau supérieur

- Ticker de réassurance : *« Livraison Dakar 24h & régions »*, *« Expédition internationale »*, *« Paiement sécurisé »*, *« Pièces faites main »*.
- Lien cliquable vers le numéro d'assistance (appel ou WhatsApp pré-rempli).
- Fixé en haut, visible sur mobile et desktop.

### 1.2 Barre de navigation

- **Logo** en typographie élégante, sous-titre *« Artisanat d'exception »*.
- **Menu** : Accueil, Boutique, Pro, Notre histoire, Avis, Contact. Onglet actif mis en évidence (`.nav-pill-active`).
- **Actions rapides** : loupe de recherche instantanée (Livewire + Alpine.js), icône Compte (client ou pro), Favoris, **Panier avec badge dynamique** mis à jour sans rechargement (Livewire).
- **V2 uniquement** : sélecteur de langue (FR / EN) et de devise (FCFA / EUR / USD). En V1, le site est en français et en FCFA, et ces sélecteurs ne sont pas affichés.
- Menu burger coulissant sur mobile (Alpine.js).

### 1.3 Pied de page

- **Colonne 1 – Identité** : logo, vision de la marque, adresses de l'atelier-boutique.
- **Colonne 2 – Liens rapides** : Boutique, Guide cadeau, Suivi de colis, Espace Pro.
- **Colonne 3 – Service client** : téléphone, email, horaires.
- **Colonne 4 – Newsletter** : inscription par email (Livewire, anti-doublon, protection contre l'injection d'en-têtes).
- **Bandeau inférieur** : copyright, mentions légales, CGV, badges des moyens de paiement.

### 1.4 Responsive

- Conception **mobile-first**, points de rupture à 480, 768 et 1024 px.
- Grilles de 4 à 2 puis 1 colonne, filtres en tiroir sur mobile, boutons tactiles d'au moins 44 px, images adaptatives (`srcset`, WebP/AVIF, chargement différé).

### 1.5 Charte graphique : palette de couleurs

*Tech : Tailwind CSS (couleurs déclarées dans `tailwind.config.js`, utilisées uniquement via ces noms).*

| Rôle | Nom | Code | Utilisation |
| :-- | :-- | :-- | :-- |
| Vert principal | Vert forêt | `#125B3E` | Bandeau supérieur, onglet actif de la navigation, bloc Espace Professionnels, badges « Livré » et « Payée » |
| Accent | Or | `#FFB800` | Badges « Bestseller » et « Pièce unique » (texte ébène), étoiles de notes sur fond sombre, détails du hero |
| Action | Terre cuite | `#C2410C` | Boutons principaux (« Ajouter au panier », « Confirmer la commande », CTA), liens |
| Texte et fonds sombres | Noir ébène | `#131622` | Texte, titres, pied de page |
| Fond | Ivoire | `#FAF8F5` | Fond des pages et des cartes |
| WhatsApp | Vert WhatsApp | `#25D366` | Boutons WhatsApp uniquement (reconnaissables) |

**Contrastes vérifiés (WCAG AA, minimum 4,5 pour le texte normal)** :

| Combinaison | Contraste |
| :-- | :-: |
| Ivoire sur vert forêt | 7,6 |
| Blanc sur terre cuite | 5,2 |
| Terre cuite sur ivoire | 4,9 |
| Ébène sur or | 10,4 |
| Ébène sur ivoire | 17 |
| Or sur vert forêt | 4,7 |

**Règles d'usage**
- L'or n'est **jamais** utilisé comme texte ou icône sur fond ivoire (contraste de 1,6, illisible). Sur ivoire, l'or sert uniquement de fond de badge avec du texte ébène.
- Les étoiles de notes en or sont placées sur fond vert ou ébène, ou accompagnées d'un contour sombre.
- Le vert forêt et l'ébène ne sont pas utilisés l'un sur l'autre pour du texte (contraste de 2,2).
- Les messages d'erreur et de succès utilisent des couleurs distinctes de la palette de marque (rouge brique pour l'erreur) avec une icône ou un texte, pour ne pas reposer sur la couleur seule.

**Configuration Tailwind**

```js
// tailwind.config.js
theme: {
  extend: {
    colors: {
      foret: '#125B3E',
      or: '#FFB800',
      terre: '#C2410C',
      ebene: '#131622',
      ivoire: '#FAF8F5',
      whatsapp: '#25D366',
    },
  },
},
```

---

## 2. Front-office : expérience visiteur et client

### 2.1 Page d'accueil (route `/`) – 7 sections

*Tech : Blade + Tailwind + GSAP/ScrollTrigger + Alpine.js (Swiper.js pour les carrousels mobiles si nécessaire).*

**Section 1 – Hero prestige**
- Titre : *« L'Art des Mains d'Afrique »* (modifiable). Sous-titre valorisant le fait-main, les matières locales et les artisans.
- Double CTA : **« Explorer la collection »** (boutique) et **« Trouver le cadeau idéal »** (guide cadeau).
- Pastilles de réassurance : *Fait main*, *Pièces uniques*, *Matières locales*.
- Image optimisée, animation d'apparition (fade-in up, GSAP).

**Section 2 – Les 4 piliers de réassurance**
1. *Livraison rapide et internationale* (Dakar 24h, régions 48-72h, monde sous quelques jours).
2. *Paiement sécurisé* (carte simulée, Wave, Orange Money, espèces à la livraison).
3. *Authenticité garantie* (pièces faites main, certificat d'artisan).
4. *Conseillers dédiés* (aide au choix, personnalisation, commandes sur mesure).

Grille 4 colonnes sur desktop, carrousel ou swipe sur mobile.

**Section 3 – Univers et catégories phares** (mêmes positions d'images que BéaLux)
Grille visuelle de 4 univers : *Maroquinerie & accessoires*, *Textiles & tissages*, *Bijoux & parures*, *Décoration & poterie*. Un clic mène à `/boutique?cat=SLUG` avec pré-filtrage ; zoom doux au survol.

**Section 4 – Créations les plus plébiscitées**
- Titre : *« Nos Créations Coup de Cœur »*.
- Grille issue de MySQL (`is_bestseller = 1`). Chaque carte : badge nouveauté / bestseller, photo HD, nom, nom de l'artisan, note en étoiles, prix en FCFA.
- Bouton « Ajouter au panier » (Livewire, animation de vol vers l'icône panier, toast de confirmation) et lien vers la fiche.

**Section 5 – Espace Professionnels**
Bloc contrasté pour boutiques, hôtels, décorateurs et exportateurs, remises dégressives (-25 % à -45 %), CTA **« Devenir Revendeur Agréé »** vers `/pro/inscription`. Les grilles de prix de gros ne sont pas publiques.

**Section 6 – WhatsApp direct**
Titre *« Une pièce en tête ? Parlons-en »*, bouton vert **« Échanger avec un conseiller artisan »** vers `https://wa.me/[NUMERO]?text=...` avec message pré-rempli (l'utilisateur confirme l'envoi).

**Section 7 – Pied de page et atelier-boutique** (voir 1.3).

### 2.2 Boutique et catalogue (route `/boutique`)

*Tech : Blade + Tailwind + Livewire.*

1. **En-tête** : bannière *« Notre Collection »* et compteur de produits.
2. **Barre de contrôle** : recherche instantanée (nom, matière, artisan) et tri (*Plus populaires, Prix croissant, Prix décroissant, Nouveautés*).
3. **Filtres** (sidebar desktop, tiroir mobile) :
   - Catégorie (cases à cocher avec comptage en temps réel)
   - **Matière** (cuir, bois, argile, coton, perles, métal, raphia…)
   - **Origine / technique** (tissage, forge, poterie, broderie…)
   - Budget (curseur min / max en FCFA)
   - Bouton de réinitialisation
4. **Grille de produits** : image, badge de stock, prix, bouton d'ajout, cœur favori.
5. **Pagination** numérique.

*Technique* : requêtes Eloquent combinant catégorie, matière, prix (`BETWEEN`) et `ORDER BY`. Paramètres conservés dans l'URL (`?cat=bijoux&sort=price_asc`) pour le partage et le SEO.

### 2.3 Fiche produit (route `/produit/{slug}`)

*Tech : Blade + Tailwind + Alpine.js + Livewire (Three.js pour la visionneuse 3D, en V2).*

1. **Fil d'Ariane** : Accueil > Boutique > Catégorie > Produit.
2. **Galerie** : image principale avec zoom au survol, miniatures, **visionneuse 3D / 360° (Three.js)**.
3. **Panneau d'achat** :
   - Titre, référence SKU, nom de l'artisan, note moyenne
   - Prix en FCFA (prix barré en promotion)
   - **Variantes** : taille, couleur, matière
   - Disponibilité : *« En stock – Expédié sous 48h »*, *« Pièce unique »* ou *« Sur commande (délai de fabrication) »*
   - Quantité (+ / -), bouton **« Ajouter au panier »**
   - Bouton **« Commander en 1 clic sur WhatsApp »** (produit et quantité pré-remplis)
4. **Onglets** : *Description & histoire de la pièce* · *Matériaux & savoir-faire* · *Entretien & utilisation* · *Garanties & authenticité*.
5. **Avis clients vérifiés** : répartition par étoiles, commentaires, bouton « Laisser un avis ».
6. **Carrousel « Pour compléter votre intérieur / votre style »** : 4 pièces associées (cross-selling, Swiper.js).

*Règle de gestion* : chaque produit a un **type de disponibilité** : `en_stock`, `piece_unique` ou `sur_commande`. Le stock est géré **par variante** (taille / couleur / matière) pour `en_stock` ; une `piece_unique` a une quantité de 1 puis devient indisponible ; une pièce `sur_commande` n'a pas de stock et affiche son délai de fabrication.

### 2.4 Panier (route `/panier` et tiroir latéral)

*Tech : Livewire + Alpine.js + Tailwind.*

1. **Tableau du panier** : visuel, nom, variante, prix unitaire, quantité (+ / -), total de ligne, corbeille.
2. **Code promo** : champ + bouton « Appliquer », message de remise ou d'erreur.
3. **Récapitulatif** : sous-total, remise, frais de livraison estimés, **total TTC**, bouton **« Procéder au paiement sécurisé »**.
4. **Bloc rassurance** : sécurité, garantie, lien WhatsApp.

*Technique* : recalcul instantané des totaux (Livewire). Le panier est **stocké en base** : pour l'invité, il est lié à un identifiant de session ; à la connexion, il est **fusionné avec le panier du compte**. Le stock est vérifié côté serveur avant la caisse. Tiroir panier latéral avec arrière-plan assombri (Alpine.js).

### 2.5 Compte client : inscription et connexion

*Tech : Laravel (authentification, validation, CSRF) + Blade + Livewire.*

- **`/inscription`** : nom, email, téléphone, mot de passe (confirmation), acceptation des CGV. Validation côté client et serveur, unicité de l'email.
- **`/connexion`** : email + mot de passe, « Se souvenir de moi », lien « Mot de passe oublié ». Protection anti-force brute et CSRF, mots de passe hachés (bcrypt).
- **`/mon-compte`** : profil et changement de mot de passe · carnet d'adresses (plusieurs adresses de livraison) · historique des commandes avec statut, reçu PDF et lien de suivi · liste de favoris synchronisée · déconnexion (session détruite).
- L'achat **en invité** reste possible pour limiter l'abandon de panier.

### 2.6 Tunnel de commande (route `/commande`) – 4 étapes sur une page

*Tech : Blade + Livewire + Laravel.*

**Étape 1 – Coordonnées** : civilité, nom complet, téléphone / WhatsApp obligatoire, email. Pré-rempli si le client est connecté.

**Étape 2 – Mode de livraison (choix obligatoire)**
- **Livraison à domicile (Sénégal)** par zone :
  - Zone 1 : centre-ville / Dakar Plateau
  - Zone 2 : Grand Dakar, Almadies, Mermoz, Ouakam, Yoff
  - Zone 3 : banlieue (Pikine, Guédiawaye, Keur Massar, Rufisque)
  - Zone 4 : régions (Ziguinchor, Thiès, Saint-Louis, Mbour…)
- **Retrait gratuit à l'atelier-boutique** (choix du lieu et du créneau).
- **Expédition internationale** : pays, adresse complète, code postal, délai estimé. En V1, les frais suivent une **grille de tarifs fixes par zone** (pays regroupés en zones, définis dans les réglages) ou une demande de devis ; le calcul par poids et par transporteur arrive en V2.
- Adresse précise, repère GPS optionnel (« Utiliser ma position actuelle »), créneau (matin 9h-13h, après-midi 14h-18h, fin de journée) pour la livraison locale.

**Étape 3 – Mode de paiement (simulation)**
- Carte bancaire (**simulée** : formulaire factice, aucune donnée réelle conservée)
- Wave (instructions simulées)
- Orange Money (instructions simulées)
- Paiement à la livraison / au retrait (espèces)

Le paiement simulé, clairement affiché comme tel, renvoie « Succès » ou « Échec » (bouton de test) et enregistre le statut `paid` ou `failed`.

**Étape 4 – Récapitulatif et validation** : relecture des articles, adresse, mode de livraison, total, bouton **« Confirmer la commande »**.

*Technique* : frais de livraison recalculés dynamiquement. À la validation : identifiant unique construit avec un **compteur mensuel** (format `SA-AAMM-NNNN`, ex. `SA-2611-0057`, jamais tiré au hasard pour éviter les doublons), `tracking_token` aléatoire de 32 caractères hexadécimaux, insertion en base dans une transaction SQL, décrémentation du stock avec verrouillage de ligne (`lockForUpdate`) pour éviter la double vente d'une pièce unique, journal `order_events`, redirection vers `/confirmation/{token}`.

### 2.7 Confirmation et reçu QR (route `/confirmation/{token}`)

*Tech : Blade + Livewire + endroid/qr-code + Dompdf.*

1. Bannière de félicitations (icône verte, numéro et nom du client).
2. Bouton WhatsApp : bon de commande en 1 clic (message pré-rempli).
3. Instructions de paiement mobile money si choisi (montant exact et référence, simulés).
4. **Carte du reçu** : numéro avec copie rapide, statut, date, **QR Code** pointant vers `/scan/{token}`, mention *« À présenter au livreur lors de la remise du colis »*.
5. **Boutons de copie en 1 clic** : copier le lien QR, copier / télécharger l'image QR, copier le numéro de commande.
6. Actions : télécharger le **reçu PDF**, accéder au **suivi**.
7. Vidage automatique du panier.

*Note V1 / V2* : la route `/scan/{token}` existe dès la V1 et affiche le suivi de la commande en lecture seule pour tout visiteur. La **validation de livraison** (2.9) n'est active que pour le rôle livreur, en V2. Le QR du reçu est donc utile dès la V1.

### 2.8 Suivi de commande (route `/suivi`)

*Tech : Laravel + Blade + Livewire.*

1. Formulaire : numéro de commande + numéro WhatsApp, **limité à 5 tentatives par minute et par adresse IP** (blocage temporaire ensuite). Le message d'erreur est identique que le numéro de commande ou le téléphone soit faux. Accès direct possible par le lien sécurisé `/suivi/{token}` (reçu, confirmation, message WhatsApp). L'adresse exacte et le téléphone ne s'affichent qu'une fois le couple correct validé.
2. En-tête : numéro (copie en 1 clic), destinataire, date, badge *Payée* ou *À régler à la livraison*.
3. **Frise en 6 statuts** : Nouvelle → Confirmée → **En préparation / fabrication** → Livraison programmée (ou Prête au retrait / Expédiée à l'international) → En cours de livraison → Livrée ✓. Jauge de progression colorée.
4. Détails de livraison : adresse, créneau, repère GPS (lien Google Maps), livreur assigné et contact, **numéro de suivi transporteur** pour l'international.
5. Bouton d'assistance WhatsApp.

### 2.9 Scan mobile livreur (route `/scan/{token}`)

*Tech : Laravel + Blade + Livewire + QR code. Accès réservé au rôle livreur (policy).*

1. En-tête avec logo et badge « Scan Livraison ».
2. Numéro de commande (copie rapide) et statut.
3. Fiche destinataire : nom, numéro WhatsApp cliquable (appel ou message pré-rempli).
4. Localisation : adresse et bouton « Ouvrir l'itinéraire Google Maps ».
5. Encaissement : *« Paiement déjà validé »* en vert, ou montant en grand (ex. **25 000 FCFA à encaisser**) avec case obligatoire *« J'ai bien encaissé le montant en espèces »*.
6. **« Valider la livraison »** : statut `delivered`, paiement `paid` si espèces, journal d'audit dans `order_events`, alerte de succès et blocage du double scan.

### 2.10 Favoris (route `/favoris`)

*Tech : Blade + Livewire.* Grille des pièces marquées d'un cœur. Les favoris sont stockés en base : liés à la session pour l'invité, rattachés au compte à la connexion ; bouton « Ajouter au panier ».

### 2.11 Notre histoire (route `/notre-histoire`)

*Tech : Blade + Tailwind + GSAP/ScrollTrigger.* Histoire de la start-up, portraits des **artisans** (nom, village, savoir-faire), valorisation des matières et techniques locales, engagements éthiques (rémunération juste, matières durables), visite de l'atelier-boutique, vidéo ou galerie de fabrication.

### 2.12 Avis et témoignages (route `/avis`)

*Tech : Blade + Livewire.* Grille des notes, témoignages avec photos « chez vous », formulaire d'évaluation 5 étoiles (réservé aux acheteurs, modération anti-spam). Un avis est lié à une commande livrée et à un compte client : **l'acheteur invité doit créer un compte ou se connecter pour laisser un avis**.

### 2.13 Contact et atelier-boutique (route `/contact`)

*Tech : Blade + Livewire.* Formulaire de contact, coordonnées officielles, adresses et cartes de l'atelier-boutique, horaires, FAQ express (délais, retours, douane et expédition internationale).

### 2.14 Pages juridiques et mot de passe oublié

*Tech : Laravel + Blade.*
- `/cgv` et `/mentions-legales` : conditions de vente, politique de livraison (locale et internationale), droit de retour et pièces sur mesure, protection des données (conformité à la loi sénégalaise sur la protection des données à caractère personnel ; autorité : CDP, obligations de déclaration à vérifier).
- `/mot-de-passe-oublie` : saisie de l'email, jeton temporaire sécurisé, page de réinitialisation.

### 2.15 Pages bonus pour attirer et fidéliser

*Tech : Blade + Livewire.*
- **Guide cadeau** (`/guide-cadeau`) : questionnaire en 3 questions (occasion, budget, style) → sélection de pièces.
- **Blog / Journal de l'atelier** : techniques, portraits d'artisans, idées déco.
- **Commande sur mesure** : demande de pièce personnalisée avec photo de référence.
- **Coffrets cadeaux** et cartes cadeaux.
- **Vus récemment** et recommandations, **notification de retour en stock**.

---

## 3. Espace professionnel et revendeurs (`/pro`)

*Tech : Laravel + Blade + Livewire + policies. Pour boutiques, hôtels, décorateurs, grossistes et exportateurs.*

| Route | Contenu et fonctionnement |
| :-- | :-- |
| `/pro` | Tableau de bord : établissement, statut du compte (Actif / En attente), niveau de remise (ex. 35 %), KPI (total du mois en FCFA, réassorts, factures en cours), raccourcis. Accès réservé au rôle revendeur validé. |
| `/pro/connexion` | Email pro + mot de passe haché, délai d'attente après échecs répétés. |
| `/pro/inscription` | Raison sociale, NINEA / registre de commerce, type d'activité (boutique, hôtel, décorateur, exportateur), responsable, WhatsApp, adresse, volume mensuel estimé. Statut `en_attente` et notification à l'admin. |
| `/pro/commander` | Catalogue avec prix public barré et **prix de gros en FCFA**, achat par lot (6, 12, 24), calculateur de marge, seuil minimum de commande. |
| `/pro/commandes` | Historique chronologique : date, montant, règlement, statut de fabrication / expédition. |
| `/pro/factures` | Factures acquittées, téléchargement PDF. |
| `/pro/devis` | Demande de devis pour grands volumes, exportation ou production sur mesure. |
| `/pro/profil` | Coordonnées de livraison et de facturation. |

---

## 4. Back-office administrateur (`/admin`)

*Tech : Blade + Livewire + Tailwind + Chart.js. Accès réservé au rôle administrateur (403 pour les autres).*

### 4.1 Tableau de bord
- Cartes KPI en FCFA : CA du jour, CA du mois, nombre de commandes, panier moyen.
- Alertes : commandes urgentes non assignées, références en stock critique.
- Tableau des 10 dernières commandes avec statut et actions rapides.
- Graphique des ventes sur 30 jours (Chart.js).

### 4.2 Produits
- Tableau : miniature, nom, catégorie, **artisan**, prix public, prix pro, stock, badges (Bestseller, Nouveauté, Pièce unique), statut Actif / Inactif.
- Formulaire d'ajout / modification : titre, SKU, catégorie, description, matériaux, technique, entretien, dimensions et poids (calcul d'expédition), prix public et de gros, **photos multiples** (téléversement, recadrage, compression, noms de fichiers sécurisés), variantes (taille, couleur, matière), modèle 3D optionnel.
- CRUD complet.

### 4.3 Catégories
Création, modification, suppression, description, ordre d'affichage, visuel d'en-tête, gestion des filtres matière / technique.

### 4.4 Commandes
- Filtres : Toutes, Nouvelles, Confirmées, En préparation, En livraison, Livrées, Annulées ; filtre par paiement (Carte simulée, Wave, Orange Money, Cash) et par mode de livraison (Domicile, Retrait, International).
- Recherche par nom ou numéro.
- Détail : coordonnées, bouton WhatsApp, articles, total, **changement de statut en 1 clic**, affectation du livreur, génération du reçu ou de la facture PDF, numéro de suivi transporteur.

### 4.5 Logistique
Dispatching journalier par zone, attribution aux coursiers, retraits en boutique et expéditions internationales, **feuille de route PDF en 1 clic**.

### 4.6 Équipe et livreurs
Répertoire, WhatsApp, statistiques (colis livrés, espèces à reverser), ajout / modification. Option : répertoire des **artisans partenaires** avec leurs pièces.

### 4.7 Comptes professionnels
Candidatures en attente, consultation des justificatifs, **Valider** (active les prix de gros, email de bienvenue) ou **Refuser**, taux de remise de 25 % à 45 %.

### 4.8 Clients et CRM
Liste des clients inscrits et invités : nom, WhatsApp, ville / pays, nombre de commandes, total dépensé ; export **CSV** (natif, V1) ; export Excel (Laravel-Excel) en V2 si l'hébergement le permet.

### 4.9 Codes promo
Code, type (pourcentage ou montant fixe), minimum d'achat, expiration, utilisations maximales, compteur d'utilisations.

### 4.10 Stocks
Niveaux d'inventaire avec indicateurs vert / orange / rouge, journal des mouvements (production, ventes, ajustements), gestion des pièces uniques et des produits fabriqués sur commande.

### 4.11 Rapports
CA par période, ventilation par moyen de paiement et par mode de livraison, ventes par pays, produits et artisans les plus rentables (Chart.js).

### 4.12 Réglages
Nom de l'enseigne, numéro WhatsApp, emails, adresses des boutiques, **grille des frais de livraison** (zones locales, retrait, tarifs internationaux), taux de change indicatifs, paramètres de la passerelle de paiement simulée.

**Contenus du site** : l'administrateur modifie sans toucher au code les textes et images de l'accueil (titre et sous-titre du hero, image du hero, images des 4 univers, textes des 4 piliers, ticker du bandeau supérieur) et de « Notre histoire ». Pas de nouvelle page : ces champs sont des réglages.

### 4.13 Authentification admin
Sessions sécurisées, bcrypt, CSRF, destruction intégrale de la session à la déconnexion, accès refusé (403) aux non-administrateurs.

---

## 5. Module PDF et QR

*Tech : barryvdh/laravel-dompdf + endroid/qr-code. Les documents sont protégés par contrôle d'accès (jamais d'URL devinable sans autorisation).*

- **Reçu client** : logo, numéro, coordonnées, détail des articles, sous-total, frais de port, total en FCFA, mode de paiement et de livraison, **QR code de traçabilité** en grand format. Téléchargeable depuis la confirmation et imprimable pour le colis.
- **Facture commerciale / pro** : NINEA, registre du commerce, mentions de TVA, coordonnées du revendeur, conditions de paiement, cachet (normes OHADA / Sénégal).
- **Feuille de route livreur** : format paysage, colis classés par quartier (numéro, client, téléphone, adresse, repère GPS), montant à encaisser mis en évidence, **mini QR code 60x60 px** par commande pour ouvrir le scan.

---

## 6. Matrice des rôles et permissions

*Tech : policies et gates Laravel, définies dès le modèle de données pour les 5 rôles.*

| Page / module | Visiteur | Client connecté | Revendeur pro | Livreur | Administrateur |
| :-- | :-: | :-: | :-: | :-: | :-: |
| Accueil et boutique | Consultation / achat | Consultation / achat | Prix publics affichés | Consultation | Gestion intégrale |
| Fiche produit et 3D | Consultation / panier | Consultation / panier | Consultation | Consultation | Modification du contenu |
| Panier et commande | Accès libre (invité) | Pré-rempli, adresses enregistrées | Achat classique | - | Supervision |
| Mon compte, historique | - | **Accès complet** | - | - | Consultation |
| Reçu et QR | Sur commande créée | Sur commande créée | Sur commande créée | Lecture | Réédition / annulation |
| Suivi de colis | N° + WhatsApp | N° + WhatsApp | N° + WhatsApp | Consultation | Modification du statut |
| Scan mobile | - | - | - | **Validation de livraison** | Audit / validation |
| Espace pro | Inscription | Inscription | **Catalogue de gros** | - | Validation des comptes |
| Back-office | Bloqué (403) | Bloqué (403) | Bloqué (403) | Bloqué (403) | **Accès complet** |

*Note* : l'**artisan** est une fiche (table `artisans`) liée aux produits, sans compte de connexion en V1 ; il n'a donc pas de colonne dans cette matrice. Un artisan connecté qui gérerait ses propres produits est hors périmètre.

---

## 7. Exigences non fonctionnelles

- **Responsive** : testé sur mobile, tablette et desktop ; navigation tactile.
- **Sécurité** : validation Laravel côté serveur, CSRF, policies/gates, hachage des mots de passe, contrôle des fichiers téléversés, sessions sécurisées, anti-force brute.
- **Performance** : images compressées (WebP/AVIF), chargement différé (`lazy`), pagination, index SQL sur dates et statuts, ressources compilées par Vite.
- **SEO** : URLs lisibles, balises meta, texte alternatif, données structurées produit.
- **Accessibilité** : contrastes suffisants, libellés de formulaires, navigation au clavier, `prefers-reduced-motion` respecté par les animations GSAP.
- **Multilingue et multi-devises (V2)** : FR / EN, affichage indicatif EUR / USD.
- **Sauvegarde** : export régulier de la base de données et copie du dossier des images téléversées ; procédure de restauration documentée et testée une fois.
- **Photos téléversées** : formats JPG, PNG ou WebP, taille maximale à définir selon l'hébergement (valeur proposée : 2 Mo avant compression), redimensionnées automatiquement (valeur proposée : 1600 px maximum).
- **Données personnelles** : collecte limitée au nécessaire, aucune donnée de carte conservée, mention dans les CGV.

---

## 8. Technologies

### 8.1 Stack principale

| Couche | Technologie | Utilisation |
| :-- | :-- | :-- |
| Backend et architecture | PHP 8.x + Laravel | Routes, contrôleurs, modèles, validations, sécurité, rôles, commandes, clients, produits, logique métier. |
| Rendu des pages | Laravel Blade | Pages publiques, espace Pro et back-office avec composants réutilisables. |
| Interactions réactives | Livewire | Recherche, filtres, formulaires, panier, changements de statut, tableaux dynamiques. |
| Styles et responsive | Tailwind CSS | Grilles, espacements, typographie, couleurs, cartes, boutons, adaptation mobile/ordinateur. |
| Interactions légères | Alpine.js | Tiroir panier, menus mobiles, accordéons, modales, états simples. |
| Animations | GSAP + ScrollTrigger | Apparition progressive, transitions douces, animations au défilement, micro-interactions. |
| Carrousels | Swiper.js (si nécessaire) | Galeries et sélections tactiles. |
| Icônes | Lucide Icons | Icônes cohérentes (recherche, panier, compte, livraison, actions). |
| Base de données | MySQL | Produits, artisans, catégories, variantes, stocks, commandes, clients, revendeurs, paiements, livraisons. |
| Compilation | Vite | Compilation et optimisation des ressources CSS et JavaScript. |
| Versionnement | Git + GitHub | Historique et sauvegarde du code source. |

### 8.2 Bibliothèques spécialisées

| Besoin | Technologie | Rôle |
| :-- | :-- | :-- |
| Animations au scroll | GSAP ScrollTrigger | Déclencher les animations à l'entrée des sections dans la zone visible. |
| Images | WebP/AVIF, srcset, lazy loading | Images adaptées aux écrans, chargement progressif. |
| Graphiques | Chart.js | Courbes de chiffre d'affaires, histogrammes de commandes, répartitions. |
| PDF | barryvdh/laravel-dompdf | Reçus, factures, feuilles de route, rapports. |
| QR codes | endroid/qr-code ou package Laravel compatible | QR associé à une référence ou une URL de commande vérifiable. |
| Export CSV / Excel | CSV natif (V1) ; Maatwebsite/Laravel-Excel (V2) | Export des commandes et données de gestion ; Excel seulement si l'hébergement le permet. |
| WhatsApp | Liens `wa.me` avec message prérempli | Ouvre WhatsApp avec un message prêt ; l'utilisateur confirme l'envoi. |
| 3D / 360° | Three.js | Visionneuse de la pièce (V2). |
| Sécurité | Validation Laravel, CSRF, policies/gates, hash des mots de passe | Protection des formulaires, comptes, données et tarifs Pro. |
| Tests | PHPUnit ou Pest | Commandes, calculs, permissions, statuts, parcours critiques. |

### 8.3 Correspondance pages ↔ technologies

| Page / espace | Technologies |
| :-- | :-- |
| Accueil | Blade + Tailwind + GSAP/ScrollTrigger + Alpine.js |
| Catégories et catalogue | Blade + Tailwind + Livewire |
| Fiche produit | Blade + Tailwind + Alpine.js + Livewire |
| Recherche | Livewire + Alpine.js |
| Panier tiroir | Livewire + Alpine.js + Tailwind |
| Commande et confirmation | Blade + Livewire + Laravel |
| Reçus, factures, feuilles de route | Laravel + Dompdf + QR code |
| Suivi | Laravel + Blade + Livewire |
| Espace Pro | Laravel + Blade + Livewire + policies |
| Back-office | Blade + Livewire + Tailwind + Chart.js |
| Livraisons | Laravel + Livewire + QR code + Dompdf |

### 8.4 Environnement et déploiement

- Développement local sur Windows avec PHP, Composer, MySQL, Node.js/NPM (Vite), VS Code ou Antigravity et Git.
- Le projet est testé localement avant toute mise en ligne.
- InfinityFree est l'hébergement envisagé (budget 0 FCFA). Avant déploiement, vérifier : versions PHP, extensions, règles de réécriture, racine publique, limites de stockage, tâches planifiées.
- La compatibilité Laravel n'est pas promise avant un test réel. Si l'hébergement gratuit ne permet pas une installation Laravel standard, le déploiement est adapté (ou une alternative est proposée) sans exposer `.env`, code privé ou identifiants.
- Redis n'est pas obligatoire en V1.
- **Emails** (bienvenue, mot de passe oublié, newsletter) : utiliser un service SMTP gratuit plutôt que l'envoi direct du serveur, souvent limité sur hébergement gratuit ; en développement, les emails sont écrits dans un journal. Tester l'envoi réel avant la mise en production. Pas de file d'attente ni de tâche planifiée obligatoires : envois synchrones.
- **Export Excel** : CSV natif en V1 ; Laravel-Excel (V2) seulement si l'hébergement le permet.
- Les reçus et factures ne sont jamais accessibles par une URL devinable sans contrôle d'accès.

---

## 9. Règles de réalisation

### 9.1 Consigne technique obligatoire pour Antigravity

Avant toute installation ou génération de code, inspecter l'environnement Windows, vérifier PHP (et ses extensions), Composer, MySQL, Node.js/NPM et Git, puis produire un **rapport de compatibilité**. Ensuite préparer l'application Laravel avec Blade, Livewire, Tailwind CSS et Alpine.js, intégrer GSAP pour les animations décrites, et n'installer que les bibliothèques nécessaires. Ne pas remplacer cette pile par Next.js, React, Vue ou une architecture Node.js. Construire les pages dans l'ordre du cahier des charges, tester chaque parcours et vérifier visuellement les positions et composants avant de passer à la page suivante. Pour chaque page, appliquer le protocole de conformité avec le site de référence BéaLux (section 0.5).

### 9.2 Règles complémentaires

- Lire intégralement ce cahier des charges avant de créer ou modifier le projet.
- Ne supprimer, résumer ou remplacer aucune exigence visuelle ; en cas de conflit, signaler et demander validation.
- Construire d'abord un système de design (couleurs, typographies, tailles de titres, espacements, composants Blade), puis les pages.
- Concevoir les permissions des 5 rôles (visiteur, client, revendeur, livreur, administrateur) dès le modèle de données et les policies. L'artisan est une simple fiche liée aux produits, sans compte en V1.
- Construire par phases ; l'application reste fonctionnelle à chaque étape.
- Créer des données de démonstration **clairement fictives** (artisans, clients, produits, commandes) ; jamais de vraies données personnelles.
- Pour chaque écran : état vide, chargement, erreur, succès, mobile et desktop.
- Ne pas simuler une intégration de paiement, un envoi WhatsApp automatique ou un suivi GPS réel si le service n'est pas connecté. Le paiement V1 reste une simulation clairement affichée comme telle.
- Documenter les variables d'environnement, commandes d'installation, migrations, tests, sauvegardes et déploiement.

---

## 10. Livrables de la première version fonctionnelle

1. Site front-office complet (accueil, boutique, fiche produit, panier, compte client, commande avec choix de livraison, paiement simulé, confirmation, suivi).
2. Interface d'administration (produits, catégories, commandes, plus stocks, promos et rapports).
3. Base de données MySQL (migrations Laravel et données de démonstration fictives, au moins 12 produits).
4. Modules PDF et QR.
5. Espace pro (version simplifiée acceptable pour la V1).
6. Dépôt Git, guide d'installation et jeu de comptes de test (client, pro, admin, livreur).
7. Dossier de conception (plan du site, modèle de données, diagrammes : section 13).
8. Fiches de conformité avec BéaLux, une par page (`docs/reference/`, section 0.5).

## 11. Priorisation et phases

| Priorité | Contenu |
| :-- | :-- |
| **V1 obligatoire** | Catalogue, fiche produit, inscription / connexion, panier, commande avec livraison, paiement simulé, administration produits / catégories / commandes, responsive |
| **V1 recommandée** | Suivi de commande, favoris, avis, codes promo, reçu PDF avec QR code, contact, notre histoire |
| **V2 (bonus attractifs)** | Espace pro, validation de livraison par scan livreur, feuille de route, 3D, guide cadeau, blog, multilingue et multi-devises, CRM et rapports avancés |

**Ordre de construction** : rapport d'environnement → installation Laravel + pile → système de design et layout → base de données, rôles, démo → accueil → boutique → fiche produit → panier → compte → commande et paiement simulé → confirmation, suivi, PDF/QR → back-office → pages restantes → espace pro et V2 → tests → déploiement.

## 12. Critères de validation technique

- Le projet s'installe et démarre localement avec les outils retenus.
- Les ressources CSS et JavaScript sont compilées par Vite.
- Le rendu est responsive et les images sont optimisées.
- Les animations GSAP restent fluides et respectent la préférence de réduction des animations.
- Le panier, la recherche et les formulaires fonctionnent ; les données sont validées côté serveur.
- Les permissions empêchent un client standard d'accéder aux prix et fonctions réservés aux revendeurs.
- Les PDF et QR codes correspondent aux vraies commandes enregistrées.
- Les liens WhatsApp ouvrent des messages préremplis sans prétendre envoyer automatiquement.
- Les pages sont testées sur mobile et ordinateur. Les paramètres Sénégal (FCFA/XOF, +221, adresses, fuseau Africa/Dakar, français) sont vérifiés.
- La faisabilité du déploiement sur InfinityFree est confirmée par un test réel avant la mise en production.
- Le suivi de commande bloque les essais répétés et ne révèle pas lequel des deux champs est faux.
- Le panier invité survit au rechargement de la page et se fusionne avec le panier du compte à la connexion.
- Un produit de type pièce unique ne peut pas être vendu deux fois (test de commandes simultanées).
- Les emails partent réellement depuis le service SMTP choisi.
- Le dossier de conception (section 13) est complet et cohérent avec la base de données.
- Chaque page V1 a sa fiche de conformité avec BéaLux (section 0.5), sans écart non justifié.

---

## 13. Conception et architecture

### 13.1 Plan du site (routes)

| Espace | Routes |
| :-- | :-- |
| Public | `/`, `/boutique`, `/produit/{slug}`, `/panier`, `/commande`, `/confirmation/{token}`, `/suivi`, `/suivi/{token}`, `/scan/{token}`, `/favoris`, `/notre-histoire`, `/avis`, `/contact`, `/cgv`, `/mentions-legales` |
| Compte | `/inscription`, `/connexion`, `/mot-de-passe-oublie`, `/mon-compte` |
| Bonus (2.15, V2) | `/guide-cadeau`, journal de l'atelier, commande sur mesure |
| Pro | `/pro`, `/pro/connexion`, `/pro/inscription`, `/pro/commander`, `/pro/commandes`, `/pro/factures`, `/pro/devis`, `/pro/profil` |
| Administration | `/admin` et ses sous-pages (4.1 à 4.13), `/admin/login` |

### 13.2 Modèle de données (tables principales)

| Table | Contenu | Relations principales |
| :-- | :-- | :-- |
| `users` | Comptes (rôle : client, pro, livreur, admin ; statut) | 1-n adresses, commandes, favoris, avis |
| `pro_profiles` | Raison sociale, NINEA, activité, taux de remise, statut de validation | 1-1 `users` |
| `addresses` | Carnet d'adresses de livraison | n-1 `users` |
| `categories` | Les 4 univers et leurs en-têtes | 1-n `products` |
| `materials`, `techniques` | Valeurs des filtres matière et origine / technique | liées aux `products` |
| `artisans` | Nom, village, savoir-faire, portrait (fiche sans connexion) | 1-n `products` |
| `products` | Titre, slug, SKU, type de disponibilité, prix public et pro, poids, badges | n-1 catégorie, artisan, technique |
| `product_variants` | Taille, couleur, matière, stock | n-1 `products` |
| `product_images` | Photos multiples, ordre | n-1 `products` |
| `carts`, `cart_items` | Panier (session ou compte) | 1-n lignes, n-1 variante |
| `favorites` | Pièces favorites (session ou compte) | n-1 produit |
| `orders` | Numéro, `tracking_token`, client ou invité, mode de livraison, zone, totaux, paiement simulé, statut | 1-n `order_items`, `order_events` |
| `order_items` | Produit, variante, quantité, prix au moment de l'achat | n-1 `orders` |
| `order_events` | Journal des changements de statut et des livraisons validées | n-1 `orders` |
| `delivery_zones`, `shipping_rates` | Zones locales, tarifs fixes locaux et internationaux | utilisées par `orders` |
| `promo_codes` | Code, type, minimum, expiration, utilisations | appliqués aux `orders` |
| `reviews` | Note, commentaire, modération | n-1 produit, utilisateur, commande |
| `stock_movements` | Production, ventes, ajustements | n-1 variante |
| `newsletter_subscribers`, `contact_messages` | Inscriptions et messages | indépendantes |
| `settings`, `site_contents` | Réglages et contenus modifiables (4.12) | indépendantes |

Statuts de commande : `nouvelle`, `confirmee`, `en_preparation`, `livraison_programmee` (ou `prete_au_retrait` / `expediee`), `en_cours_de_livraison`, `livree`, `annulee`. Statuts de paiement : `en_attente`, `paye`, `echoue`.

### 13.3 Diagrammes et documents à produire

Dans un dossier `docs/` du dépôt Git :
- Diagramme des cas d'utilisation (visiteur, client, revendeur, livreur, administrateur).
- Modèle conceptuel et logique des données (à partir de 13.2).
- Plan du site (à partir de 13.1).
- Maquettes mobile et desktop des pages V1, dans la charte de la section 1.5.
- Schéma du parcours de commande et des statuts.

---

## 14. Planning, coût et plan B d'hébergement

### 14.1 Planning (estimation pour un développeur seul, à ajuster)

| Phase | Contenu | Durée estimée |
| :-- | :-- | :-: |
| 1 | Rapport d'environnement, conception, maquettes | 1,5 j |
| 2 | Installation, système de design, layout | 1 j |
| 3 | Base de données, rôles, données de démonstration | 1 j |
| 4 | Accueil, boutique, fiche produit | 3 j |
| 5 | Panier, compte, commande, paiement simulé | 3 j |
| 6 | Confirmation, suivi, reçu PDF et QR | 2 j |
| 7 | Back-office V1 (produits, catégories, commandes) | 3 j |
| 8 | Pages V1 recommandées (favoris, avis, promos, contact, histoire, pages juridiques) | 2 j |
| 9 | Tests, corrections, documentation | 1,5 j |
| 10 | Déploiement et vérifications | 1 j |
| | **Total V1** | **19 j** |

La V2 (espace pro, scan livreur, feuille de route, 3D, guide cadeau, blog, multilingue, CRM et rapports avancés) vient en plus, après validation de la V1.

### 14.2 Coût

| Poste | Coût |
| :-- | :-- |
| Laravel, Livewire, Tailwind, Alpine.js, GSAP, Swiper, Lucide, Chart.js, Dompdf, QR code, Pest, Vite, Git | 0 FCFA (logiciels libres ou gratuits) |
| Hébergement InfinityFree | 0 FCFA |
| Service SMTP pour les emails | 0 FCFA (offre gratuite, volume limité) |
| Nom de domaine personnalisé | Optionnel, hors budget initial (sous-domaine gratuit fourni par l'hébergeur) |

Le vrai coût du projet est le temps de travail (14.1).

### 14.3 Plan B d'hébergement

À vérifier avant la mise en ligne (sur un projet Laravel vide) : version de PHP, extensions (`pdo_mysql`, `mbstring`, `gd`, `zip`, `fileinfo`), réécriture d'URL, possibilité de pointer la racine publique sur le dossier `public`, limites de stockage et de fichiers, absence éventuelle d'accès SSH et de Composer (dans ce cas : installer les dépendances en local et envoyer le dossier `vendor` par FTP).

Si le test échoue, par ordre de préférence :
1. Adapter l'arborescence (contenu de `public` à la racine web, reste du code hors de la racine publique) sans exposer `.env` ni le code privé.
2. Choisir un autre hébergement gratuit ou à bas coût compatible Laravel (à comparer à ce moment-là).
3. En dernier recours, présenter le site en local avec la base de démonstration, et documenter le blocage.

---

## 15. Alignement sur les critères d'évaluation (CPS)

| Critère | Poids | Où il est couvert |
| :-- | :-: | :-- |
| CR1 Définition de l'architecture | 20 % | Sections 6, 8 et 13 (plan du site, modèle de données, diagrammes, rôles, pile technique) |
| CR2 Développement | 45 % | Sections 1 à 3, 5 ; périmètre V1 obligatoire (section 11) |
| CR3 Hébergement | 15 % | Sections 8.4 et 14.3 (test réel, plan B) |
| CR4 Administration | 20 % | Section 4 (produits, catégories, commandes, réglages, contenus du site, accès protégé par rôle) |

**Périmètre minimal si le temps est limité** : V1 obligatoire (section 11) avec administration produits / catégories / commandes et déploiement testé. Les pages V2 ne rapportent pas de points supplémentaires et ne doivent pas retarder la V1.
