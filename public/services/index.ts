/**
 * Service Layer Index
 *
 * Central export point for all application services.
 * Import services from this file for consistent access patterns.
 *
 * @example
 * ```ts
 * import { productsService, categoriesService } from '@/services';
 *
 * const products = await productsService.getAll();
 * const categories = await categoriesService.getAll();
 * ```
 */

export { apiService, getStorageUrl } from "./api.service";
export { productsService } from "./products.service";
export { categoriesService } from "./categories.service";
export { quotesService } from "./quotes.service";
export { contactService } from "./contact.service";
export type { QuoteSubmission } from "./quotes.service";
export type { ContactSubmission } from "./contact.service";
