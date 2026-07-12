/**
 * Utility Functions
 *
 * Collection of reusable utility functions for common operations.
 *
 * @module utils/helpers
 */

/**
 * Format a number as currency (MAD - Moroccan Dirham)
 *
 * @param amount - Amount to format
 * @param locale - Locale for formatting (default: 'fr-MA')
 * @returns Formatted currency string
 *
 * @example
 * ```ts
 * formatCurrency(1234.56) // "1 234,56 MAD"
 * ```
 */
export function formatCurrency(amount: number, locale = "fr-MA"): string {
  return new Intl.NumberFormat(locale, {
    style: "currency",
    currency: "MAD",
  }).format(amount);
}

/**
 * Format a date to a readable string
 *
 * @param date - Date to format
 * @param locale - Locale for formatting (default: 'fr-MA')
 * @returns Formatted date string
 *
 * @example
 * ```ts
 * formatDate(new Date()) // "6 mars 2026"
 * ```
 */
export function formatDate(date: Date | string, locale = "fr-MA"): string {
  const dateObj = typeof date === "string" ? new Date(date) : date;
  return new Intl.DateTimeFormat(locale, {
    year: "numeric",
    month: "long",
    day: "numeric",
  }).format(dateObj);
}

/**
 * Truncate text to a specified length with ellipsis
 *
 * @param text - Text to truncate
 * @param maxLength - Maximum length before truncation
 * @returns Truncated text
 *
 * @example
 * ```ts
 * truncate("This is a long text", 10) // "This is a..."
 * ```
 */
export function truncate(text: string, maxLength: number): string {
  if (text.length <= maxLength) return text;
  return text.slice(0, maxLength).trim() + "...";
}

/**
 * Generate a slug from a string
 *
 * @param text - Text to slugify
 * @returns URL-friendly slug
 *
 * @example
 * ```ts
 * slugify("Hello World!") // "hello-world"
 * ```
 */
export function slugify(text: string): string {
  return text
    .toLowerCase()
    .trim()
    .replace(/[^\w\s-]/g, "")
    .replace(/[\s_-]+/g, "-")
    .replace(/^-+|-+$/g, "");
}

/**
 * Debounce a function call
 *
 * @param func - Function to debounce
 * @param wait - Wait time in milliseconds
 * @returns Debounced function
 *
 * @example
 * ```ts
 * const search = debounce((query: string) => {
 *   console.log("Searching for:", query);
 * }, 300);
 *
 * search("test"); // Only executes after 300ms of inactivity
 * ```
 */
export function debounce<T extends (...args: unknown[]) => unknown>(
  func: T,
  wait: number
): (...args: Parameters<T>) => void {
  let timeout: NodeJS.Timeout | null = null;

  return function executedFunction(...args: Parameters<T>) {
    const later = () => {
      timeout = null;
      func(...args);
    };

    if (timeout) clearTimeout(timeout);
    timeout = setTimeout(later, wait);
  };
}

/**
 * Deep clone an object
 *
 * @param obj - Object to clone
 * @returns Cloned object
 *
 * @example
 * ```ts
 * const original = { a: 1, b: { c: 2 } };
 * const cloned = deepClone(original);
 * cloned.b.c = 3; // Doesn't affect original
 * ```
 */
export function deepClone<T>(obj: T): T {
  if (obj === null || typeof obj !== "object") return obj;
  return JSON.parse(JSON.stringify(obj));
}

/**
 * Check if a value is empty (null, undefined, empty string, empty array, empty object)
 *
 * @param value - Value to check
 * @returns True if empty, false otherwise
 *
 * @example
 * ```ts
 * isEmpty(null) // true
 * isEmpty("") // true
 * isEmpty([]) // true
 * isEmpty({}) // true
 * isEmpty("text") // false
 * ```
 */
export function isEmpty(
  value: unknown
): value is null | undefined | "" | [] | Record<string, never> {
  if (value === null || value === undefined) return true;
  if (typeof value === "string") return value.trim().length === 0;
  if (Array.isArray(value)) return value.length === 0;
  if (typeof value === "object") return Object.keys(value).length === 0;
  return false;
}

/**
 * Generate a random ID
 *
 * @returns Random ID string
 *
 * @example
 * ```ts
 * generateId() // "a3f5d8c2"
 * ```
 */
export function generateId(): string {
  return Math.random().toString(36).substring(2, 10);
}

/**
 * Capitalize first letter of a string
 *
 * @param text - Text to capitalize
 * @returns Capitalized text
 *
 * @example
 * ```ts
 * capitalize("hello world") // "Hello world"
 * ```
 */
export function capitalize(text: string): string {
  if (!text) return "";
  return text.charAt(0).toUpperCase() + text.slice(1);
}
