/**
 * Products Service
 *
 * Handles all product-related API operations including fetching products,
 * filtering by category, and retrieving individual product details.
 *
 * @module services/products.service
 */

import { apiService } from "./api.service";
import type { Product } from "@/types/api";

/**
 * Product API response structure
 * Matches the Laravel API response format with nested data
 */
interface ProductsApiResponse {
  data: {
    data: Product[];
  };
}

/**
 * Single product API response structure
 */
interface ProductDetailApiResponse {
  data: {
    data: Product;
    relatedProducts: Product[];
  };
}

/**
 * Products Service
 *
 * Centralized service for product-related operations.
 * Uses Next.js caching strategies for optimal performance.
 */
export const productsService = {
  /**
   * Fetch all products
   *
   * Uses ISR (Incremental Static Regeneration) to cache results for 1 hour.
   * This improves performance while keeping data relatively fresh.
   *
   * @returns Promise resolving to array of products
   */
  async getAll(): Promise<Product[]> {
    try {
      const response = await apiService.get<ProductsApiResponse>("/products", {
        next: { revalidate: 3600 }, // Revalidate every hour
      });
      return response.data.data || [];
    } catch (error) {
      console.error("Failed to fetch products:", error);
      return [];
    }
  },

  /**
   * Fetch products by category slug
   *
   * Filters products by category using the API endpoint.
   * Uses ISR caching for better performance.
   *
   * @param categorySlug - Category slug to filter by
   * @returns Promise resolving to array of filtered products
   */
  async getByCategory(categorySlug: string): Promise<Product[]> {
    try {
      const response = await apiService.get<ProductsApiResponse>(
        `/categories/${categorySlug}/products`,
        {
          next: { revalidate: 3600 }, // Revalidate every hour
        }
      );
      return response.data.data || [];
    } catch (error) {
      console.error(
        `Failed to fetch products for category ${categorySlug}:`,
        error
      );
      return [];
    }
  },

  /**
   * Fetch product by slug with related products
   *
   * Retrieves detailed product information including specifications,
   * customizations, and related products. Uses ISR caching.
   *
   * @param slug - Product slug
   * @returns Promise resolving to product details and related products
   */
  async getBySlug(slug: string): Promise<{
    product: Product | null;
    relatedProducts: Product[];
  }> {
    try {
      const response = await apiService.get<ProductDetailApiResponse>(
        `/products/${slug}`,
        {
          next: { revalidate: 3600 }, // Revalidate every hour
        }
      );
      return {
        product: response.data.data || null,
        relatedProducts: response.data.relatedProducts || [],
      };
    } catch (error) {
      console.error(`Failed to fetch product ${slug}:`, error);
      return {
        product: null,
        relatedProducts: [],
      };
    }
  },
};
