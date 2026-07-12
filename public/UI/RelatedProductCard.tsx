/**
 * Related Product Card Component
 *
 * Compact card for displaying related products.
 * Used in product detail pages.
 *
 * @module UI/RelatedProductCard
 */

import { memo } from "react";
import Link from "next/link";
import Image from "next/image";
import { getStorageUrl } from "@/services";
import { ROUTES } from "@/utils";
import { Product } from "@/types/api";

interface RelatedProductCardProps {
  product: Product;
}

function RelatedProductCard({ product }: RelatedProductCardProps) {
  return (
    <Link
      href={ROUTES.PRODUCT_DETAIL(product.slug)}
      prefetch={true}
      className="group bg-white border-2 border-gray-200 rounded-3xl overflow-hidden transition-all hover:border-primary hover:-translate-y-1"
    >
      <div className="aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-50 relative">
        <Image
          src={getStorageUrl(product.imageUrl)}
          alt={product.name}
          fill
          sizes="(max-width: 768px) 100vw, (max-width: 1024px) 50vw, 33vw"
          className="object-cover transition-transform duration-300 group-hover:scale-105"
          loading="lazy"
        />
      </div>
      <div className="p-4">
        <h3 className="text-lg font-semibold mb-1 line-clamp-1">
          {product.name}
        </h3>
        <p className="text-sm text-gray-600 line-clamp-2">
          {product.description}
        </p>
      </div>
    </Link>
  );
}

export default memo(RelatedProductCard);
