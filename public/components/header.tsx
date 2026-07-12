"use client";

/**
 * Header Component
 *
 * Main navigation header with prefetch links for better performance.
 * Sticky positioning with responsive design and a working mobile menu.
 *
 * @module components/header
 */

import { useState } from "react";
import Link from "next/link";
import { usePathname } from "next/navigation";
import { ROUTES } from "@/utils";

const NAV_LINKS = [
  { href: ROUTES.HOME, label: "Accueil" },
  { href: ROUTES.PRODUCTS, label: "Produits" },
  { href: ROUTES.INTERIOR_DESIGN, label: "Design d'Intérieur" },
  { href: ROUTES.CONTACT, label: "Contactez-nous" },
];

export default function Header() {
  const [isMenuOpen, setIsMenuOpen] = useState(false);
  const pathname = usePathname();

  const isActive = (href: string) =>
    href === ROUTES.HOME ? pathname === href : pathname.startsWith(href);

  return (
    <header className="sticky top-0 z-50 w-full bg-white border-b-2 border-gray-200">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex h-20 items-center justify-between">
          <Link
            href={ROUTES.HOME}
            prefetch={true}
            className="flex items-center hover:opacity-80 transition-opacity"
            onClick={() => setIsMenuOpen(false)}
          >
            <div className="text-2xl font-bold text-primary">ABITA</div>
          </Link>

          <nav className="hidden md:flex items-center gap-8">
            {NAV_LINKS.map((link) => (
              <Link
                key={link.href}
                href={link.href}
                prefetch={true}
                className={`transition-colors hover:text-primary ${
                  isActive(link.href)
                    ? "text-primary font-medium"
                    : "text-gray-600"
                }`}
              >
                {link.label}
              </Link>
            ))}
            <Link
              href={ROUTES.GET_QUOTE}
              prefetch={true}
              className="ml-4 bg-primary text-white px-6 py-2.5 rounded-xl hover:bg-primary/90 transition-colors"
            >
              Obtenir un devis
            </Link>
          </nav>

          <button
            type="button"
            className="md:hidden p-2"
            aria-label={isMenuOpen ? "Fermer le menu" : "Ouvrir le menu"}
            aria-expanded={isMenuOpen}
            aria-controls="mobile-menu"
            onClick={() => setIsMenuOpen((open) => !open)}
          >
            {isMenuOpen ? (
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
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            ) : (
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
            )}
          </button>
        </div>

        {isMenuOpen && (
          <div
            id="mobile-menu"
            className="md:hidden pb-6 pt-2 border-t-2 border-gray-200"
          >
            <nav className="flex flex-col gap-4">
              {NAV_LINKS.map((link) => (
                <Link
                  key={link.href}
                  href={link.href}
                  prefetch={true}
                  className={`text-left py-2 px-2 rounded-xl ${
                    isActive(link.href)
                      ? "text-primary bg-primary/5"
                      : "text-gray-600 hover:text-primary hover:bg-primary/5"
                  }`}
                  onClick={() => setIsMenuOpen(false)}
                >
                  {link.label}
                </Link>
              ))}
              <Link
                href={ROUTES.GET_QUOTE}
                prefetch={true}
                className="w-full mt-2 bg-primary text-white px-6 py-3 rounded-xl hover:bg-primary/90 transition-colors text-center"
                onClick={() => setIsMenuOpen(false)}
              >
                Obtenir un devis
              </Link>
            </nav>
          </div>
        )}
      </div>
    </header>
  );
}
