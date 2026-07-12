/**
 * Performance Monitor Component
 *
 * Development-only component that displays real-time performance metrics.
 * Shows Core Web Vitals and provides insights for optimization.
 *
 * Only renders in development mode to avoid production overhead.
 *
 * @module components/PerformanceMonitor
 */

"use client";

import { useEffect, useState } from "react";
import { onCLS, onFCP, onLCP, onTTFB, onINP, type Metric } from "web-vitals";

interface MetricData {
  name: string;
  value: number;
  rating: string;
  unit: string;
}

/**
 * Performance Monitor
 *
 * Displays Core Web Vitals in a floating panel (development only).
 * Helps developers identify and fix performance issues.
 */
export function PerformanceMonitor() {
  const [metrics, setMetrics] = useState<MetricData[]>([]);
  const [isVisible, setIsVisible] = useState(
    process.env.NODE_ENV === "development"
  );

  useEffect(() => {
    // Only show in development
    if (process.env.NODE_ENV !== "development") return;

    const handleMetric = (metric: Metric) => {
      setMetrics((prev) => {
        const existing = prev.findIndex((m) => m.name === metric.name);
        const newMetric: MetricData = {
          name: metric.name,
          value: Math.round(metric.value),
          rating: metric.rating,
          unit: metric.name === "CLS" ? "" : "ms",
        };

        if (existing >= 0) {
          const updated = [...prev];
          updated[existing] = newMetric;
          return updated;
        }
        return [...prev, newMetric];
      });
    };

    onCLS(handleMetric);
    onFCP(handleMetric);
    onLCP(handleMetric);
    onTTFB(handleMetric);
    onINP(handleMetric);
  }, []);

  if (process.env.NODE_ENV !== "development" || !isVisible) {
    return null;
  }

  const getRatingColor = (rating: string) => {
    switch (rating) {
      case "good":
        return "text-green-600 bg-green-50";
      case "needs-improvement":
        return "text-yellow-600 bg-yellow-50";
      case "poor":
        return "text-red-600 bg-red-50";
      default:
        return "text-gray-600 bg-gray-50";
    }
  };

  return (
    <div className="fixed bottom-4 right-4 z-50 bg-white rounded-lg shadow-2xl border-2 border-gray-200 p-4 max-w-sm">
      <div className="flex items-center justify-between mb-3">
        <h3 className="font-bold text-sm">⚡ Indicateurs de performance</h3>
        <button
          onClick={() => setIsVisible(false)}
          className="text-gray-400 hover:text-gray-600"
          aria-label="Fermer le panneau de performance"
        >
          ✕
        </button>
      </div>

      <div className="space-y-2">
        {metrics.length === 0 ? (
          <p className="text-sm text-gray-500">Chargement des métriques...</p>
        ) : (
          metrics.map((metric) => (
            <div
              key={metric.name}
              className={`flex items-center justify-between p-2 rounded ${getRatingColor(
                metric.rating
              )}`}
            >
              <span className="font-medium text-xs">{metric.name}</span>
              <span className="text-xs font-mono">
                {metric.value}
                {metric.unit}
              </span>
            </div>
          ))
        )}
      </div>

      <div className="mt-3 pt-3 border-t border-gray-200">
        <p className="text-xs text-gray-500">
          🟢 Bon | 🟡 À améliorer | 🔴 Faible
        </p>
      </div>
    </div>
  );
}
