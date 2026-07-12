/**
 * Quotes Feature - Custom Hooks
 *
 * React Query hooks for quote submission with optimistic updates.
 *
 * @module features/quotes/hooks
 */

"use client";

import { useMutation } from "@tanstack/react-query";
import { quotesService, type QuoteSubmission } from "@/services";

/**
 * Hook to submit a quote request
 *
 * Provides mutation state management for quote submissions
 * including loading, error, and success states.
 *
 * @example
 * ```tsx
 * function QuoteForm() {
 *   const { mutate, isPending, isError, isSuccess } = useSubmitQuote();
 *
 *   const handleSubmit = (data: QuoteSubmission) => {
 *     mutate(data, {
 *       onSuccess: () => {
 *         toast.success("Quote submitted successfully!");
 *       },
 *       onError: (error) => {
 *         toast.error("Failed to submit quote");
 *       },
 *     });
 *   };
 *
 *   return <form onSubmit={handleSubmit}>...</form>;
 * }
 * ```
 */
export function useSubmitQuote() {
  return useMutation({
    mutationFn: (data: QuoteSubmission) => quotesService.submit(data),
    retry: 1, // Retry once on failure
  });
}

/**
 * Hook for client-side quote validation
 *
 * @example
 * ```tsx
 * function QuoteForm() {
 *   const [formData, setFormData] = useState<Partial<QuoteSubmission>>({});
 *
 *   const validation = useQuoteValidation(formData);
 *
 *   return (
 *     <form>
 *       <input
 *         name="email"
 *         onChange={(e) => setFormData({ ...formData, email: e.target.value })}
 *       />
 *       {validation.errors.email && <span>{validation.errors.email}</span>}
 *     </form>
 *   );
 * }
 * ```
 */
export function useQuoteValidation(data: Partial<QuoteSubmission>) {
  return quotesService.validate(data);
}
