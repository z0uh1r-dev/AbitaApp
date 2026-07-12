/**
 * Component Props Types
 *
 * Centralized type definitions for all component props.
 * Ensures type safety and consistency across the application.
 *
 * @module types/components
 */

import { ReactNode } from "react";
import {
  Category,
  Product,
  ProductImage,
  ProductSpecification,
  ProductCustomization,
} from "./api";

/**
 * Layout component props
 */
export interface LayoutProps {
  children: ReactNode;
}

/**
 * Category card component props
 */
export interface CategoryCardProps {
  id: string | number;
  slug: string;
  imageUrl: string | null;
  name: string;
  description: string | null;
}

/**
 * Product card component props
 */
export interface ProductCardProps {
  id: string | number;
  slug: string;
  imageUrl: string;
  name: string;
  description: string;
}

/**
 * Image gallery component props
 */
export interface ImageGalleryProps {
  mainImageUrl: string;
  gallery: ProductImage[] | null;
}

/**
 * Product info component props
 */
export interface ProductInfoProps {
  name: string;
  category: string;
  description: string;
  specifications: ProductSpecification[] | null;
  customized: ProductCustomization[] | null;
}

/**
 * Related products component props
 */
export interface RelatedProductsProps {
  products: Product[] | null;
}

/**
 * Filters sidebar component props
 */
export interface FiltersSidebarProps {
  activeDirectory: string | undefined;
  categories?: Category[];
}

/**
 * Products grid component props
 */
export interface ProductsGridProps {
  products: Product[] | null;
}

export interface SectionHeaderProps {
  title: string;
  description: string;
}

export interface ErrorBoundaryProps {
  children: ReactNode;
  fallback?: ReactNode;
}
