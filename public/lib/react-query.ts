/**
 * React Query Configuration
 *
 * Provides centralized configuration for @tanstack/react-query.
 * Defines default caching strategies, retry logic, and query behaviors.
 *
 * @module lib/react-query
 */

import { QueryClient, DefaultOptions } from "@tanstack/react-query";

/**
 * Default query options for React Query
 *
 * - staleTime: Data is considered fresh for 5 minutes
 * - gcTime: Unused data is garbage collected after 10 minutes
 * - retry: Failed queries retry up to 3 times with exponential backoff
 * - refetchOnWindowFocus: Refetch when user returns to the tab
 */
const defaultOptions: DefaultOptions = {
  queries: {
    staleTime: 5 * 60 * 1000, // 5 minutes
    gcTime: 10 * 60 * 1000, // 10 minutes (formerly cacheTime)
    retry: 3,
    retryDelay: (attemptIndex) => Math.min(1000 * 2 ** attemptIndex, 30000),
    refetchOnWindowFocus: true,
    refetchOnReconnect: true,
    refetchOnMount: false, // Don't refetch if data is fresh (performance boost)
  },
  mutations: {
    retry: 1,
    retryDelay: 1000,
  },
};

/**
 * Create a new QueryClient instance
 *
 * This should be called once per request on the server
 * and once per app instance on the client.
 *
 * @returns Configured QueryClient instance
 */
export function createQueryClient(): QueryClient {
  return new QueryClient({
    defaultOptions,
  });
}

/**
 * Query keys for consistent cache management
 *
 * Organized by feature to prevent cache key collisions
 * and make invalidation easier.
 */
export const queryKeys = {
  products: {
    all: ["products"] as const,
    byCategory: (category: string) =>
      ["products", "category", category] as const,
    bySlug: (slug: string) => ["products", "slug", slug] as const,
    related: (slug: string) => ["products", "related", slug] as const,
  },
  categories: {
    all: ["categories"] as const,
    bySlug: (slug: string) => ["categories", "slug", slug] as const,
  },
} as const;
