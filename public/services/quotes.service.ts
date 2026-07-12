/**
 * Quotes Service
 *
 * Handles quote submission and management.
 * Provides API integration for the quote request form.
 *
 * @module services/quotes.service
 */

import { apiService } from "./api.service";
import type { Quote } from "@/types/api";

function normalizeQuoteEndpoint(rawEndpoint: string | undefined): string {
  const fallback = "/quotes";

  if (!rawEndpoint) {
    return fallback;
  }

  const trimmed = rawEndpoint.trim();
  if (!trimmed) {
    return fallback;
  }

  if (/^https?:\/\//i.test(trimmed)) {
    return trimmed;
  }

  const withoutLeadingSlash = trimmed.replace(/^\/+/, "");
  const withoutApiPrefix = withoutLeadingSlash.replace(/^api\/v1\/?/, "");

  if (!withoutApiPrefix) {
    return fallback;
  }

  return `/${withoutApiPrefix}`;
}

const QUOTE_SUBMIT_ENDPOINT = normalizeQuoteEndpoint(
  process.env.NEXT_PUBLIC_GET_QUOTE_API_ENDPOINT
);

interface QuoteApiRequestBody extends QuoteSubmission {
  companyName?: string;
  contactName?: string;
  description?: string;
}

/**
 * Quote submission data structure
 */
export interface QuoteSubmission {
  name: string;
  email: string;
  phone: string;
  company?: string;
  message: string;
}

/**
 * Quote API response structure
 */
interface QuoteApiResponse {
  data: Quote;
  message: string;
}

/**
 * Quotes Service
 *
 * Handles quote requests and submissions.
 * No caching for mutations - always fresh data.
 */
export const quotesService = {
  /**
   * Submit a new quote request
   *
   * Sends a quote request to the backend API.
   * No caching is applied to ensure data consistency.
   *
   * @param data - Quote submission data
   * @returns Promise resolving to created quote
   * @throws {ApiError} When submission fails
   */
  async submit(data: QuoteSubmission): Promise<Quote> {
    const requestBody: QuoteApiRequestBody = {
      ...data,
      companyName: data.company,
      contactName: data.name,
      description: data.message,
    };

    if (/^https?:\/\//i.test(QUOTE_SUBMIT_ENDPOINT)) {
      const response = await fetch(QUOTE_SUBMIT_ENDPOINT, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(requestBody),
        cache: "no-store",
      });

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(
          errorData.message ||
            `Quote request failed with status ${response.status}`
        );
      }

      const json = (await response.json()) as QuoteApiResponse;
      return json.data;
    }

    const response = await apiService.post<QuoteApiResponse>(
      QUOTE_SUBMIT_ENDPOINT,
      requestBody,
      {
        cache: "no-store", // Never cache POST requests
      }
    );
    return response.data;
  },

  /**
   * Validate quote data before submission
   *
   * @param data - Quote submission data
   * @returns Validation result with errors if any
   */
  validate(data: Partial<QuoteSubmission>): {
    isValid: boolean;
    errors: Partial<Record<keyof QuoteSubmission, string>>;
  } {
    const errors: Partial<Record<keyof QuoteSubmission, string>> = {};

    if (!data.name || data.name.trim().length < 2) {
      errors.name = "Name must be at least 2 characters";
    }

    if (!data.email || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(data.email)) {
      errors.email = "Valid email is required";
    }

    if (!data.phone || !/^\+?[\d\s-()]+$/.test(data.phone)) {
      errors.phone = "Valid phone number is required";
    }

    if (!data.message || data.message.trim().length < 10) {
      errors.message = "Message must be at least 10 characters";
    }

    return {
      isValid: Object.keys(errors).length === 0,
      errors,
    };
  },
};
