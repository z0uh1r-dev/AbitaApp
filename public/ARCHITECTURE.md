# Architecture Documentation

## Overview

This Next.js application follows a **feature-based architecture** for maximum scalability and maintainability. The codebase is organized into clear, independent modules that can be developed, tested, and deployed separately.

## Core Principles

### 1. Separation of Concerns

- **UI Components**: Pure presentation logic in `/components` and `/UI`
- **Business Logic**: Feature modules in `/features`
- **Data Layer**: Services in `/services`
- **Utilities**: Helper functions in `/utils`

### 2. Feature-Based Structure

Each feature is self-contained with:

```
/features/{feature-name}/
  ├── hooks.ts           # React Query hooks
  ├── components/        # Feature-specific components
  ├── types.ts          # Feature-specific types
  └── utils.ts          # Feature-specific utilities
```

### 3. Type Safety

- **Strict TypeScript**: No `any` types
- **Centralized Types**: All types in `/types`
- **API Types**: Auto-generated from OpenAPI spec

## Directory Structure Explained

### `/app` - Next.js Pages

Server components by default, client components only when needed. Each page is responsible for:

- Data fetching (server-side)
- Layout composition
- SEO metadata
- Route handling

### `/components` - Shared UI Components

Reusable components used across multiple pages:

- `header.tsx` - Navigation header
- `footer.tsx` - Site footer
- `ErrorBoundary.tsx` - Error handling wrapper
- `LoadingFallback.tsx` - Loading states

### `/features` - Feature Modules

Independent, self-contained features:

#### Products Feature

- `hooks.ts` - useProducts, useProduct, useProductsByCategory
- Custom React Query hooks with caching

#### Categories Feature

- `hooks.ts` - useCategories, useCategory
- Aggressive caching (24 hours)

#### Quotes Feature

- `hooks.ts` - useSubmitQuote, useQuoteValidation
- Form validation and submission

### `/services` - Data Layer

Centralized API services:

```typescript
// Service architecture
apiService         → Core HTTP client
  ├── productsService    → Product operations
  ├── categoriesService  → Category operations
  └── quotesService      → Quote operations
```

Each service provides:

- Type-safe API calls
- Error handling
- Request/response transformation
- Caching strategies

### `/hooks` - Custom Hooks

Re-exports all feature hooks for easy importing:

```typescript
import { useProducts, useCategories } from "@/hooks";
```

### `/utils` - Utilities

Helper functions and constants:

- `helpers.ts` - Utility functions (formatCurrency, slugify, etc.)
- `constants.ts` - App-wide constants (routes, config, etc.)

### `/types` - Type Definitions

Centralized TypeScript types:

- `api.ts` - API response types
- `components.ts` - Component prop types
- `common.ts` - Utility types

### `/lib` - Libraries & Config

Configuration files:

- `react-query.ts` - React Query configuration
- `api-error-handler.ts` - Error handling utilities
- `image-utils.ts` - Image URL helpers

### `/UI` - Base UI Components

Atomic UI components:

- `ProductCard.tsx`
- `CategoryCard.tsx`
- `RelatedProductCard.tsx`
- etc.

## Data Flow

### Server Components (Default)

```
Page (RSC) → Service → API → Response
                ↓
         Render with data
```

### Client Components (When Needed)

```
Component → Hook → React Query → Service → API
                       ↓
                   Cache layer
                       ↓
               Component re-render
```

## Caching Strategy

### Server-Side (ISR)

- **Products**: 1 hour revalidation
- **Categories**: 24 hours revalidation
- **Product Details**: 1 hour revalidation

### Client-Side (React Query)

- **Products**: 5 minutes stale time
- **Categories**: 24 hours stale time
- **Product Details**: 10 minutes stale time

## Error Handling

### Levels of Error Handling

1. **Component Level**: Error boundaries catch React errors
2. **API Level**: Services wrap all API calls with try/catch
3. **Global Level**: App-wide error boundary in layout

### Error Flow

```
API Error → Service catches → Returns null/empty
                 ↓
         Logs to console
                 ↓
    Component handles gracefully
```

## Performance Optimizations

### 1. Image Optimization

- Next.js Image component
- Lazy loading by default
- Responsive sizes
- WebP/AVIF formats

### 2. Code Splitting

- Dynamic imports for heavy components
- Route-based code splitting (automatic)
- Component-level splitting

### 3. Caching

- ISR for static-like pages
- React Query for client-side
- CDN caching for static assets

### 4. Prefetching

- Link prefetch enabled
- Preload critical resources
- Predictive prefetching

## Testing Strategy

### Unit Tests

- Utility functions
- Service layer
- Custom hooks

### Integration Tests

- Component interactions
- Feature workflows
- API integration

### Test Organization

```
/__tests__/
  ├── utils/           # Utility tests
  ├── services/        # Service tests
  └── test-utils.tsx   # Testing utilities
```

## Best Practices

### 1. Component Design

- **Server First**: Use server components by default
- **Client When Needed**: Only for interactivity
- **Small & Focused**: Each component has one responsibility
- **Typed Props**: Always define prop types

### 2. State Management

- **Server State**: React Query for API data
- **Local State**: useState for component state
- **URL State**: searchParams for filters/pagination

### 3. API Integration

- **Type-Safe**: Auto-generated types from OpenAPI
- **Centralized**: All API calls through services
- **Error Handled**: Every API call wrapped in try/catch
- **Cached**: Appropriate caching per endpoint

### 4. Code Quality

- **TypeScript Strict**: No implicit any
- **ESLint**: Consistent code style
- **Prettier**: Automatic formatting
- **Comments**: Document complex logic

## Scalability Considerations

### Adding New Features

1. Create feature directory in `/features`
2. Add hooks with React Query
3. Create feature-specific components
4. Export through `/hooks/index.ts`

### Adding New API Endpoints

1. Update OpenAPI spec
2. Regenerate Orval client
3. Add service method
4. Create React Query hook
5. Use in components

### Adding New Pages

1. Create in `/app`
2. Use server components
3. Fetch data with services
4. Add to navigation

## Deployment

### Build Process

```bash
npm run build    # Creates optimized production build
```

### Environment Variables

- `NEXT_PUBLIC_API_BASE_URL` - Backend API URL
- `DATABASE_URL` - PostgreSQL connection string

### Production Checklist

- [ ] Environment variables set
- [ ] Database migrations run
- [ ] API endpoints accessible
- [ ] Error tracking enabled
- [ ] Analytics configured
- [ ] SEO metadata added

## Maintenance

### Regular Tasks

- Update dependencies monthly
- Review and fix security vulnerabilities
- Monitor error logs
- Optimize slow queries
- Review and update cache times

### Code Reviews

- Check for proper TypeScript usage
- Verify error handling
- Ensure proper caching
- Review for performance issues
- Validate accessibility
