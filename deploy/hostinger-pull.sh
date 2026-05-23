#!/usr/bin/env bash
# À exécuter sur Hostinger (SSH) dans le dossier du projet Laravel.
set -euo pipefail

PHP_BIN="${PHP_BIN:-php}"
if [ -x /opt/alt/php83/usr/bin/php ]; then
  PHP_BIN="/opt/alt/php83/usr/bin/php"
fi

echo "→ git pull"
git pull origin main

echo "→ composer (production)"
if [ -x /opt/alt/php83/usr/bin/php ]; then
  /opt/alt/php83/usr/bin/php /usr/local/bin/composer install --no-dev --optimize-autoloader --no-interaction
else
  composer install --no-dev --optimize-autoloader --no-interaction
fi

echo "→ assets (si npm disponible)"
if command -v npm >/dev/null 2>&1; then
  npm ci
  npm run build
fi

echo "→ artisan"
$PHP_BIN artisan migrate --force
$PHP_BIN artisan config:clear
$PHP_BIN artisan cache:clear
$PHP_BIN artisan view:clear
chmod -R ug+rwx storage bootstrap/cache 2>/dev/null || true

echo "✓ Déploiement terminé"
