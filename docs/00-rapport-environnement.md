# Rapport d'environnement – Phase 0 (Sunu Atelier)

**Date** : 26 novembre 2026  
**Responsable** : Ingénieur environnement et déploiement (DevOps)  
**Dossier du projet** : `c:\xampp\htdocs\Sunu-Atelier`

---

## 1. Synthèse de l'inspection

| Composant | Requis | Trouvé | Statut | Action |
| :--- | :--- | :--- | :--- | :--- |
| **Système d'exploitation** | Windows, chemins longs, espace disque | Windows (PowerShell 5.1, Build 26100), `LongPathsEnabled = 1`, `63,03 Go` libres sur `C:\` | **OK** | Aucune |
| **Chemin du projet** | Sans espaces ni dossier synchronisé (OneDrive) | `c:\xampp\htdocs\Sunu-Atelier` | **OK** | Aucune |
| **PHP (version)** | `>= 8.2` (Laravel 12 / Livewire 3) et `<=` version InfinityFree (PHP 8.4) | `PHP 8.2.12 (cli)` (`C:\xampp\php\php.exe`) | **OK** | Vérifier la version exacte sur le compte InfinityFree en Phase 10 |
| **PHP (réglages `php.ini`)** | `memory_limit`, `upload_max_filesize`, `post_max_size` suffisants | `512M` / `40M` / `40M` (`C:\xampp\php\php.ini`) | **OK** | Aucune |
| **PHP (extensions)** | `pdo_mysql`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `fileinfo`, `gd`, `zip`, `curl` | Toutes présentes et actives | **OK** | Aucune |
| **PHP (`intl`)** | Extension `intl` demandée (formatage FCFA/XOF, dates) | Désactivée (`;extension=intl` ligne 934 de `C:\xampp\php\php.ini`, DLL `php_intl.dll` présente) | **À activer** | Décommenter `extension=intl` dans `C:\xampp\php\php.ini` |
| **Composer** | Présent et fonctionnel | `Composer 2.9.5` | **OK** | Aucune |
| **Node.js & NPM** | Compatible Vite (`>= 20.19` ou `>= 22.12`) | Node `v26.13.1`, NPM `11.20.0` | **OK** | Aucune |
| **MySQL / MariaDB** | Serveur actif, port `3306`, création base `sunu_atelier` | `10.4.32-MariaDB` actif et joignable (`mysql -u root`) | **OK** | Créer la base `sunu_atelier` au démarrage du projet (Phase 2) |
| **Git** | Installé, identité configurée | `git 2.56.0.windows.4`, `Elhadj Birane Diallo <commerceligne7@gmail.com>` | **OK** | `git init` en Phase 2 |
| **Ports locaux** | `8000`, `5173` libres ; `3306` MySQL | `8000` et `5173` libres ; `3306` actif | **OK** | Aucune |
| **Réseau** | Accès Packagist, npm, GitHub (port 443) | `repo.packagist.org`, `registry.npmjs.org`, `github.com` joignables | **OK** | Aucune (nécessite exécution hors bac à sable pour les téléchargements) |

---

## 2. Exigences officielles vérifiées

- **Laravel 12** : requiert **PHP 8.2 minimum** (8.2 à 8.5 supportés).
- **Livewire 3** : requiert **PHP 8.1 minimum** et supporte Laravel 10, 11 et 12.
- **Vite** : requiert **Node.js 20.19+ ou 22.12+**.
- **InfinityFree (hébergement cible)** : utilise une version PHP globale sur ses serveurs gratuits (passée à **PHP 8.4** fin 2026 selon la documentation communautaire officielle). PHP `8.2.12` en local reste donc inférieur ou égal à l'hébergement tout en satisfaisant Laravel 12.

---

## 3. Décision Phase 0 (Go / No-Go)

- **Avis DevOps** : **Réserve mineure** — l'extension PHP `intl` est présente (`C:\xampp\php\ext\php_intl.dll`) mais commentée dans `C:\xampp\php\php.ini` (ligne 934).
- **Avis Architecte** : **OK** — pile compatible (PHP 8.2.12, Laravel 12, Livewire 3, Vite, MariaDB 10.4).
- **Avis Chef de projet** : **En attente de validation du porteur du projet** pour activer `extension=intl` dans `C:\xampp\php\php.ini` avant de lancer la **Phase 1 (Conception dans `docs/`)**.

*(Aucune installation de dépendance ni génération de code n'a été effectuée conformément à la règle de Phase 0.)*
