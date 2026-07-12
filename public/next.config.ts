/**
 * Next.js Configuration
 *
 * Optimized for performance, security, and scalability.
 *
 * @module next.config
 */

import type { NextConfig } from "next";
import bundleAnalyzer from "@next/bundle-analyzer";

const backendApiUrl =
  process.env.NEXT_PUBLIC_API_BASE_URL || "http://localhost:8000/api/v1";
const backendOrigin = backendApiUrl.replace(/\/api\/v1\/?$/, "");
const backendUrl = (() => {
  try {
    return new URL(backendOrigin);
  } catch {
    return new URL("http://localhost:8000");
  }
})();

// Bundle analyzer for development
const withBundleAnalyzer = bundleAnalyzer({
  enabled: process.env.ANALYZE === "true",
});

const nextConfig: NextConfig = {
  output: "standalone",

  // Image optimization configuration
  images: {
    dangerouslyAllowLocalIP: process.env.NODE_ENV === "development",
    remotePatterns: [
      {
        protocol: backendUrl.protocol.replace(":", "") as "http" | "https",
        hostname: backendUrl.hostname,
        port: backendUrl.port || undefined,
        pathname: "/storage/**",
      },
      {
        protocol: "https",
        hostname: "images.unsplash.com",
        pathname: "/**",
      },
    ],
    formats: ["image/avif", "image/webp"], // Modern formats for smaller sizes
    deviceSizes: [640, 750, 828, 1080, 1200, 1920, 2048], // Responsive breakpoints
    imageSizes: [16, 32, 48, 64, 96, 128, 256, 384], // Icon/thumbnail sizes
    minimumCacheTTL: 60 * 60 * 24 * 30, // Cache images for 30 days
  },

  // Compiler optimizations
  compiler: {
    removeConsole: process.env.NODE_ENV === "production", // Remove console.logs in production
  },

  // Performance optimizations
  experimental: {
    optimizePackageImports: ["@tanstack/react-query"], // Optimize imports
  },

  // Headers for caching and security
  async headers() {
    return [
      {
        source: "/:path*",
        headers: [
          {
            key: "X-DNS-Prefetch-Control",
            value: "on",
          },
          {
            key: "X-Frame-Options",
            value: "SAMEORIGIN",
          },
          {
            key: "X-Content-Type-Options",
            value: "nosniff",
          },
          {
            key: "Referrer-Policy",
            value: "origin-when-cross-origin",
          },
        ],
      },
      {
        // Cache static assets aggressively
        source: "/images/:path*",
        headers: [
          {
            key: "Cache-Control",
            value: "public, max-age=31536000, immutable",
          },
        ],
      },
    ];
  },
};

export default withBundleAnalyzer(nextConfig);
