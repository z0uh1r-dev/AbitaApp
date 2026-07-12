/**
 * Products Page
 *
 * Server component that displays all products or filtered by category.
 * Uses ISR for performance optimization.
 *
 * @module app/products/page
 */

import FiltersSidebar from "@/components/Products/FiltersSidebar";
import PageHeader from "@/components/Products/PageHeader";
import ProductsGrid from "@/components/Products/ProductsGrid";
import {
  getProducts,
  getCategoriesCategorySlugProducts,
} from "@/src/api/products/products";
import { safeApiCall } from "@/lib/api-error-handler";
import { Product } from "@/types/api";

interface ProductsPageProps {
  searchParams: Promise<{ category?: string }>;
}

export default async function ProductsPage({
  searchParams,
}: ProductsPageProps) {
  const { category } = await searchParams;

  let products: Product[] | null = null;

  // Fetch products based on category filter
  if (category) {
    const response = await safeApiCall(() =>
      getCategoriesCategorySlugProducts(category)
    );
    products = (response?.data?.data as Product[]) || [];
  } else {
    const response = await safeApiCall(() => getProducts());
    products = (response?.data?.data as Product[]) || [];
  }

  return (
    <>
      <PageHeader />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="flex flex-col lg:flex-row gap-8">
          <FiltersSidebar activeDirectory={category} />
          <ProductsGrid products={products} />
        </div>
      </div>
    </>
  );
}
