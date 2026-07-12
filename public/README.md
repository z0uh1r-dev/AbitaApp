# Abita - Corporate Gifts & Office Supplies

A professional Next.js application for corporate gifts, office supplies, and interior design services.

## 🚀 Features

- **Product Catalog**: Browse and filter products by category
- **Product Details**: View detailed product information with specifications and customization options
- **Interior Design**: Showcase of interior design services
- **Quote System**: Request quotes for products and services
- **Performance Optimized**: Server-side rendering, image optimization, and smart caching
- **Type-Safe**: Full TypeScript implementation with comprehensive type definitions
- **Testing**: Jest and React Testing Library setup for unit and integration tests

## 📁 Project Structure

```
/app                    # Next.js app router pages
/components             # Reusable UI components
/features               # Feature-based modules
  /products            # Product-related features
  /categories          # Category-related features
  /quotes              # Quote system features
  /interior-design     # Interior design features
/services              # API services and data fetching
/hooks                 # Custom React hooks
/utils                 # Utility functions and constants
/types                 # TypeScript type definitions
/lib                   # Libraries and configurations
/UI                    # Base UI components
/public                # Static assets
/__tests__             # Test files
```

## 🛠️ Tech Stack

- **Framework**: Next.js 16 with App Router
- **Language**: TypeScript 5
- **Styling**: Tailwind CSS 4
- **Data Fetching**: @tanstack/react-query
- **API Client**: Orval (auto-generated from OpenAPI)
- **Testing**: Jest + React Testing Library
- **Code Quality**: ESLint + Prettier
- **Backend**: Laravel API (external)

## 📦 Installation

```bash
# Install dependencies
npm install

# Setup environment variables
cp .env.example .env
# Configure NEXT_PUBLIC_API_BASE_URL in .env

# Start development server
npm run dev
```

## 🔧 Available Scripts

```bash
npm run dev              # Start development server
npm run build            # Build for production
npm run start            # Start production server
npm run lint             # Run ESLint
npm run format           # Format code with Prettier
npm run format:check     # Check code formatting
npm run test             # Run tests
npm run test:watch       # Run tests in watch mode
npm run test:coverage    # Run tests with coverage
```

## 🌐 Environment Variables

Copy the template before running the app:

```bash
cp .env.example .env
```

```bash
# API Configuration
NEXT_PUBLIC_API_BASE_URL=http://localhost:8000/api/v1
NEXT_PUBLIC_GET_QUOTE_API_ENDPOINT=api/v1/quotes
NEXT_PUBLIC_CONTACT_API_ENDPOINT=api/v1/contact-messages

# Client error telemetry (set to false to disable)
NEXT_PUBLIC_ENABLE_CLIENT_ERROR_REPORTING=true
```

`NEXT_PUBLIC_GET_QUOTE_API_ENDPOINT` accepts `/quotes`, `api/v1/quotes`, or `/api/v1/quotes`.
`NEXT_PUBLIC_CONTACT_API_ENDPOINT` should point to your backend contact route (for this backend: `api/v1/contact-messages`).

When telemetry is enabled, browser runtime errors are sent to `/api/client-errors` in production builds.

## 🏗️ Architecture

### Service Layer

Centralized API services with consistent error handling and caching strategies:

- `apiService`: Core HTTP client
- `productsService`: Product data operations
- `categoriesService`: Category data operations
- `quotesService`: Quote submission and validation
- `contactService`: Contact form submission and validation

### Feature-Based Organization

Each feature contains:

- `hooks.ts`: Custom React Query hooks
- `components/`: Feature-specific components
- `types.ts`: Feature-specific types
- `utils.ts`: Feature-specific utilities

### Caching Strategy

- **Products**: 5 minutes (ISR)
- **Categories**: 24 hours (ISR)
- **Product Details**: 10 minutes (ISR)
- **React Query**: 5-10 minutes client-side cache

## 🧪 Testing

```bash
# Run all tests
npm test

# Watch mode
npm run test:watch

# Coverage report
npm run test:coverage
```

Tests are organized in `__tests__/` directory with utilities in `test-utils.tsx`.

## 📚 Code Quality

### TypeScript

- Strict mode enabled
- Comprehensive type definitions in `/types`
- No `any` types allowed

### ESLint + Prettier

- Automatic code formatting
- Consistent code style
- Import organization

### Best Practices

- Functional components with hooks
- Server components by default
- Client components only when needed
- Error boundaries for error handling
- Loading states for better UX
- Proper TypeScript typing

## 🚀 Performance Optimizations

- **Image Optimization**: Next.js Image with lazy loading
- **Code Splitting**: Dynamic imports for heavy components
- **Prefetching**: Link prefetch for better navigation
- **Caching**: ISR and React Query caching
- **Server Components**: Default to server-side rendering

## 📄 API Integration

The application integrates with a Laravel backend API:

- Auto-generated API client using Orval
- Type-safe API calls
- Consistent error handling
- Request/response transformation

## 🤝 Contributing

1. Follow the established folder structure
2. Write TypeScript with proper types
3. Add tests for new features
4. Format code with Prettier
5. Ensure no ESLint errors

## 🐳 VPS Deployment (Docker)

### Prerequisites

- Docker ≥ 24 and Docker Compose v2 installed on the VPS
- The Laravel API reachable from the VPS (same network or public URL)

### 1 — Environment variables

```bash
cp .env.production.example .env.production
# Edit .env.production and set NEXT_PUBLIC_API_BASE_URL to your real API URL
```

### 2 — Build & run

```bash
# On the VPS (or build locally and push the image)
docker compose --env-file .env.production up -d --build
```

The container starts on port `3000` by default. Override with `APP_PORT` in `.env.production`.

### 3 — Nginx reverse proxy (recommended)

Put this in your Nginx site config and reload Nginx:

```nginx
server {
    listen 80;
    server_name yourdomain.com;

    location / {
        proxy_pass         http://127.0.0.1:3000;
        proxy_http_version 1.1;
        proxy_set_header   Upgrade $http_upgrade;
        proxy_set_header   Connection "upgrade";
        proxy_set_header   Host $host;
        proxy_cache_bypass $http_upgrade;
    }
}
```

Then add HTTPS with Certbot:

```bash
certbot --nginx -d yourdomain.com
```

### 4 — Update deployment

```bash
git pull
docker compose --env-file .env.production up -d --build
```

### Environment variable reference

| Variable                   | Required | Default                        | Description                       |
| -------------------------- | -------- | ------------------------------ | --------------------------------- |
| `NEXT_PUBLIC_API_BASE_URL` | ✅       | `http://localhost:8000/api/v1` | Full URL to the Laravel API       |
| `APP_PORT`                 | ❌       | `3000`                         | Host port mapped to the container |

## 📝 License

Copyright © 2026 Abita. All rights reserved.
