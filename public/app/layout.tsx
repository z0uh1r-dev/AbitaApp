import type { Metadata } from "next";
import { Inter } from "next/font/google";
import dynamic from "next/dynamic";
import "./globals.css";
import Header from "@/components/header";
import { ErrorBoundary } from "@/components/ErrorBoundary";
import { WebVitalsReporter } from "@/components/WebVitalsReporter";
import { PerformanceMonitor } from "@/components/PerformanceMonitor";

// Dynamic import Footer with loading fallback
const Footer = dynamic(() => import("@/components/footer"), {
  loading: () => <div className="h-20 bg-gray-100" />,
});

const InterFont = Inter({
  variable: "--font-inter",
  subsets: ["latin"],
  display: "swap", // Optimize font loading
  preload: true,
});

export const metadata: Metadata = {
  title: "Abita - Cadeaux d'Entreprise & Fournitures de Bureau",
  description:
    "Produits de bureau et d'entreprise personnalisés pour votre activité",
};

export default function RootLayout({
  children,
}: Readonly<{
  children: React.ReactNode;
}>) {
  return (
    <html lang="fr">
      <body className={`${InterFont.variable}`}>
        <WebVitalsReporter />
        <PerformanceMonitor />
        <ErrorBoundary>
          <Header />
          {children}
          <Footer />
        </ErrorBoundary>
      </body>
    </html>
  );
}
