# Référence BéaLux – Boutique (`boutique.php` → `/boutique`)

**Date d'inspection** : 26 novembre 2026  
**URL inspectée** : `https://bealux.infinityfreeapp.com/boutique.php?i=1`

## Fiche de conformité

| Élément | Sur BéaLux | Sur Sunu Atelier | Écart | Justifié ? |
| :--- | :--- | :--- | :--- | :--- |
| En-tête | Bannière sombre + titre | Bannière `bg-foret` « Notre Collection » + compteur | Aucun | Oui |
| Filtres desktop | Sidebar gauche (`lg:col-span-3` / 280px) | Sidebar gauche `lg:col-span-3` avec compteurs | Aucun | Oui |
| Filtres mobile | Empilés au-dessus | Tiroir latéral mobile (bouton « Filtres ») | Amélioration cahier 2.2 | Oui (cahier 1.4 & 2.2 exigent « filtres en tiroir sur mobile ») |
| Critères de filtre | Catégories, Prix, Marque | Catégorie, Matière, Origine/Technique, Budget FCFA | Adaptation artisanat | Oui (table 0.1 du cahier) |
| Grille produits | 3 colonnes desktop, 2 colonnes mobile | `grid-cols-2 md:grid-cols-3` | Aucun | Oui |
| Recherche & tri | Tri dropdown + modal recherche | Recherche instantanée Livewire + tri + URL | Enrichissement Livewire | Oui (cahier 2.2) |
