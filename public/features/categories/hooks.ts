/**
 * Categories Feature - Custom Hooks
 *
 * React Query hooks for category-related data fetching.
 *
 * @module features/categories/hooks
 */

"use client";

import { useQuery } from "@tanstack/react-query";
import { categoriesService } from "@/services";
import { queryKeys } from "@/lib/react-query";

/**
 * Hook to fetch all categories with caching
 *
 * Categories are cached aggressively (24 hours) since they rarely change.
 *
 * @example
 * ```tsx
 * function CategoryFilter() {
 *   const { data: categories, isLoading } = useCategories();
 *
 *   if (isLoading) return <LoadingSpinner />;
 *
 *   return (
 *     <div>
 *       {categories?.map(cat => (
 *         <CategoryLink key={cat.id} {...cat} />
 *       ))}
 *     </div>
 *   );
 * }
 * ```
 */
export function useCategories() {
  return useQuery({
    queryKey: queryKeys.categories.all,
    queryFn: () => categoriesService.getAll(),
    staleTime: 24 * 60 * 60 * 1000, // 24 hours
  });
}

/**
 * Hook to fetch a single category by slug
 *
 * @param slug - Category slug
 *
 * @example
 * ```tsx
 * function CategoryHeader({ slug }: { slug: string }) {
 *   const { data: category } = useCategory(slug);
 *   return <h1>{category?.name}</h1>;
 * }
 * ```
 */
export function useCategory(slug: string) {
  return useQuery({
    queryKey: queryKeys.categories.bySlug(slug),
    queryFn: () => categoriesService.getBySlug(slug),
    enabled: !!slug,
    staleTime: 24 * 60 * 60 * 1000,
  });
}
