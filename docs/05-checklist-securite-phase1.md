# Checklist Cybersécurité – Phase 1 (Conception)

**Auteur** : Expert cybersécurité  
**Référence** : Cahier des charges v1.3 (section 7), Prompt section 7

| Contrôle | Exigence prévue dans l'architecture | Statut conception |
| :--- | :--- | :--- |
| **Validation serveur** | `FormRequest` et règles Livewire `$rules` sur tous les formulaires | **OK** |
| **Protection CSRF** | Jetons `@csrf` sur tous les formulaires POST/PUT/DELETE + protection Livewire native | **OK** |
| **Mots de passe** | Hachage `bcrypt` (`Hash::make`), jamais stockés en clair | **OK** |
| **Anti-force brute** | Rate limiter Laravel (`5 tentatives/min/IP`) sur `/connexion`, `/admin/login`, `/suivi`, `/pro/connexion` ; message d'erreur générique identique sur `/suivi` | **OK** |
| **Contrôle d'accès & Rôles** | Middleware `EnsureRole` + Policies Laravel ; `/admin/*` retourne `403` aux non-admins ; `price_pro` jamais sérialisé vers le front public | **OK** |
| **Protection suivi, reçus, PDF** | `tracking_token` aléatoire 32 hex (`bin2hex(random_bytes(16))`), jamais d'ID séquentiel devinable dans les URLs publiques | **OK** |
| **Fichiers téléversés** | Validation MIME (`jpg, png, webp`), taille max 2 Mo, renommage UUID aléatoire, stockage hors exécution PHP (`storage/app/public`) | **OK** |
| **Secrets & `.env`** | `.env` dans `.gitignore`, `APP_DEBUG=false` en production | **OK** |
| **Paiement simulé** | Aucune donnée de carte réelle enregistrée ; mention explicite « Simulation » | **OK** |
| **XSS / Échappement** | Syntaxe Blade `{{ }}` systématique sur toute donnée utilisateur | **OK** |
