/**
 * Image Gallery Component
 *
 * Interactive product image gallery with thumbnail navigation.
 * Optimized with Next.js Image for better performance.
 *
 * Performance optimizations:
 * - Next.js Image component for automatic optimization
 * - Lazy loading for thumbnails
 * - Priority loading for main image
 * - Responsive image sizes
 *
 * @module components/Product/ImageGallery
 */

"use client";

import { useState } from "react";
import Image from "next/image";
import { getStorageUrl } from "@/services";
import { ProductImage } from "@/types/api";

interface ImageGalleryProps {
  mainImageUrl: string;
  gallery: ProductImage[] | null;
}

export default function ImageGallery({
  mainImageUrl,
  gallery,
}: ImageGalleryProps) {
  const images = gallery
    ? [mainImageUrl, ...gallery.map((img: ProductImage) => img.url)]
    : [mainImageUrl];

  const [active, setActive] = useState(0);

  const changeImage = (i: number) => setActive(i);

  return (
    <div>
      {/* Main Image */}
      <div
        id="main-image"
        className="aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-50 rounded-3xl mb-4 border-2 border-gray-200 relative"
      >
        <Image
          src={getStorageUrl(images[active])}
          alt={`Product view ${active + 1}`}
          fill
          sizes="(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 600px"
          className="object-cover"
          priority={active === 0} // Priority load first image
          quality={90}
        />
      </div>

      {/* Thumbnail Grid */}
      <div className="grid grid-cols-3 gap-4">
        {images.map((src, i) => (
          <button
            key={i}
            onClick={() => changeImage(i)}
            className={`aspect-square overflow-hidden bg-gradient-to-br from-gray-100 to-gray-50 rounded-2xl border-2 cursor-pointer relative transition-all ${
              active === i
                ? "border-primary scale-95"
                : "border-gray-200 hover:border-primary"
            }`}
            aria-label={`View ${i + 1}`}
          >
            <Image
              src={getStorageUrl(src)}
              alt={`Product thumbnail ${i + 1}`}
              fill
              sizes="(max-width: 768px) 33vw, 200px"
              className="object-cover"
              loading="lazy"
              quality={75}
            />
          </button>
        ))}
      </div>
    </div>
  );
}
