/**
 * Header Component
 *
 * Main navigation header with prefetch links for better performance.
 * Sticky positioning with responsive design.
 *
 * @module components/header
 */

import Link from "next/link";
import { ROUTES } from "@/utils";

export default function Header() {
  return (
    <header className="sticky top-0 z-50 w-full bg-white border-b-2 border-gray-200">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex h-20 items-center justify-between">
          <Link
            href={ROUTES.HOME}
            prefetch={true}
            className="flex items-center hover:opacity-80 transition-opacity"
          >
            <div className="text-2xl font-bold text-primary">ABITA</div>
          </Link>

          <nav className="hidden md:flex items-center gap-8">
            <Link
              href={ROUTES.HOME}
              prefetch={true}
              className="text-primary transition-colors hover:text-primary font-medium"
            >
              Accueil
            </Link>
            <Link
              href={ROUTES.PRODUCTS}
              prefetch={true}
              className="text-gray-600 transition-colors hover:text-primary"
            >
              Produits
            </Link>
            <Link
              href={ROUTES.INTERIOR_DESIGN}
              prefetch={true}
              className="text-gray-600 transition-colors hover:text-primary"
            >
              Design d&apos;Intérieur
            </Link>
            <Link
              href={ROUTES.CONTACT}
              prefetch={true}
              className="text-gray-600 transition-colors hover:text-primary"
            >
              Contactez-nous
            </Link>
            <Link
              href={ROUTES.GET_QUOTE}
              prefetch={true}
              className="ml-4 bg-primary text-white px-6 py-2.5 rounded-xl hover:bg-primary/90 transition-colors"
            >
              Obtenir un devis
            </Link>
          </nav>

          <button id="mobile-menu-button" className="md:hidden p-2">
            <svg
              className="h-6 w-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
          </button>
        </div>

        <div
          id="mobile-menu"
          className="hidden md:hidden pb-6 pt-2 border-t-2 border-gray-200"
        >
          <nav className="flex flex-col gap-4">
            <Link
              href={ROUTES.HOME}
              prefetch={true}
              className="text-left py-2 px-2 rounded-xl text-primary bg-primary/5"
            >
              Accueil
            </Link>
            <Link
              href={ROUTES.PRODUCTS}
              prefetch={true}
              className="text-left py-2 px-2 rounded-xl text-gray-600 hover:text-primary hover:bg-primary/5"
            >
              Produits
            </Link>
            <Link
              href={ROUTES.GET_QUOTE}
              prefetch={true}
              className="text-left py-2 px-2 rounded-xl text-gray-600 hover:text-primary hover:bg-primary/5"
            >
              Obtenir un devis
            </Link>
            <Link
              href="/get-quote"
              className="w-full mt-2 bg-primary text-white px-6 py-3 rounded-xl hover:bg-primary/90 transition-colors text-center"
            >
              Obtenir un devis
            </Link>
          </nav>
        </div>
      </div>
    </header>
  );
}
