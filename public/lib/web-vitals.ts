/**
 * Web Vitals Monitoring
 *
 * Tracks Core Web Vitals metrics for performance monitoring.
 * Reports metrics to analytics or console for debugging.
 *
 * Metrics tracked:
 * - FCP (First Contentful Paint): Time to first content render
 * - LCP (Largest Contentful Paint): Time to largest content render
 * - CLS (Cumulative Layout Shift): Visual stability metric
 * - FID (First Input Delay): Time to first interaction
 * - TTFB (Time to First Byte): Server response time
 * - INP (Interaction to Next Paint): Responsiveness metric
 *
 * @module lib/web-vitals
 */

import type { Metric } from "web-vitals";

/**
 * Report web vitals to analytics service
 * Replace with your analytics provider (Google Analytics, Vercel Analytics, etc.)
 */
function sendToAnalytics(metric: Metric): void {
  // Log to console in development
  if (process.env.NODE_ENV === "development") {
    console.log(`[Web Vitals] ${metric.name}:`, {
      value: metric.value,
      rating: metric.rating,
      delta: metric.delta,
      navigationType: metric.navigationType,
    });
  }

  // Send to analytics service
  // Example with Google Analytics:
  // window.gtag?.('event', metric.name, {
  //   value: Math.round(metric.value),
  //   metric_id: metric.id,
  //   metric_value: metric.value,
  //   metric_delta: metric.delta,
  //   metric_rating: metric.rating,
  // });

  // Example with Vercel Analytics:
  // window.va?.track(metric.name, {
  //   value: metric.value,
  //   rating: metric.rating,
  // });
}

/**
 * Initialize Web Vitals reporting
 * Call this in the root layout or app component
 */
export function reportWebVitals(metric: Metric): void {
  sendToAnalytics(metric);
}

/**
 * Performance thresholds for each metric (in milliseconds)
 * Based on Google's Core Web Vitals standards
 */
export const PERFORMANCE_THRESHOLDS = {
  FCP: {
    good: 1800,
    needsImprovement: 3000,
  },
  LCP: {
    good: 2500,
    needsImprovement: 4000,
  },
  FID: {
    good: 100,
    needsImprovement: 300,
  },
  CLS: {
    good: 0.1,
    needsImprovement: 0.25,
  },
  TTFB: {
    good: 800,
    needsImprovement: 1800,
  },
  INP: {
    good: 200,
    needsImprovement: 500,
  },
} as const;

/**
 * Get performance rating based on metric value
 */
export function getPerformanceRating(
  metricName: keyof typeof PERFORMANCE_THRESHOLDS,
  value: number
): "good" | "needs-improvement" | "poor" {
  const threshold = PERFORMANCE_THRESHOLDS[metricName];

  if (value <= threshold.good) return "good";
  if (value <= threshold.needsImprovement) return "needs-improvement";
  return "poor";
}
