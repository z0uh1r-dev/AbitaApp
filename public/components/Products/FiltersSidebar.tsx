/**
 * Filters Sidebar Component
 *
 * Server component that displays category filters for products page.
 * Uses Link prefetching for better navigation performance.
 *
 * @module components/Products/FiltersSidebar
 */

import Link from "next/link";
import { getCategories } from "@/src/api/categories/categories";
import { safeApiCall } from "@/lib/api-error-handler";
import { ROUTES } from "@/utils";

interface FiltersSidebarProps {
  activeDirectory: string | undefined;
}

export default async function FiltersSidebar({
  activeDirectory,
}: FiltersSidebarProps) {
  const response = await safeApiCall(() => getCategories());
  const categories = response?.data?.data || [];

  const isActive = (slug: string | undefined): boolean => {
    if ((!activeDirectory || activeDirectory === "") && !slug) {
      return true;
    }
    return activeDirectory === slug;
  };

  return (
    <aside className="lg:w-64 flex-shrink-0">
      <div className="bg-white p-6 sticky top-24 border-2 border-gray-200 rounded-3xl">
        <div className="flex items-center gap-2 mb-6">
          <svg
            className="h-5 w-5 text-primary"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            aria-hidden="true"
          >
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth="2"
              d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"
            />
          </svg>
          <h3 className="text-xl font-semibold">Filtres</h3>
        </div>

        <div className="mb-6">
          <h4 className="mb-3 text-sm text-gray-600 font-medium">Catégorie</h4>
          <div className="space-y-2">
            <Link
              href={ROUTES.PRODUCTS}
              prefetch={true}
              className={`block w-full text-left px-3 py-2 rounded-xl transition-colors hover:bg-gray-50 ${
                isActive("") ? "bg-primary text-white hover:text-black" : ""
              }`}
            >
              Tous les Produits
            </Link>
            {categories.map((c) => (
              <Link
                key={c.id}
                href={`${ROUTES.PRODUCTS}?category=${c.slug}`}
                prefetch={true}
                className={`block w-full text-left px-3 py-2 rounded-xl transition-colors hover:bg-gray-50 ${
                  isActive(c.slug)
                    ? "bg-primary text-white hover:text-black"
                    : ""
                }`}
              >
                {c.name}
              </Link>
            ))}
          </div>
        </div>
      </div>
    </aside>
  );
}
