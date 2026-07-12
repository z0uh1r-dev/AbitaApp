/**
 * Centralized API Service
 *
 * Provides a unified interface for all API communication with the Laravel backend.
 * Handles request configuration, error transformation, and response parsing.
 *
 * @module services/api.service
 */

import { ApiError } from "@/lib/api-error-handler";

/** Base API configuration */
const API_CONFIG = {
  baseUrl:
    process.env.NEXT_PUBLIC_API_BASE_URL || "http://localhost:8000/api/v1",
  timeout: 30000,
  headers: {
    "Content-Type": "application/json",
    Accept: "application/json",
  },
} as const;

/** HTTP methods supported by the API service */
type HttpMethod = "GET" | "POST" | "PUT" | "PATCH" | "DELETE";

/** API request configuration options */
interface RequestConfig {
  method?: HttpMethod;
  body?: unknown;
  headers?: Record<string, string>;
  cache?: RequestCache;
  next?: NextFetchRequestConfig;
}

/**
 * Makes an HTTP request to the API
 *
 * @param endpoint - API endpoint (e.g., "/products")
 * @param config - Request configuration options
 * @returns Parsed JSON response
 * @throws {ApiError} When the request fails or returns an error status
 */
async function request<T>(
  endpoint: string,
  config: RequestConfig = {}
): Promise<T> {
  const { method = "GET", body, headers = {}, cache, next } = config;

  const url = `${API_CONFIG.baseUrl}${endpoint}`;

  const requestOptions: RequestInit = {
    method,
    headers: {
      ...API_CONFIG.headers,
      ...headers,
    },
    cache,
    next,
  };

  if (body && method !== "GET") {
    requestOptions.body = JSON.stringify(body);
  }

  try {
    const response = await fetch(url, requestOptions);

    if (!response.ok) {
      const errorData = await response.json().catch(() => ({}));
      throw new ApiError(
        errorData.message || `HTTP ${response.status}: ${response.statusText}`,
        response.status,
        errorData
      );
    }

    return await response.json();
  } catch (error) {
    if (error instanceof ApiError) {
      throw error;
    }

    // Network or parsing errors
    throw new ApiError(
      error instanceof Error ? error.message : "Network request failed",
      500,
      error
    );
  }
}

/**
 * API Service
 *
 * Centralized service for making API requests with consistent error handling,
 * caching strategies, and type safety.
 */
export const apiService = {
  /**
   * GET request
   * @param endpoint - API endpoint
   * @param config - Optional request configuration
   */
  get: <T>(endpoint: string, config?: Omit<RequestConfig, "method" | "body">) =>
    request<T>(endpoint, { ...config, method: "GET" }),

  /**
   * POST request
   * @param endpoint - API endpoint
   * @param body - Request body
   * @param config - Optional request configuration
   */
  post: <T>(
    endpoint: string,
    body?: unknown,
    config?: Omit<RequestConfig, "method" | "body">
  ) => request<T>(endpoint, { ...config, method: "POST", body }),

  /**
   * PUT request
   * @param endpoint - API endpoint
   * @param body - Request body
   * @param config - Optional request configuration
   */
  put: <T>(
    endpoint: string,
    body?: unknown,
    config?: Omit<RequestConfig, "method" | "body">
  ) => request<T>(endpoint, { ...config, method: "PUT", body }),

  /**
   * PATCH request
   * @param endpoint - API endpoint
   * @param body - Request body
   * @param config - Optional request configuration
   */
  patch: <T>(
    endpoint: string,
    body?: unknown,
    config?: Omit<RequestConfig, "method" | "body">
  ) => request<T>(endpoint, { ...config, method: "PATCH", body }),

  /**
   * DELETE request
   * @param endpoint - API endpoint
   * @param config - Optional request configuration
   */
  delete: <T>(
    endpoint: string,
    config?: Omit<RequestConfig, "method" | "body">
  ) => request<T>(endpoint, { ...config, method: "DELETE" }),
};

/**
 * Get the full URL for a storage asset
 * @param path - Relative path to the asset
 * @returns Full URL to the asset
 */
export function getStorageUrl(path: string | null | undefined): string {
  if (!path) {
    return "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='400' height='400'%3E%3Crect fill='%23f3f4f6' width='400' height='400'/%3E%3C/svg%3E";
  }

  const normalizedPath = path.trim();

  if (
    normalizedPath.startsWith("http://") ||
    normalizedPath.startsWith("https://") ||
    normalizedPath.startsWith("data:")
  ) {
    return normalizedPath;
  }

  if (normalizedPath.startsWith("/images/")) {
    return normalizedPath;
  }

  if (normalizedPath.startsWith("images/")) {
    return `/${normalizedPath}`;
  }

  const baseUrl =
    process.env.NEXT_PUBLIC_API_BASE_URL?.replace("/api/v1", "") ||
    "http://localhost:8000";

  if (normalizedPath.startsWith("/storage/")) {
    return `${baseUrl}${normalizedPath}`;
  }

  if (normalizedPath.startsWith("storage/")) {
    return `${baseUrl}/${normalizedPath}`;
  }

  return `${baseUrl}/storage/${normalizedPath.replace(/^\/+/, "")}`;
}
