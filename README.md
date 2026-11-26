# Sunu Atelier – Plateforme e-commerce artisanale

Plateforme e-commerce artisanale pour le Sénégal et l'international (maroquinerie, textiles, bijoux, décoration & poterie), construite avec **Laravel 12**, **Blade**, **Livewire 4**, **Tailwind CSS v4**, **Alpine.js**, **GSAP**, **Chart.js**, **DomPDF** et **Endroid QR Code**.

---

## 1. Prérequis locaux

- **PHP** `>= 8.2` (testé avec `8.2.12`) avec extensions : `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd`, `zip`, `intl`, `curl`
- **Composer** `2.x`
- **Node.js** `>= 20.19` & **NPM**
- **MySQL / MariaDB** (base `sunu_atelier` en `utf8mb4_unicode_ci`)

---

## 2. Installation locale

```bash
# 1. Dépendances PHP & JS
composer install
npm install
npm run build

# 2. Configuration .env
cp .env.example .env
php artisan key:generate
# Configurer DB_DATABASE=sunu_atelier, APP_TIMEZONE=Africa/Dakar, APP_LOCALE=fr

# 3. Lien stockage & base de données
php artisan storage:link
php artisan migrate --seed

# 4. Lancer le serveur local
php artisan serve
```

---

## 3. Variables d'environnement principales (`.env`)

| Variable | Valeur recommandée (local) | Description |
| :--- | :--- | :--- |
| `APP_NAME` | `"Sunu Atelier"` | Nom de l'application |
| `APP_ENV` | `local` (`production` en ligne) | Environnement |
| `APP_DEBUG` | `true` (`false` en ligne) | Mode debug |
| `APP_TIMEZONE` | `Africa/Dakar` | Fuseau horaire Sénégal |
| `APP_LOCALE` | `fr` | Langue par défaut |
| `DB_CONNECTION` | `mysql` | Pilote MySQL |
| `DB_DATABASE` | `sunu_atelier` | Nom de la base |
| `MAIL_MAILER` | `log` (`smtp` en ligne) | Envoi d'emails |

---

## 4. Comptes de test (données fictives)

Mot de passe commun : `SunuAtelier2026!`

| Rôle | Email | Accès |
| :--- | :--- | :--- |
| **Client** | `client@sunuatelier.sn` | `/mon-compte`, achats, avis (commande livrée) |
| **Revendeur Pro** | `pro@sunuatelier.sn` | Profil Pro validé (V2) |
| **Livreur** | `livreur@sunuatelier.sn` | Validation livraison (V2) |
| **Administrateur** | `admin@sunuatelier.sn` | Back-office `/admin` (connexion `/admin/login`) |

---

## 5. Tests automatisés

Les tests utilisent SQLite `:memory:` configuré dans `phpunit.xml` et n'altèrent pas la base MySQL locale :

```bash
php artisan test
```

---

## 6. Sauvegardes & Restauration

### Sauvegarde
```bash
# Base de données MySQL
mysqldump -u root sunu_atelier > backup_sunu_atelier_$(date +%Y%m%d).sql

# Fichiers téléversés (images produits)
# Sauvegarder le dossier storage/app/public/
```

### Restauration
```bash
mysql -u root sunu_atelier < backup_sunu_atelier_AAAAMMJJ.sql
```
Puis vérifier le lien symbolique `php artisan storage:link`.

---

## 7. Documentation complémentaire (`docs/`)

- [00-rapport-environnement.md](docs/00-rapport-environnement.md)
- [01-plan-du-site-et-architecture.md](docs/01-plan-du-site-et-architecture.md)
- [02-modele-de-donnees.md](docs/02-modele-de-donnees.md)
- [03-cas-utilisation-et-parcours.md](docs/03-cas-utilisation-et-parcours.md)
- [04-systeme-design-et-maquettes-v1.md](docs/04-systeme-design-et-maquettes-v1.md)
- [05-checklist-securite-phase1.md](docs/05-checklist-securite-phase1.md)
- [06-guide-deploiement-infinityfree.md](docs/06-guide-deploiement-infinityfree.md)
- [07-audit-final-v1.md](docs/07-audit-final-v1.md)
