/**
 * Components Barrel Export
 *
 * Central export file for all feature-specific components.
 * Organized by feature domain for better code organization.
 *
 * @module components
 */

// Layout Components
export { default as Header } from "./header";
export { default as Footer } from "./footer";

// Error Handling
export { ErrorBoundary } from "./ErrorBoundary";

// Loading States
export {
  default as LoadingFallback,
  ProductCardSkeleton,
  CategoryCardSkeleton,
} from "./LoadingFallback";

// Performance Monitoring
export { WebVitalsReporter } from "./WebVitalsReporter";
export { PerformanceMonitor } from "./PerformanceMonitor";

// Home Page Components
export { default as HomeHero } from "./Home/Hero";
export { default as HomeWhatWeDo } from "./Home/WhatWeDo";
export { default as HomeOurServices } from "./Home/OurServices";
export { default as HomeProductCategories } from "./Home/ProductCategories";
export { default as HomeInteriorDesign } from "./Home/InteriorDesign";
export { default as HomeProcess } from "./Home/Process";
export { default as HomeWhyUs } from "./Home/WhyUs";
export { default as HomePartners } from "./Home/Partners";
export { default as HomeFinalCta } from "./Home/FinalCta";

// Products Page Components
export { default as ProductsPageHeader } from "./Products/PageHeader";
export { default as ProductsFiltersSidebar } from "./Products/FiltersSidebar";
export { default as ProductsGrid } from "./Products/ProductsGrid";

// Product Detail Page Components
export { default as ProductBreadcrumb } from "./Product/Breadcrumb";
export { default as ProductInfo } from "./Product/ProductInfo";
export { default as ProductImageGallery } from "./Product/ImageGallery";
export { default as ProductCustomizedOptions } from "./Product/CustomizedOptions";
export { default as ProductRelatedProducts } from "./Product/RelatedProducts";

// Interior Design Page Components
export { default as InteriorDesignHero } from "./InteriorDesign/Hero";
export { default as InteriorDesignOurServices } from "./InteriorDesign/OurServices";
export { default as InteriorDesignShowcase } from "./InteriorDesign/Showcase";
export { default as InteriorDesignTimeline } from "./InteriorDesign/Timeline";
export { default as InteriorDesignCta } from "./InteriorDesign/CtaSection";

// Contact Page Components
export { default as ContactHero } from "./Contact/Hero";
export { default as ContactInformationsAndForm } from "./Contact/InformationsAndForm";
export { default as ContactLocation } from "./Contact/Location";

// Get Quote Page Components
export { default as GetQuoteHeader } from "./GetQuote/Header";
export { default as GetQuoteSidebar } from "./GetQuote/Sidebar";
export { default as GetQuoteForm } from "./GetQuote/QuoteForm";
