# Guide de déploiement InfinityFree & Plan B – Sunu Atelier

**Auteur** : Ingénieur environnement et déploiement (DevOps)  
**Cible** : Hébergement gratuit InfinityFree (budget 0 FCFA)

---

## 1. Vérifications préalables (test réel sur projet Laravel vide)

Avant de publier Sunu Atelier en production sur InfinityFree, effectuer un test réel sur un projet Laravel minimal :
1. **Version PHP** : vérifier dans le panneau InfinityFree (actuellement PHP 8.4 sur les serveurs gratuits).
2. **Extensions PHP** : vérifier `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd`, `zip`, `intl`, `curl`.
3. **Absence de SSH / Composer** : sur l'offre gratuite, `composer install` et `npm run build` sont exécutés **en local**, puis les dossiers `vendor/` et `public/build/` sont envoyés par FTP.
4. **Emails** : configurer un service SMTP gratuit (Brevo, Mailjet ou Gmail App Password) dans `.env` (`MAIL_MAILER=smtp`) et tester l'envoi réel.

---

## 2. Préparation du package de déploiement (en local)

```bash
# 1. Installer uniquement les dépendances de production
composer install --no-dev --optimize-autoloader

# 2. Compiler les assets Vite
npm run build

# 3. Exporter la base locale
mysqldump -u root sunu_atelier > sunu_atelier_prod.sql
```

### Configuration `.env` de production (ne jamais versionner)
- `APP_ENV=production`
- `APP_DEBUG=false`
- `APP_URL=https://votre-sous-domaine.infinityfreeapp.com`
- `DB_HOST`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD` fournis par le panneau InfinityFree.

---

## 3. Plan B d'hébergement (si InfinityFree bloque la structure Laravel standard)

Si l'hébergeur ne permet pas de pointer le domaine directement sur `/public` :
1. **Option B1 (adaptation d'arborescence sécurisée)** :
   - Placer le code applicatif (`app/`, `bootstrap/`, `config/`, `database/`, `resources/`, `routes/`, `storage/`, `vendor/`, `.env`) dans un sous-dossier protégé ou hors de `htdocs/`.
   - Placer le contenu de `public/` dans `htdocs/` et adapter les chemins `require __DIR__.'/../...'` dans `index.php`.
   - Ajouter un `.htaccess` bloquant tout accès direct à `.env`, `.git`, `composer.json`.
2. **Option B2 (hébergement alternatif gratuit / bas coût compatible Laravel)** :
   - Comparer une alternative compatible PHP/MySQL/SSH si les limites de fichiers/inodes d'InfinityFree bloquent `vendor/`.
3. **Option B3 (dernier recours pour soutenance/démo)** :
   - Présenter l'application en local (`php artisan serve`) avec la base `sunu_atelier` peuplée et documenter le blocage constaté.
