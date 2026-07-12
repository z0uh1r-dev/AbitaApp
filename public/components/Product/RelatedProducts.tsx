import RelatedProductCard from "@/UI/RelatedProductCard";
import { Product } from "@/types/api";

interface RelatedProductsProps {
  products: Product[] | null;
}

export default function RelatedProducts({ products }: RelatedProductsProps) {
  if (!products || products.length === 0) {
    return null;
  }

  return (
    <div className="mt-20">
      <h2 className="text-3xl font-bold mb-8">Produits Similaires</h2>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        {products.map((product) => (
          <RelatedProductCard key={product.id} product={product} />
        ))}
      </div>
    </div>
  );
}
