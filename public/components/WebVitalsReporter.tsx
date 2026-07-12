/**
 * Web Vitals Reporter Component
 *
 * Client component that initializes web vitals monitoring.
 * Must be rendered once in the app, typically in the root layout.
 *
 * @module components/WebVitalsReporter
 */

"use client";

import { useEffect } from "react";
import { onCLS, onFCP, onLCP, onTTFB, onINP } from "web-vitals";
import { reportWebVitals } from "@/lib/web-vitals";

/**
 * Web Vitals Reporter
 *
 * Initializes performance monitoring for Core Web Vitals.
 * Automatically reports metrics to analytics or console.
 */
export function WebVitalsReporter() {
  useEffect(() => {
    // Report all Core Web Vitals
    onCLS(reportWebVitals);
    onFCP(reportWebVitals);
    onLCP(reportWebVitals);
    onTTFB(reportWebVitals);
    onINP(reportWebVitals);
  }, []);

  return null;
}
