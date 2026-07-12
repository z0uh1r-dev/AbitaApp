/**
 * Product Card Component
 *
 * Displays a product with image, title, and description.
 * Optimized with Next.js Image, prefetch links, and hover effects.
 *
 * @module UI/ProductCard
 */

import Link from "next/link";
import Image from "next/image";
import { getStorageUrl } from "@/services";
import { ROUTES } from "@/utils";

interface ProductCardProps {
  id: string | number;
  slug: string;
  imageUrl: string;
  name: string;
  description: string;
}

export default function ProductCard({
  id,
  slug,
  imageUrl,
  name,
  description,
}: ProductCardProps) {
  return (
    <div
      key={id}
      className="flex h-full flex-col bg-white overflow-hidden border-2 border-gray-200 rounded-3xl transition-all group hover:border-primary hover:-translate-y-1"
    >
      <Link
        href={ROUTES.PRODUCT_DETAIL(slug)}
        prefetch={true}
        className="block"
      >
        <div className="aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-50 relative">
          <Image
            src={getStorageUrl(imageUrl)}
            alt={name}
            fill
            sizes="(max-width: 768px) 100vw, (max-width: 1280px) 50vw, 33vw"
            className="object-cover transition-transform duration-300 group-hover:scale-105"
            priority={false}
            loading="lazy"
          />
        </div>
      </Link>

      <div className="flex flex-col flex-1 p-6">
        <Link
          href={ROUTES.PRODUCT_DETAIL(slug)}
          prefetch={true}
          className="block"
        >
          <div className="flex gap-2 mb-3 flex-wrap">
            <span className="bg-secondary text-white px-3 py-1 rounded-full text-sm font-medium">
              Haut de gamme
            </span>
            <span className="bg-primary text-white px-3 py-1 rounded-full text-sm font-medium">
              Meilleure vente
            </span>
          </div>

          <h3 className="text-xl font-semibold mb-2">{name}</h3>
          <p className="text-sm text-gray-600 mb-2">Coffrets Cadeaux</p>
          <p className="text-gray-600 mb-4 line-clamp-2">{description}</p>
        </Link>

        <Link
          href={ROUTES.GET_QUOTE}
          className="mt-auto w-full bg-primary text-white px-6 py-3 rounded-xl hover:bg-primary/90 transition-colors text-center"
        >
          Obtenir un devis
        </Link>
      </div>
    </div>
  );
}
