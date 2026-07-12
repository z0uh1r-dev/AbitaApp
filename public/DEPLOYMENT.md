# Deployment Guide — ABITA Frontend (for Claude / automated agents)

This document describes exactly how to deploy the **ABITA Next.js frontend** to
a VPS via GitHub, in a way an AI agent (or a human) can follow step-by-step
without guessing.

The repository is deployed from folder `public/` (this file's directory) inside
`z0uh1r-dev/AbitaApp`. The Laravel backend (`AbitaDash`) lives in the sibling
`admin/` folder of the same repo and is deployed independently — see
`admin/DEPLOYMENT.md`.

The frontend is built and run as a **Docker container** (multi-stage
`Dockerfile`, `docker-compose.yml`), not with a bare Node process.

---

## 1. What the agent needs before starting

Ask the user for (or read from a secrets manager):

- **VPS SSH access:** host/IP, SSH user, SSH private key (or password), SSH port (default `22`).
- **Domain name** the frontend will be served on (e.g. `abita.com`).
- **Backend API URL** — the public URL of the deployed Laravel API (e.g. `https://api.abita.com/api/v1`), needed for `NEXT_PUBLIC_API_BASE_URL`.
- Confirmation of the **absolute deploy path** on the VPS, e.g. `/var/www/abita-frontend`.
- Confirmation that **Docker** and **Docker Compose v2** are installed on the VPS.

Do **not** invent credentials or URLs. If any of the above is missing, stop and ask the user.

---

## 2. One-time VPS setup

```bash
# Docker Engine + Compose plugin (Ubuntu/Debian example)
curl -fsSL https://get.docker.com | sudo sh
sudo usermod -aG docker "$USER"
# log out/in (or `newgrp docker`) for group change to take effect

# Nginx as reverse proxy + TLS
sudo apt update
sudo apt install -y nginx certbot python3-certbot-nginx
```

---

## 3. Clone the repository on the VPS

Use a **sparse checkout** so `git pull` inside the deploy path only tracks the
`public/` subtree:

```bash
sudo mkdir -p /var/www/abita-frontend
sudo chown -R "$USER":"$USER" /var/www/abita-frontend
cd /var/www/abita-frontend
git init
git remote add origin https://github.com/z0uh1r-dev/AbitaApp.git
git config core.sparseCheckout true
echo "public/*" > .git/info/sparse-checkout
git pull origin main
# Move contents up one level so app files sit at the deploy root
shopt -s dotglob
mv public/* .
rmdir public
```

---

## 4. Configure environment

```bash
cp .env.production.example .env.production
```

Edit `.env.production` and fill in:
- `NEXT_PUBLIC_API_BASE_URL` — full URL to the Laravel API, no trailing slash
- `APP_PORT` — host port to expose (default `3000`)

**Never commit `.env.production`** — it's already covered by `.dockerignore` / `.gitignore`.

---

## 5. First deployment

```bash
chmod +x deploy.sh
./deploy.sh
```

`deploy.sh` performs, in order:
1. `git pull origin main`
2. Verifies `.env.production` exists
3. `docker compose --env-file .env.production up -d --build`
4. Prunes dangling Docker images
5. Prints container status

The `NEXT_PUBLIC_API_BASE_URL` value is baked into the JS bundle **at build
time** (via the `ARG`/`ENV` in `Dockerfile`), so any change to that variable
requires re-running `./deploy.sh` (which rebuilds the image).

---

## 6. Web server (Nginx reverse proxy example)

```nginx
server {
    listen 80;
    server_name your-domain.com;

    location / {
        proxy_pass http://127.0.0.1:3000;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
        proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
        proxy_set_header X-Forwarded-Proto $scheme;
    }
}
```

```bash
sudo ln -s /etc/nginx/sites-available/abita-frontend /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
sudo certbot --nginx -d your-domain.com
```

---

## 7. Continuous deployment via GitHub Actions

This repo includes `.github/workflows/deploy-frontend.yml`, which SSHes into
the VPS and runs `./deploy.sh` (inside the frontend deploy path) on every push
to `main` that touches `public/**`.

Configure these **GitHub repository secrets** (Settings → Secrets and variables
→ Actions) — these can be shared with the backend workflow if the same VPS
hosts both apps, or be distinct if hosted separately:

| Secret                     | Description                                        |
|----------------------------|-----------------------------------------------------|
| `VPS_HOST`                 | VPS IP or hostname                                   |
| `VPS_USER`                 | SSH user (e.g. `deploy`)                             |
| `VPS_SSH_KEY`               | Private key with access to that user                 |
| `VPS_PORT`                 | SSH port (usually `22`)                              |
| `VPS_FRONTEND_APP_PATH`    | Absolute path to the frontend app on the VPS (step 3)|

Once secrets are set, every push to `main` touching `public/**` auto-deploys.

---

## 8. Verifying a deployment

```bash
curl -I https://your-domain.com/
docker compose logs -f --tail=100
```

The Docker image ships with a built-in `HEALTHCHECK` (see `Dockerfile`); check
container health with:

```bash
docker inspect --format='{{json .State.Health}}' abita-web
```

---

## 9. Rollback

```bash
cd /var/www/abita-frontend
git log --oneline -n 5
git reset --hard <previous-commit-sha>
./deploy.sh
```

---

## 10. Notes for the deploying agent

- Never commit real `.env.production` values; only use `.env.production.example` as a template.
- `NEXT_PUBLIC_*` variables are inlined **at Docker build time**, not read at runtime — always rebuild after changing them.
- The Next.js app is built in `output: "standalone"` mode (see `next.config.ts`), producing a minimal `server.js` entrypoint copied into the final image.
- If the backend (`admin/`) API URL or CORS config changes, this frontend must be rebuilt/redeployed to pick up the new `NEXT_PUBLIC_API_BASE_URL`.
- Container runs as non-root user `nextjs` (uid 1001) for security.
