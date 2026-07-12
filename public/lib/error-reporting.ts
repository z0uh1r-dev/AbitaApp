/**
 * Client Error Reporting Utility
 *
 * Centralized reporting for browser/runtime errors.
 * Integrates with Sentry if present on `window.Sentry`.
 *
 * @module lib/error-reporting
 */

interface ErrorReportingContext {
  componentStack?: string;
  [key: string]: unknown;
}

interface ClientErrorPayload {
  message: string;
  stack?: string;
  source?: string;
  componentStack?: string;
  url?: string;
  userAgent?: string;
  timestamp: string;
  extra: Record<string, unknown>;
}

type SentryLike = {
  captureException: (
    error: unknown,
    context?: { extra?: Record<string, unknown> }
  ) => void;
};

function isClientErrorReportingEnabled(): boolean {
  return process.env.NEXT_PUBLIC_ENABLE_CLIENT_ERROR_REPORTING !== "false";
}

function getSentryClient(): SentryLike | null {
  const maybeWindow = globalThis as typeof globalThis & {
    Sentry?: SentryLike;
  };

  return maybeWindow.Sentry ?? null;
}

function createPayload(
  error: Error,
  context: ErrorReportingContext
): ClientErrorPayload {
  const source =
    typeof context.source === "string" ? context.source : "unknown";
  const componentStack =
    typeof context.componentStack === "string"
      ? context.componentStack
      : undefined;

  const extra = Object.fromEntries(
    Object.entries(context).filter(
      ([key]) => key !== "source" && key !== "componentStack"
    )
  );

  return {
    message: error.message,
    stack: error.stack,
    source,
    componentStack,
    url: typeof window !== "undefined" ? window.location.href : undefined,
    userAgent:
      typeof navigator !== "undefined" ? navigator.userAgent : undefined,
    timestamp: new Date().toISOString(),
    extra,
  };
}

function sendToInternalEndpoint(payload: ClientErrorPayload): void {
  if (typeof window === "undefined") {
    return;
  }

  const body = JSON.stringify(payload);
  const endpoint = "/api/client-errors";

  if (typeof navigator !== "undefined" && navigator.sendBeacon) {
    const blob = new Blob([body], { type: "application/json" });
    navigator.sendBeacon(endpoint, blob);
    return;
  }

  fetch(endpoint, {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body,
    keepalive: true,
  }).catch(() => undefined);
}

export function reportClientError(
  error: Error,
  context: ErrorReportingContext = {}
): void {
  if (!isClientErrorReportingEnabled()) {
    return;
  }

  const payload = createPayload(error, context);
  const sentry = getSentryClient();

  if (sentry) {
    sentry.captureException(error, {
      extra: {
        ...payload,
      },
    });
  }

  if (process.env.NODE_ENV === "production") {
    sendToInternalEndpoint(payload);
    return;
  }

  console.error("Client error captured:", {
    ...payload,
  });
}
