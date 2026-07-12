import Link from "next/link";

export default function Breadcrumb() {
  return (
    <div className="bg-gray-50 py-4 border-b-2 border-gray-200">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <Link
          href="/products"
          className="flex items-center gap-2 text-gray-600 hover:text-primary transition-colors"
        >
          <svg
            className="h-4 w-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              strokeLinecap="round"
              strokeLinejoin="round"
              strokeWidth="2"
              d="M15 19l-7-7 7-7"
            />
          </svg>
          Retour aux Produits
        </Link>
      </div>
    </div>
  );
}
