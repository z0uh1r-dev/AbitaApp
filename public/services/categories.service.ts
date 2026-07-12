/**
 * Categories Service
 *
 * Handles all category-related API operations.
 * Provides centralized access to product categories.
 *
 * @module services/categories.service
 */

import { apiService } from "./api.service";
import type { Category } from "@/types/api";

/**
 * Categories API response structure
 */
interface CategoriesApiResponse {
  data: {
    data: Category[];
  };
}

/**
 * Categories Service
 *
 * Centralized service for category-related operations.
 * Uses aggressive caching since categories change infrequently.
 */
export const categoriesService = {
  /**
   * Fetch all product categories
   *
   * Uses ISR with 24-hour revalidation since categories rarely change.
   * This provides excellent performance for navigation and filtering.
   *
   * @returns Promise resolving to array of categories
   */
  async getAll(): Promise<Category[]> {
    try {
      const response = await apiService.get<CategoriesApiResponse>(
        "/categories",
        {
          next: { revalidate: 86400 }, // Revalidate once per day
        }
      );
      return response.data.data || [];
    } catch (error) {
      console.error("Failed to fetch categories:", error);
      return [];
    }
  },

  /**
   * Fetch a single category by slug
   *
   * @param slug - Category slug
   * @returns Promise resolving to category or null
   */
  async getBySlug(slug: string): Promise<Category | null> {
    try {
      const categories = await this.getAll();
      return categories.find((cat) => cat.slug === slug) || null;
    } catch (error) {
      console.error(`Failed to fetch category ${slug}:`, error);
      return null;
    }
  },
};
