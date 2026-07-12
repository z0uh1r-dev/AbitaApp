#!/usr/bin/env bash
#
# deploy.sh — Zero-downtime-ish deployment script for AbitaDash (Laravel 12).
#
# Intended to run ON THE VPS, inside the project directory, after a `git pull`
# (or as part of a CI/CD job over SSH). Safe to re-run.
#
# Usage:
#   ./deploy.sh
#
# Requirements on the VPS:
#   - PHP 8.4 CLI + required extensions
#   - Composer
#   - Node.js + npm (only if building assets on the server; otherwise skip)
#   - MySQL reachable per .env
#   - A configured .env file (see .env.production.example)
#
set -euo pipefail

APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$APP_DIR"

echo "==> Deploying AbitaDash from ${APP_DIR}"

if [ ! -f .env ]; then
  echo "ERROR: .env file not found. Copy .env.production.example to .env and configure it first." >&2
  exit 1
fi

echo "==> Pulling latest code"
git fetch origin
git reset --hard origin/main

echo "==> Enabling maintenance mode"
php artisan down --render="errors::503" || true

echo "==> Installing PHP dependencies"
composer install --no-dev --optimize-autoloader --no-interaction

if [ -f package.json ]; then
  echo "==> Installing Node dependencies and building assets"
  npm ci
  npm run build
fi

echo "==> Running database migrations"
php artisan migrate --force --no-interaction

echo "==> Caching configuration, routes, views, and events"
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache || true

echo "==> Ensuring storage symlink exists"
php artisan storage:link || true

echo "==> Fixing storage/bootstrap cache permissions"
chmod -R ug+rwx storage bootstrap/cache

echo "==> Restarting queue workers (if supervisor is used)"
php artisan queue:restart || true

echo "==> Disabling maintenance mode"
php artisan up

echo "==> Deployment complete."
