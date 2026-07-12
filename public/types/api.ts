/**
 * API Response Types
 *
 * Centralized type definitions for all API responses.
 * These types match the Laravel backend API structure.
 *
 * @module types/api
 */

/**
 * Category entity
 * Represents a product category in the system
 */
export interface Category {
  id: number;
  name: string;
  slug: string;
  description?: string | null;
  imageUrl?: string | null;
  createdAt?: Date;
  updatedAt?: Date;
}

/**
 * Product specification entity
 * Technical details and features of a product
 */
export interface ProductSpecification {
  id: number;
  label: string;
  value: string;
  productId: number;
}

/**
 * Product customization option
 * Available customizations for a product (e.g., colors, sizes)
 */
export interface ProductCustomization {
  id: number;
  label: string;
  productId: number;
}

/**
 * Product image entity
 * Additional images for product galleries
 */
export interface ProductImage {
  id: number;
  url: string;
  alt?: string | null;
  order: number;
  productId: number;
}

/**
 * Product entity
 * Main product model with all related data
 */
export interface Product {
  id: number;
  name: string;
  slug: string;
  description: string;
  imageUrl: string;
  categoryId: number;
  category?: Category;
  specifications?: ProductSpecification[];
  customizations?: ProductCustomization[];
  images?: ProductImage[];
  createdAt?: Date;
  updatedAt?: Date;
}

/**
 * Quote request entity
 * Customer quote/inquiry submission
 */
export interface Quote {
  id: number;
  name: string;
  email: string;
  phone: string;
  company?: string | null;
  message: string;
  productId?: number | null;
  product?: Product | null;
  status?: "pending" | "reviewed" | "contacted" | "completed";
  createdAt: Date;
  updatedAt?: Date;
}

/**
 * Generic API response wrapper
 * Standard response format from the backend
 */
export interface ApiResponse<T> {
  data: T;
  status: number;
  headers: Headers;
  message?: string;
}

/**
 * Paginated API response
 * Used for list endpoints with pagination
 */
export interface PaginatedResponse<T> {
  data: T[];
  meta?: {
    total: number;
    page: number;
    perPage: number;
    lastPage?: number;
  };
  links?: {
    first?: string;
    last?: string;
    prev?: string | null;
    next?: string | null;
  };
}

/**
 * API Error response
 * Standard error format from the backend
 */
export interface ApiErrorResponse {
  message: string;
  errors?: Record<string, string[]>;
  statusCode: number;
}
