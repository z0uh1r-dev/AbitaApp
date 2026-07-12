#!/usr/bin/env bash
#
# Deploy script for the ABITA Next.js frontend (Docker-based).
# Run from the app root on the VPS (the directory containing this file).
#
set -euo pipefail

APP_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$APP_DIR"

echo "==> Pulling latest code"
git pull origin main

if [ ! -f .env.production ]; then
  echo "ERROR: .env.production not found. Copy .env.production.example and fill it in first." >&2
  exit 1
fi

echo "==> Building and starting the Docker container"
docker compose --env-file .env.production up -d --build

echo "==> Pruning dangling images"
docker image prune -f

echo "==> Deployment complete"
docker compose ps
