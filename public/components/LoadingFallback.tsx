/**
 * Loading Fallback Component
 * Displays a loading state with spinner animation
 */
export default function LoadingFallback() {
  return (
    <div className="min-h-screen flex items-center justify-center bg-gray-50">
      <div className="text-center">
        <div className="inline-block animate-spin rounded-full h-12 w-12 border-b-2 border-primary"></div>
        <p className="mt-4 text-gray-600">Chargement...</p>
      </div>
    </div>
  );
}

/**
 * Skeleton Loader for Product Cards
 */
export function ProductCardSkeleton() {
  return (
    <div className="bg-white border-2 border-gray-200 rounded-3xl overflow-hidden animate-pulse">
      <div className="aspect-square bg-gray-200"></div>
      <div className="p-6 space-y-3">
        <div className="h-4 bg-gray-200 rounded w-3/4"></div>
        <div className="h-4 bg-gray-200 rounded w-1/2"></div>
      </div>
    </div>
  );
}

/**
 * Skeleton Loader for Category Cards
 */
export function CategoryCardSkeleton() {
  return (
    <div className="bg-white border-2 border-gray-200 rounded-3xl overflow-hidden animate-pulse">
      <div className="aspect-[4/3] bg-gray-200"></div>
      <div className="p-6 space-y-3">
        <div className="h-4 bg-gray-200 rounded w-2/3"></div>
        <div className="h-3 bg-gray-200 rounded w-full"></div>
      </div>
    </div>
  );
}
