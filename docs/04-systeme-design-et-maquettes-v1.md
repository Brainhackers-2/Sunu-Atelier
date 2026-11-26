# Système de design et Maquettes V1 – Sunu Atelier

**Auteur** : Designer UI/UX  
**Référence** : Cahier des charges v1.3 (sections 1, 2, 13.3)

---

## 1. Système de design (Design System)

### 1.1 Palette Tailwind (`tailwind.config.js`)
| Nom | Hex | Rôle principal | Règle d'accessibilité |
| :--- | :--- | :--- | :--- |
| `foret` | `#125B3E` | Bandeau supérieur, onglet actif, bloc Pro, badges « Livré » / « Payée » | Texte ivoire ou or dessus (jamais ébène) |
| `or` | `#FFB800` | Badges « Bestseller » / « Pièce unique », étoiles sur fond sombre | **Jamais** en texte/icône sur fond ivoire ; texte ébène sur fond or |
| `terre` | `#C2410C` | Boutons d'action principaux (CTA), liens | Texte blanc sur terre cuite (contraste 5,2) |
| `ebene` | `#131622` | Titres, texte principal, pied de page | Sur fond ivoire (contraste 17) |
| `ivoire` | `#FAF8F5` | Fond des pages et des cartes | Fond neutre chaleureux |
| `whatsapp` | `#25D366` | Boutons WhatsApp uniquement | Icône + libellé clair |
| Erreur / Alerte | `#B91C1C` | Messages d'erreur, rupture | Toujours accompagné d'une icône + texte (pas couleur seule) |

### 1.2 Typographies, grille et ergonomie
- **Breakpoints** : Mobile-first, `480px`, `768px`, `1024px`.
- **Cibles tactiles** : minimum `44px × 44px` pour tout bouton, lien de navigation ou contrôle tactile.
- **Animations** : GSAP + ScrollTrigger avec respect systématique de `window.matchMedia('(prefers-reduced-motion: reduce)')`.
- **États obligatoires sur chaque écran** : `vide`, `chargement` (skeleton / spinner Livewire), `erreur`, `succès`, `mobile`, `desktop`.

---

## 2. Maquettes filaires des pages V1 (Mobile & Desktop)

### 2.1 Layout global
```text
[ Bandeau supérieur foret : Ticker réassurance | Assistance WhatsApp +221 ]
[ Navbar ivoire : Logo "Sunu Atelier / Artisanat d'exception" | Liens (desktop) / Burger (mobile) | Loupe | Compte | Favoris | Panier (badge) ]
[ Contenu principal ]
[ Footer ebene : 4 colonnes (Identité, Liens rapides, Service client, Newsletter) | Mentions + CGV + Paiements ]
```

### 2.2 Accueil (`/`) – 7 sections
1. **Hero prestige** : 2 colonnes desktop (texte + double CTA + 3 pastilles à gauche, image artisanale à droite) ; 1 colonne empilée sur mobile.
2. **4 piliers de réassurance** : grille 4 colonnes desktop, carrousel/swipe horizontal mobile.
3. **4 univers phares** : grille 4 colonnes desktop, 2×2 mobile (`Maroquinerie`, `Textiles`, `Bijoux`, `Décoration & poterie`).
4. **Créations Coup de Cœur** : grille 4 colonnes desktop, 2 colonnes mobile (`is_bestseller = 1`, bouton « Ajouter au panier »).
5. **Bloc Espace Professionnels** : fond `foret`, texte `ivoire`, remises `-25 % à -45 %`, CTA vers `/pro/inscription`.
6. **Bandeau WhatsApp direct** : *« Une pièce en tête ? Parlons-en »*, bouton `whatsapp`.
7. **Footer & Atelier-boutique**.

### 2.3 Boutique (`/boutique`)
- **Desktop** : Bannière + Barre contrôle (recherche + tri) → Layout 2 colonnes : Sidebar filtres (`280px`) à gauche + Grille produits (`3 colonnes`) à droite + Pagination.
- **Mobile** : Bannière + Recherche/Tri + Bouton « Filtres » ouvrant un tiroir latéral + Grille `2 colonnes` (ou `1 colonne` < 480 px).

### 2.4 Fiche produit (`/produit/{slug}`)
- **Desktop** : Fil d'Ariane → 2 colonnes (Galerie zoom + miniatures à gauche ; Panneau d'achat, variantes, disponibilité, CTA Panier + WhatsApp à droite) → Onglets (4) → Avis clients → Carrousel 4 produits associés.
- **Mobile** : Empilé verticalement, boutons pleine largeur `>= 44px`.

### 2.5 Panier (`/panier`) & Tunnel de commande (`/commande`)
- **Panier** : Tableau articles à gauche (`2/3`) + Récapitulatif code promo & total TTC à droite (`1/3`) + bloc rassurance.
- **Commande** : Indicateur 4 étapes en haut → Formulaire étape active à gauche + Résumé commande sticky à droite (empilé sur mobile).

### 2.6 Confirmation (`/confirmation/{token}`) & Suivi (`/suivi`)
- **Confirmation** : Bannière succès → Carte reçu avec QR Code + boutons copie 1-clic + téléchargement reçu PDF + bouton WhatsApp.
- **Suivi** : Formulaire N° + WhatsApp → En-tête commande → Frise horizontale (desktop) / verticale (mobile) des 6 statuts + détails livraison.

### 2.7 Back-office (`/admin`)
- Sidebar fixe gauche (menu `Tableau de bord`, `Produits`, `Catégories`, `Commandes`, `Codes promo`, `Stocks`, `Clients`, `Rapports`, `Réglages`) + tiroir mobile ; zone centrale avec cartes KPI, graphiques Chart.js et tableaux Livewire paginés.
