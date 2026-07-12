# Deployment Guide (for Claude / automated agents)

This document describes exactly how to deploy **AbitaDash** to a VPS via GitHub, in a way an AI agent (or a human) can follow step-by-step without guessing.

The repository is deployed from folder `admin/` (this file's directory) inside `z0uh1r-dev/AbitaApp`.

---

## 1. What the agent needs before starting

Ask the user for (or read from a secrets manager):

- **VPS SSH access:** host/IP, SSH user, SSH private key (or password), SSH port (default `22`).
- **Domain name** (or IP) the app will be served on.
- **Database credentials** to use in production (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
- **Mail credentials** (SMTP host/port/user/password) — see `.env.production.example`.
- Confirmation of the **absolute deploy path** on the VPS, e.g. `/var/www/abitadash`.

Do **not** invent credentials. If any of the above is missing, stop and ask the user.

---

## 2. One-time VPS setup (run manually or via SSH by the agent)

```bash
# System packages (Ubuntu/Debian example)
sudo apt update
sudo apt install -y php8.4 php8.4-fpm php8.4-cli php8.4-mysql php8.4-mbstring \
  php8.4-xml php8.4-bcmath php8.4-curl php8.4-zip php8.4-gd \
  nginx mysql-server git unzip

# Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Node.js (for asset builds)
curl -fsSL https://deb.nodesource.com/setup_20.x | sudo -E bash -
sudo apt install -y nodejs
```

Create the database:

```bash
sudo mysql -e "CREATE DATABASE abitadash CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER 'abitadash'@'127.0.0.1' IDENTIFIED BY 'CHANGE_ME';"
sudo mysql -e "GRANT ALL PRIVILEGES ON abitadash.* TO 'abitadash'@'127.0.0.1'; FLUSH PRIVILEGES;"
```

---

## 3. Clone the repository on the VPS

```bash
sudo mkdir -p /var/www/abitadash
sudo chown -R "$USER":"$USER" /var/www/abitadash
git clone https://github.com/z0uh1r-dev/AbitaApp.git /tmp/AbitaApp
cp -r /tmp/AbitaApp/admin/. /var/www/abitadash
cd /var/www/abitadash
```

> The GitHub repo wraps the Laravel app inside `admin/`. On the VPS, the app itself
> should live at the deploy path root (e.g. `/var/www/abitadash`), with `admin/`
> contents copied in — **not** nested — so `deploy.sh`'s `git pull` logic (see below)
> works against the correct subtree.

For simpler ongoing pulls, prefer a **sparse checkout** so `git pull` inside
`/var/www/abitadash` only tracks the `admin/` subfolder:

```bash
cd /var/www/abitadash
git init
git remote add origin https://github.com/z0uh1r-dev/AbitaApp.git
git config core.sparseCheckout true
echo "admin/*" > .git/info/sparse-checkout
git pull origin main
# Move contents up one level so app files sit at the deploy root
shopt -s dotglob
mv admin/* .
rmdir admin
```

---

## 4. Configure environment

```bash
cp .env.production.example .env
php artisan key:generate
```

Edit `.env` and fill in:
- `APP_URL`
- `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`
- `MAIL_*` values

---

## 5. First deployment

```bash
chmod +x deploy.sh
./deploy.sh
```

`deploy.sh` performs, in order:
1. Maintenance mode on
2. `composer install --no-dev --optimize-autoloader`
3. `npm ci && npm run build` (if `package.json` present)
4. `php artisan migrate --force`
5. Config/route/view/event caching
6. `php artisan storage:link`
7. Storage/bootstrap-cache permission fix
8. Queue worker restart
9. Maintenance mode off

---

## 6. Web server (Nginx example)

```nginx
server {
    listen 80;
    server_name your-domain.com;
    root /var/www/abitadash/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.4-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

Then:

```bash
sudo ln -s /etc/nginx/sites-available/abitadash /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

Add HTTPS via `certbot --nginx -d your-domain.com` once DNS points to the VPS.

---

## 7. Continuous deployment via GitHub Actions

This repo includes `.github/workflows/deploy.yml`, which SSHes into the VPS and
runs `./deploy.sh` on every push to `main`.

Configure these **GitHub repository secrets** (Settings → Secrets and variables → Actions):

| Secret            | Description                                   |
|-------------------|------------------------------------------------|
| `VPS_HOST`        | VPS IP or hostname                             |
| `VPS_USER`        | SSH user (e.g. `deploy`)                       |
| `VPS_SSH_KEY`     | Private key with access to that user           |
| `VPS_PORT`        | SSH port (usually `22`)                        |
| `VPS_APP_PATH`    | Absolute path to the app on the VPS (step 3/4) |

Once secrets are set, every push to `main` auto-deploys.

---

## 8. Verifying a deployment

```bash
curl -I https://your-domain.com/up
```

Laravel's built-in health route (`/up`, configured in `bootstrap/app.php`) should
return `HTTP/1.1 200 OK` when the app booted successfully.

Also check:

```bash
tail -n 100 storage/logs/laravel.log
```

---

## 9. Rollback

```bash
cd /var/www/abitadash
git log --oneline -n 5
git reset --hard <previous-commit-sha>
./deploy.sh
```

---

## 10. Notes for the deploying agent

- Never commit real `.env` values; only use `.env.production.example` as a template.
- Always run `php artisan migrate --force` (not interactive `migrate`) in production.
- Mail sending failures must never block quote/contact submissions (already handled
  in `QuoteController`); no special deployment step is needed for that.
- If `CACHE_STORE`, `SESSION_DRIVER`, or `QUEUE_CONNECTION` is `database`, confirm the
  corresponding tables exist (`cache`, `sessions`, `jobs`) — migrations already cover this.
