/**
 * Custom Hooks Index
 *
 * Central export point for all custom React hooks.
 * Organizes hooks by feature for easy discovery and import.
 *
 * @example
 * ```tsx
 * import { useProducts, useCategories, useSubmitQuote } from '@/hooks';
 * ```
 */

// Products hooks
export {
  useProducts,
  useProductsByCategory,
  useProduct,
} from "@/features/products/hooks";

// Categories hooks
export { useCategories, useCategory } from "@/features/categories/hooks";

// Quotes hooks
export { useSubmitQuote, useQuoteValidation } from "@/features/quotes/hooks";
