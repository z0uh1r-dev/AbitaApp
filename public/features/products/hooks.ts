/**
 * Products Feature - Custom Hooks
 *
 * React Query hooks for product-related data fetching.
 * Provides optimized caching and automatic refetching.
 *
 * @module features/products/hooks
 */

"use client";

import { useQuery } from "@tanstack/react-query";
import { productsService } from "@/services";
import { queryKeys } from "@/lib/react-query";

/**
 * Hook to fetch all products with caching
 *
 * @example
 * ```tsx
 * function ProductsList() {
 *   const { data: products, isLoading, error } = useProducts();
 *
 *   if (isLoading) return <LoadingSpinner />;
 *   if (error) return <ErrorMessage />;
 *
 *   return <div>{products.map(p => <ProductCard key={p.id} {...p} />)}</div>;
 * }
 * ```
 */
export function useProducts() {
  return useQuery({
    queryKey: queryKeys.products.all,
    queryFn: () => productsService.getAll(),
    staleTime: 5 * 60 * 1000, // 5 minutes
  });
}

/**
 * Hook to fetch products by category with caching
 *
 * @param categorySlug - Category slug to filter by
 *
 * @example
 * ```tsx
 * function CategoryProducts({ category }: { category: string }) {
 *   const { data: products } = useProductsByCategory(category);
 *   return <ProductGrid products={products} />;
 * }
 * ```
 */
export function useProductsByCategory(categorySlug: string) {
  return useQuery({
    queryKey: queryKeys.products.byCategory(categorySlug),
    queryFn: () => productsService.getByCategory(categorySlug),
    enabled: !!categorySlug,
    staleTime: 5 * 60 * 1000,
  });
}

/**
 * Hook to fetch a single product by slug with caching
 *
 * @param slug - Product slug
 *
 * @example
 * ```tsx
 * function ProductDetail({ slug }: { slug: string }) {
 *   const { data, isLoading } = useProduct(slug);
 *
 *   if (isLoading) return <LoadingFallback />;
 *   if (!data?.product) return <NotFound />;
 *
 *   return <ProductInfo product={data.product} related={data.relatedProducts} />;
 * }
 * ```
 */
export function useProduct(slug: string) {
  return useQuery({
    queryKey: queryKeys.products.bySlug(slug),
    queryFn: () => productsService.getBySlug(slug),
    enabled: !!slug,
    staleTime: 10 * 60 * 1000, // 10 minutes for individual products
  });
}
