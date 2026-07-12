import dynamic from "next/dynamic";
import { Suspense } from "react";
import { notFound } from "next/navigation";
import Breadcrumb from "@/components/Product/Breadcrumb";
import ProductInfo from "@/components/Product/ProductInfo";
import { getProductsProductSlug } from "@/src/api/products/products";
import LoadingFallback from "@/components/LoadingFallback";
import { safeApiCall } from "@/lib/api-error-handler";
import type { Product } from "@/types/api";

function normalizeProduct(
  input: Partial<Product> | null | undefined
): Product | null {
  if (
    !input ||
    typeof input.id !== "number" ||
    !input.name ||
    !input.slug ||
    !input.description ||
    !input.imageUrl
  ) {
    return null;
  }

  return {
    id: input.id,
    name: input.name,
    slug: input.slug,
    description: input.description,
    imageUrl: input.imageUrl,
    categoryId: input.categoryId ?? 0,
    category: input.category,
    specifications: input.specifications ?? [],
    customizations: input.customizations ?? [],
    images: input.images ?? [],
    createdAt: input.createdAt,
    updatedAt: input.updatedAt,
  };
}

function normalizeProducts(
  input: Array<Partial<Product>> | null | undefined
): Product[] | null {
  if (!input || input.length === 0) {
    return null;
  }

  const products = input
    .map((item) => normalizeProduct(item))
    .filter((item): item is Product => item !== null);

  return products.length > 0 ? products : null;
}

// Dynamic imports for heavy components
const ImageGallery = dynamic(
  () => import("@/components/Product/ImageGallery"),
  {
    loading: () => <LoadingFallback />,
  }
);

const RelatedProducts = dynamic(
  () => import("@/components/Product/RelatedProducts"),
  {
    loading: () => <LoadingFallback />,
  }
);

export default async function ProductPage({
  params,
}: {
  params: Promise<{ slug: string }>;
}) {
  const { slug } = await params;

  let product: Product | null = null;
  let relatedProducts: Product[] | null = null;

  if (slug) {
    const response = await safeApiCall(() => getProductsProductSlug(slug));

    if (response?.status === 200 && response.data?.data) {
      product = normalizeProduct(response.data.data as Partial<Product>);
      relatedProducts = normalizeProducts(
        (response.data.relatedProducts as
          | Array<Partial<Product>>
          | undefined) ?? null
      );
    }
  }

  if (!product) {
    notFound();
  }

  return (
    <>
      <Breadcrumb />

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12">
          <Suspense fallback={<LoadingFallback />}>
            <ImageGallery
              mainImageUrl={product.imageUrl}
              gallery={product.images ?? null}
            />
          </Suspense>

          <ProductInfo
            name={product.name}
            category={product.category?.name ?? "Non catégorisé"}
            description={product.description}
            specifications={product.specifications ?? null}
            customized={product.customizations ?? null}
          />
        </div>

        <Suspense fallback={<LoadingFallback />}>
          <RelatedProducts products={relatedProducts} />
        </Suspense>
      </div>
    </>
  );
}
