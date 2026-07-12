/**
 * Category Card Component
 *
 * Displays a product category with image and description.
 * Optimized with Next.js Image and prefetch for better navigation.
 *
 * @module UI/CategoryCard
 */

import { memo } from "react";
import Link from "next/link";
import Image from "next/image";
import { getStorageUrl } from "@/services";
import { ROUTES } from "@/utils";

interface CategoryCardProps {
  id: string | number;
  slug: string;
  imageUrl: string | null;
  name: string;
  description: string | null;
}

function CategoryCard({
  slug,
  imageUrl,
  name,
  description,
}: CategoryCardProps) {
  return (
    <Link
      href={`${ROUTES.PRODUCTS}?category=${slug}`}
      prefetch={true}
      className="group bg-white overflow-hidden border-2 border-gray-200 rounded-3xl transition-all hover:border-primary hover:-translate-y-1 hover:shadow-xl"
    >
      <div className="aspect-[4/3] overflow-hidden bg-gradient-to-br from-gray-100 to-gray-50 relative">
        <Image
          src={getStorageUrl(imageUrl)}
          alt={name}
          fill
          sizes="(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 25vw"
          className="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
          priority={false}
          loading="lazy"
        />
      </div>
      <div className="p-6">
        <h3 className="text-xl font-semibold mb-2">{name}</h3>
        {description && <p className="text-sm text-gray-600">{description}</p>}
      </div>
    </Link>
  );
}

export default memo(CategoryCard);
