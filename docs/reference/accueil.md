# Référence BéaLux – Page d'accueil (`index.php` → `/`)

**Date d'inspection** : 26 novembre 2026  
**URL inspectée** : `https://bealux.infinityfreeapp.com/` (en ligne, HTTP 200)  
**Règle** : Structure, ordre des sections et colonnes repris ; aucun texte, image, logo ni code copié.

---

## 1. Structure observée sur BéaLux

### Desktop (`1440×900`)
1. **Bandeau supérieur** (~37 px) : barre sombre pleine largeur, mentions livraison/paiement à gauche, lien téléphone à droite (statique).
2. **En-tête sticky** (~81 px) : logo à gauche, barre de navigation centrée en pilule (`Accueil`, `Boutique`, `À propos`, `Avis`, `Contact`), 5 contrôles à droite (Recherche modale, Favoris, Tiroir panier `#cart-drawer` `448px` avec badge masqué si 0, Compte, pilule WhatsApp).
3. **Hero** : grille 12 colonnes en **2 colonnes égales** (colonne gauche : badge, `<h1>`, intro, 2 CTA, preuve sociale ; colonne droite : image + mini-carte produit superposée).
4. **Piliers de réassurance** : grille **4 colonnes** (`grid-cols-2 md:grid-cols-4`, 1 ligne de 4).
5. **Catégories** : titre centré + grille **4 colonnes** (`grid-cols-2 md:grid-cols-4`, 4 cartes vers `boutique.php?cat=...`).
6. **Bestsellers** : en-tête avec lien « tout voir » à droite + grille **3 colonnes** (`grid-cols-2 md:grid-cols-3`, 2 lignes de 3 = 6 cartes).
7. **CTA WhatsApp** : bloc centré **1 colonne** (icône, titre, texte, bouton WhatsApp).
8. **Barre Newsletter** : flex horizontal **2 colonnes** (texte à gauche, formulaire champ + bouton à droite).
9. **Pied de page** : grille **4 colonnes** (`grid-cols-1 md:grid-cols-2 lg:grid-cols-4`) + barre inférieure légale et moyens de paiement.

### Mobile (`390×844`)
- **En-tête** : bouton burger à gauche (tiroir `#mobile-drawer` `288px`), logo centré, 3 icônes à droite (Recherche, Panier, Compte).
- **Barre de navigation fixe en bas** (`.mobile-bottom-nav`, `64px`) : `Accueil`, `Boutique`, `Favoris`, `Compte`, `Plus`.
- **Grilles** : Hero en `1` colonne ; Piliers en `2×2` ; Catégories en `2×2` ; Bestsellers en `2×3` ; Newsletter en `1` colonne ; Footer en `1` colonne ; tiroir panier pleine largeur.

---

## 2. Écarts identifiés avec le cahier des charges v1.3 (avant construction)

| Élément | Sur BéaLux | Dans le cahier v1.3 | Décision (priorité cahier) |
| :--- | :--- | :--- | :--- |
| Widget flottant IA (`#amina-widget-container`) | Présent en bas à droite | Absent de la V1 (équivalent = `/guide-cadeau` en V2) | **Non créé en V1** (signalé au porteur du projet) |
| Bloc Espace Professionnels sur l'accueil | Absent de `index.php` | Section 5 obligatoire de l'accueil (2.1) | **Créé** selon le cahier |
| Liens de navigation | 5 liens (`Accueil`, `Boutique`, `À propos`, `Avis`, `Contact`) | 6 liens (`Accueil`, `Boutique`, `Pro`, `Notre histoire`, `Avis`, `Contact`) | **6 liens du cahier** |
| Grille Bestsellers desktop | 3 colonnes (6 cartes) | Grille MySQL (`is_bestseller = 1`) | **3 colonnes** (6 cartes) reprise de BéaLux |
