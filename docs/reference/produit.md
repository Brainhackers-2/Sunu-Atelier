# Référence BéaLux – Fiche produit (`produit.php` → `/produit/{slug}`)

**Date d'inspection** : 26 novembre 2026  
**URL inspectée** : `https://bealux.infinityfreeapp.com/produit.php?id=1`

## Fiche de conformité

| Élément | Sur BéaLux | Sur Sunu Atelier | Écart | Justifié ? |
| :--- | :--- | :--- | :--- | :--- |
| Fil d'Ariane | 4 niveaux (`Accueil › Boutique › Cat › Produit`) | 4 niveaux identiques | Aucun | Oui |
| Layout principal | 2 colonnes desktop (`lg:grid-cols-12`), 1 sur mobile | `lg:grid-cols-12` (6 + 6), empilé sur mobile | Aucun | Oui |
| Panneau d'achat | Titre, note, prix, stock, quantité, Panier + WhatsApp | Identique + sélecteur de variantes (`taille/couleur/matière`) et 3 types de disponibilité | Enrichissement cahier 2.3 | Oui (cahier 2.3 exige variantes et `en_stock` / `piece_unique` / `sur_commande`) |
| Onglets | 4 onglets horizontaux | 4 onglets Alpine.js (Description, Matériaux & savoir-faire, Entretien, Garanties) | Adaptation artisanat | Oui (table 0.1 du cahier) |
| Avis | Bloc avis vérifiés | Section avis clients vérifiés | Aucun | Oui |
| Produits associés | Grille 4 colonnes desktop, 2×2 mobile | `grid-cols-2 md:grid-cols-4` (4 pièces) | Aucun | Oui |
