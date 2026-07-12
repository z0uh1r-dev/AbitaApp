/**
 * Testing Utilities
 *
 * Helper functions and utilities for testing React components.
 * Provides custom render methods with providers and common test utilities.
 *
 * @module __tests__/test-utils
 */

import { ReactElement } from "react";
import { render, RenderOptions } from "@testing-library/react";
import { QueryClient, QueryClientProvider } from "@tanstack/react-query";

/**
 * Create a test QueryClient with disabled retries and logging
 */
export function createTestQueryClient() {
  return new QueryClient({
    defaultOptions: {
      queries: {
        retry: false,
        gcTime: 0,
        staleTime: 0,
      },
      mutations: {
        retry: false,
      },
    },
  });
}

/**
 * Custom render function with React Query provider
 *
 * @param ui - React element to render
 * @param options - Render options
 * @returns Render result with utilities
 *
 * @example
 * ```tsx
 * const { getByText } = renderWithProviders(<MyComponent />);
 * expect(getByText('Hello')).toBeInTheDocument();
 * ```
 */
export function renderWithProviders(
  ui: ReactElement,
  options?: Omit<RenderOptions, "wrapper">
) {
  const queryClient = createTestQueryClient();

  function Wrapper({ children }: { children: React.ReactNode }) {
    return (
      <QueryClientProvider client={queryClient}>{children}</QueryClientProvider>
    );
  }

  return {
    ...render(ui, { wrapper: Wrapper, ...options }),
    queryClient,
  };
}

/**
 * Mock fetch response helper
 *
 * @param data - Response data
 * @param status - HTTP status code
 * @returns Mocked fetch response
 */
export function createMockResponse<T>(data: T, status = 200) {
  return {
    ok: status >= 200 && status < 300,
    status,
    json: async () => data,
    headers: new Headers(),
  } as Response;
}

/**
 * Wait for loading to complete
 * Helper for testing async components
 */
export async function waitForLoadingToFinish() {
  return new Promise((resolve) => setTimeout(resolve, 0));
}

// Re-export everything from React Testing Library
export * from "@testing-library/react";
export { default as userEvent } from "@testing-library/user-event";
