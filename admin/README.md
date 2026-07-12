# AbitaDash

AbitaDash is a Laravel 12 web application that powers a company's public catalog site and an internal admin dashboard for managing categories, products, quote requests, and contact messages.

## Overview

The app serves two audiences:

- **Public API (`/api/v1/*`)** – a JSON API consumed by a public-facing frontend to browse categories/products and submit quote or contact requests.
- **Admin Dashboard (`/admin/*`)** – an authenticated back-office where staff manage the catalog and respond to customer quote/contact submissions.

## Key Features

- **Category & Product Catalog**
  - Categories with images, slugs, and descriptions.
  - Products with specifications, customizations, and image galleries.
  - Public endpoints to list categories, list products by category, and fetch product details with related products.

- **Quote Requests**
  - Public endpoint (`POST /api/v1/quotes`) for customers to request a quote (company, contact, email, phone, description).
  - Automatic email notifications on submission:
    - Admin notification email to all admin users.
    - Confirmation email sent back to the customer.
  - Mail sending is **best-effort**: a quote is always saved even if email delivery fails; failures are logged, not surfaced to the client.
  - Admin dashboard view to list, filter, update status (`New`, `In Progress`, `Completed`), and delete quotes.

- **Contact Messages**
  - Public endpoint (`POST /api/v1/contact-messages`) for general contact form submissions.
  - Admin dashboard view to list, view, and delete messages.

- **Admin Authentication & Authorization**
  - Session-based login for admin users.
  - `EnsureUserIsAdmin` middleware and `AdminPolicy` gate all `/admin/*` routes to users with `is_admin = true`.

- **API Documentation**
  - OpenAPI/Swagger docs available via `l5-swagger`, describing the public catalog and quote/contact endpoints.

## Tech Stack

- **Backend:** PHP 8.4, Laravel 12
- **Testing:** Pest 4 / PHPUnit 12
- **Code style:** Laravel Pint
- **Frontend build:** Vite, Tailwind CSS 4
- **Database:** MySQL (via Eloquent ORM), with `database`-backed cache, session, and queue drivers
- **Mail:** Laravel Mailables (SMTP, e.g. Gmail) with HTML branded templates

## Project Structure (high level)

```
app/
  Http/Controllers/
    Api/        # Public JSON API controllers (Category, Product, Quote, ContactMessage)
    Admin/       # Admin dashboard controllers (Dashboard, Category, Product, Quote, ContactMessage)
    Auth/        # Admin login
  Mail/          # Quote notification mailables (NewQuoteForAdmin, QuoteReceivedConfirmation)
  Models/        # Eloquent models (Category, Product, Quote, ContactMessage, User, ...)
  Policies/      # AdminPolicy (gates admin routes)
  Http/Middleware/EnsureUserIsAdmin.php

routes/
  api.php        # Public API routes (/api/v1/...)
  admin.php      # Admin dashboard routes (/admin/...), auth + admin middleware
  web.php        # Web routes, includes admin.php

resources/views/
  admin/         # Blade views for the admin dashboard
  auth/          # Login view
  mail/quotes/   # Branded HTML email templates for quote notifications

database/migrations/  # Schema for categories, products, quotes, contact messages, users, cache, sessions
tests/Feature/         # Feature tests (Pest) for API endpoints, including quote email notifications
```

## Core Data Model

- **Category** → has many **Products**
- **Product** → belongs to Category, has many **ProductSpecifications**, **ProductCustomizations**, **ProductImages**
- **Quote** → standalone lead record with `status` (`New`, `In Progress`, `Completed`)
- **ContactMessage** → standalone contact form submission
- **User** → `is_admin` flag controls access to the admin dashboard

## Getting Started

### Requirements

- PHP 8.4+
- Composer
- Node.js + npm
- MySQL

### Setup

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

# Configure DB_* and MAIL_* values in .env

php artisan migrate
npm run build   # or `npm run dev` during development
```

### Running Tests

```bash
php artisan test --compact
```

### Code Style

```bash
vendor/bin/pint --dirty --format agent
```

## Email Notifications

When a quote is submitted via the API, two emails are sent:

1. **`NewQuoteForAdmin`** → sent to every user with `is_admin = true`.
2. **`QuoteReceivedConfirmation`** → sent to the customer's submitted email.

Both use branded HTML templates (`resources/views/mail/quotes/*.blade.php`) with the company logo, and both sends are wrapped so that a mail failure never blocks quote creation or surfaces an error to the end user.

Configure your mailer in `.env` (see `MAIL_MAILER`, `MAIL_HOST`, `MAIL_PORT`, `MAIL_USERNAME`, `MAIL_PASSWORD`, `MAIL_ENCRYPTION`, `MAIL_FROM_ADDRESS`, `MAIL_FROM_NAME`).

## License

Built on the [Laravel](https://laravel.com) framework, licensed under the [MIT license](https://opensource.org/licenses/MIT).
