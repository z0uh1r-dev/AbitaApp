/**
 * API Error Handler Utility
 * Provides consistent error handling and user-friendly messages for API calls
 */

export class ApiError extends Error {
  constructor(
    message: string,
    public statusCode?: number,
    public originalError?: unknown
  ) {
    super(message);
    this.name = "ApiError";
  }
}

interface ApiErrorResponse {
  message: string;
  statusCode: number;
  error?: unknown;
}

/**
 * Handle API errors and return a user-friendly error response
 */
export function handleApiError(error: unknown): ApiErrorResponse {
  if (error instanceof ApiError) {
    return {
      message: error.message,
      statusCode: error.statusCode || 500,
      error: error.originalError,
    };
  }

  if (error instanceof Error) {
    return {
      message: error.message || "An unexpected error occurred",
      statusCode: 500,
      error,
    };
  }

  return {
    message: "An unexpected error occurred",
    statusCode: 500,
    error,
  };
}

/**
 * Wrapper for API calls with automatic error handling
 */
export async function withErrorHandling<T>(
  apiCall: () => Promise<T>,
  fallbackMessage = "Failed to fetch data"
): Promise<T> {
  try {
    return await apiCall();
  } catch (error) {
    const apiError = handleApiError(error);
    console.error(`API Error: ${apiError.message}`, apiError.error);
    throw new ApiError(fallbackMessage, apiError.statusCode, apiError.error);
  }
}

/**
 * Safe API call that returns null on error instead of throwing
 */
export async function safeApiCall<T>(
  apiCall: () => Promise<T>,
  logError = true
): Promise<T | null> {
  try {
    return await apiCall();
  } catch (error) {
    if (logError) {
      const apiError = handleApiError(error);
      console.error(`API Error: ${apiError.message}`, apiError.error);
    }
    return null;
  }
}
