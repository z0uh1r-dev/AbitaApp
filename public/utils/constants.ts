/**
 * Constants
 *
 * Application-wide constants and configuration values.
 * Centralized location for all magic numbers and strings.
 *
 * @module utils/constants
 */

/**
 * API Configuration
 */
export const API = {
  BASE_URL:
    process.env.NEXT_PUBLIC_API_BASE_URL || "http://localhost:8000/api/v1",
  TIMEOUT: 30000,
  RETRY_ATTEMPTS: 3,
} as const;

/**
 * Cache Configuration (in milliseconds)
 */
export const CACHE = {
  PRODUCTS: 5 * 60 * 1000, // 5 minutes
  CATEGORIES: 24 * 60 * 60 * 1000, // 24 hours
  PRODUCT_DETAIL: 10 * 60 * 1000, // 10 minutes
} as const;

/**
 * Pagination Configuration
 */
export const PAGINATION = {
  DEFAULT_PAGE_SIZE: 12,
  MAX_PAGE_SIZE: 100,
} as const;

/**
 * Validation Rules
 */
export const VALIDATION = {
  NAME_MIN_LENGTH: 2,
  NAME_MAX_LENGTH: 100,
  EMAIL_REGEX: /^[^\s@]+@[^\s@]+\.[^\s@]+$/,
  PHONE_REGEX: /^\+?[\d\s-()]+$/,
  MESSAGE_MIN_LENGTH: 10,
  MESSAGE_MAX_LENGTH: 1000,
} as const;

/**
 * Application Routes
 */
export const ROUTES = {
  HOME: "/",
  PRODUCTS: "/products",
  PRODUCT_DETAIL: (slug: string) => `/products/${slug}`,
  INTERIOR_DESIGN: "/interior-design",
  GET_QUOTE: "/get-quote",
  CONTACT: "/contact",
} as const;

/**
 * Social Media Links
 */
export const SOCIAL = {
  FACEBOOK: "https://facebook.com/abita",
  INSTAGRAM: "https://instagram.com/abita",
  LINKEDIN: "https://linkedin.com/company/abita",
} as const;

/**
 * Contact Information
 */
export const CONTACT = {
  EMAIL: "contact@abita.ma",
  PHONE: "+212 5XX-XXXXXX",
  ADDRESS: "Casablanca, Morocco",
} as const;

/**
 * SEO Configuration
 */
export const SEO = {
  DEFAULT_TITLE: "Abita - Corporate Gifts & Office Supplies",
  DEFAULT_DESCRIPTION:
    "Customized office and corporate products for your business. Quality gifts, office supplies, and interior design services.",
  SITE_NAME: "Abita",
  TWITTER_HANDLE: "@abita",
} as const;

/**
 * Image Configuration
 */
export const IMAGES = {
  PLACEHOLDER:
    "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400'%3E%3Crect fill='%23f3f4f6' width='400' height='400'/%3E%3C/svg%3E",
  QUALITY: 90,
  FORMATS: ["image/webp", "image/avif"],
} as const;

/**
 * Feature Flags
 */
export const FEATURES = {
  ENABLE_WISHLIST: false,
  ENABLE_COMPARISON: false,
  ENABLE_REVIEWS: false,
  ENABLE_CHAT: false,
} as const;
