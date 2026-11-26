<#
.SYNOPSIS
    Prépare le package de déploiement InfinityFree (Plan B1 sécurisé) dans deploy/infinityfree/
#>
$ErrorActionPreference = 'Stop'

$Root = Split-Path -Parent $PSScriptRoot
$DeployRoot = Join-Path $Root "deploy\infinityfree"
$Htdocs = Join-Path $DeployRoot "htdocs"
$Core = Join-Path $Htdocs "core"

Write-Host "=== Préparation du package InfinityFree (Plan B1) ===" -ForegroundColor Cyan

if (-not (Test-Path (Join-Path $Root "vendor\autoload.php"))) {
    throw "Le dossier vendor/ est introuvable. Exécutez 'composer install --no-dev --optimize-autoloader' d'abord."
}

if (-not (Test-Path (Join-Path $Root "public\build\manifest.json"))) {
    Write-Host "Assets Vite non compilés, lancement de npm run build..." -ForegroundColor Yellow
    Push-Location $Root
    npm run build
    Pop-Location
}

if (Test-Path $DeployRoot) {
    Remove-Item -Recurse -Force $DeployRoot
}

New-Item -ItemType Directory -Force -Path $Htdocs | Out-Null
New-Item -ItemType Directory -Force -Path $Core | Out-Null

# 1. Copier le contenu de public/ dans htdocs/ (sans le symlink storage)
Write-Host "[1/6] Copie de public/ -> deploy/infinityfree/htdocs/..."
Get-ChildItem -Path (Join-Path $Root "public") -Force | Where-Object { $_.Name -ne "storage" } | ForEach-Object {
    Copy-Item -Path $_.FullName -Destination $Htdocs -Recurse -Force
}

# 2. Copier storage/app/public/ en vrai dossier htdocs/storage/ (FTP ne supporte pas les symlinks)
Write-Host "[2/6] Copie de storage/app/public/ -> htdocs/storage/..."
$PublicStorageTarget = Join-Path $Htdocs "storage"
New-Item -ItemType Directory -Force -Path $PublicStorageTarget | Out-Null
$AppPublicStorage = Join-Path $Root "storage\app\public"
if (Test-Path $AppPublicStorage) {
    Get-ChildItem -Path $AppPublicStorage -Force | Where-Object { $_.Name -ne ".gitignore" } | ForEach-Object {
        Copy-Item -Path $_.FullName -Destination $PublicStorageTarget -Recurse -Force
    }
}

# 3. Copier le cœur Laravel dans htdocs/core/
Write-Host "[3/6] Copie du cœur Laravel -> htdocs/core/..."
$CoreDirs = @("app", "bootstrap", "config", "database", "resources", "routes", "storage", "vendor")
foreach ($Dir in $CoreDirs) {
    Copy-Item -Path (Join-Path $Root $Dir) -Destination $Core -Recurse -Force
}
Copy-Item -Path (Join-Path $Root "artisan") -Destination $Core -Force

# Nettoyer les caches locaux dans core/bootstrap/cache et logs
Get-ChildItem -Path (Join-Path $Core "bootstrap\cache") -Filter "*.php" -ErrorAction SilentlyContinue | Remove-Item -Force
Get-ChildItem -Path (Join-Path $Core "storage\logs") -Filter "*.log" -ErrorAction SilentlyContinue | Remove-Item -Force

# 4. Adapter htdocs/index.php pour pointer vers core/
Write-Host "[4/6] Génération de htdocs/index.php et protection .htaccess..."
$IndexPhp = @'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/core/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/core/vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/core/bootstrap/app.php';
$app->usePublicPath(__DIR__);

$app->handleRequest(Request::capture());
'@
Set-Content -Path (Join-Path $Htdocs "index.php") -Value $IndexPhp -Encoding ASCII

# Protection stricte de htdocs/core/.htaccess
$CoreHtaccess = @'
<IfModule mod_authz_core.c>
    Require all denied
</IfModule>
<IfModule !mod_authz_core.c>
    Order allow,deny
    Deny from all
</IfModule>
'@
Set-Content -Path (Join-Path $Core ".htaccess") -Value $CoreHtaccess -Encoding ASCII

# .htaccess racine dans htdocs/
$HtdocsHtaccess = @'
<IfModule mod_negotiation.c>
    Options -MultiViews -Indexes
</IfModule>

<IfModule mod_rewrite.c>
    RewriteEngine On

    # Bloquer l'accès au dossier core/ et aux fichiers cachés
    RewriteRule ^core(/|$) - [F,L]
    RewriteRule ^\. - [F,L]

    # Transmettre les en-têtes Authorization et X-XSRF-Token
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]
    RewriteCond %{HTTP:x-xsrf-token} .
    RewriteRule .* - [E=HTTP_X_XSRF_TOKEN:%{HTTP:X-XSRF-Token}]

    # Supprimer les slashs finaux s'il ne s'agit pas d'un dossier
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Router vers le contrôleur frontal Laravel
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
'@
Set-Content -Path (Join-Path $Htdocs ".htaccess") -Value $HtdocsHtaccess -Encoding ASCII

# 5. Préparer core/.env à partir de .env.production.example avec APP_KEY générée
Write-Host "[5/6] Création de htdocs/core/.env..."
$EnvContent = Get-Content -Path (Join-Path $Root ".env.production.example") -Raw
try {
    Push-Location $Root
    $GeneratedKey = (php artisan key:generate --show 2>$null).Trim()
    Pop-Location
    if ($GeneratedKey -match '^base64:') {
        $EnvContent = $EnvContent -replace 'base64:REMPLACER_PAR_CLE_GENEREE_EN_LOCAL', $GeneratedKey
    }
} catch {
    Write-Host "Impossible de générer APP_KEY automatiquement, pensez à la renseigner." -ForegroundColor Yellow
}
[System.IO.File]::WriteAllText((Join-Path $Core ".env"), $EnvContent, (New-Object System.Text.UTF8Encoding $false))

# 6. Copier le dump SQL à côté de htdocs/
Write-Host "[6/6] Copie de sunu_atelier_demo.sql..."
$SqlDump = Join-Path $Root "database\sunu_atelier_demo.sql"
if (Test-Path $SqlDump) {
    Copy-Item -Path $SqlDump -Destination (Join-Path $DeployRoot "sunu_atelier_demo.sql") -Force
}

Write-Host ""
Write-Host "Package prêt dans : $DeployRoot" -ForegroundColor Green
Write-Host "1. Modifiez $Core\.env avec vos identifiants MySQL InfinityFree et APP_URL."
Write-Host "2. Importez $DeployRoot\sunu_atelier_demo.sql dans phpMyAdmin."
Write-Host "3. Envoyez le contenu de $Htdocs\ dans le dossier /htdocs/ de votre FTP InfinityFree."
