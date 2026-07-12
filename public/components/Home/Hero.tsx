/**
 * Hero Component
 *
 * Landing page hero section with call-to-action buttons
 * and image gallery. Optimized with Next.js Image.
 *
 * @module components/Home/Hero
 */

import Link from "next/link";
import Image from "next/image";
import { ROUTES } from "@/utils";

export default function Hero() {
  return (
    <section className="relative bg-white overflow-hidden">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
          <div>
            <h1 className="text-5xl md:text-6xl lg:text-7xl font-bold mb-6 text-gray-900">
              Donnez du relief à votre image de marque
            </h1>
            <p className="text-xl md:text-2xl text-gray-600 mb-10">
              Des produits personnalisés pensés pour les entreprises et les
              événements professionnels
            </p>
            <div className="flex flex-col sm:flex-row gap-4">
              <Link
                href={ROUTES.GET_QUOTE}
                className="bg-primary text-white text-lg px-8 py-4 rounded-xl hover:bg-primary/90 transition-colors inline-flex items-center justify-center"
              >
                Obtenir un devis
                <svg
                  className="ml-2 h-5 w-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  aria-hidden="true"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M9 5l7 7-7 7"
                  />
                </svg>
              </Link>
              <Link
                href={ROUTES.PRODUCTS}
                className="border-2 border-gray-900 text-gray-900 text-lg px-8 py-4 rounded-xl hover:bg-gray-50 transition-colors inline-flex items-center justify-center"
              >
                Voir les produits
              </Link>
            </div>
          </div>

          <div className="hidden lg:grid grid-cols-2 gap-4">
            <div className="aspect-square rounded-3xl overflow-hidden bg-gradient-to-br from-primary/5 to-primary/10 relative">
              <Image
                src="https://images.unsplash.com/photo-1590424963894-50c6b52dd2e8?w=400"
                alt="Espace de travail"
                fill
                sizes="(max-width: 1024px) 0vw, 25vw"
                className="object-cover hover:scale-105 transition-transform duration-500"
                priority
              />
            </div>
            <div className="aspect-square rounded-3xl overflow-hidden bg-gradient-to-br from-secondary/10 to-secondary/20 mt-8 relative">
              <Image
                src="https://images.unsplash.com/photo-1551651639-927b595f815c?w=400"
                alt="Entreprise"
                fill
                sizes="(max-width: 1024px) 0vw, 25vw"
                className="object-cover hover:scale-105 transition-transform duration-500"
                loading="lazy"
              />
            </div>
            <div className="aspect-square rounded-3xl overflow-hidden bg-gradient-to-br from-secondary/10 to-secondary/20 -mt-8 relative">
              <Image
                src="https://images.unsplash.com/photo-1672434054682-70381f05c406?w=400"
                alt="Univers d'entreprise"
                fill
                sizes="(max-width: 1024px) 0vw, 25vw"
                className="object-cover hover:scale-105 transition-transform duration-500"
                loading="lazy"
              />
            </div>
            <div className="aspect-square rounded-3xl overflow-hidden bg-gradient-to-br from-primary/5 to-primary/10 relative">
              <Image
                src="https://images.unsplash.com/photo-1695395894170-ff75a98f176c?w=400"
                alt="Bureau"
                fill
                sizes="(max-width: 1024px) 0vw, 25vw"
                className="object-cover hover:scale-105 transition-transform duration-500"
                loading="lazy"
              />
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
