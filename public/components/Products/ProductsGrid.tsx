/**
 * Products Grid Component
 *
 * Displays a grid of product cards with count information.
 * Server component optimized for performance.
 *
 * @module components/Products/ProductsGrid
 */

import ProductCard from "@/UI/ProductCard";
import { Product } from "@/types/api";

interface ProductsGridProps {
  products: Product[] | null;
}

export default function ProductsGrid({ products }: ProductsGridProps) {
  const productCount = products?.length || 0;

  return (
    <div className="flex-1">
      <div className="mb-6">
        <p className="text-gray-600">
          Affichage de {productCount}{" "}
          {productCount === 1 ? "produit" : "produits"}
        </p>
      </div>

      {productCount === 0 ? (
        <div className="text-center py-12">
          <p className="text-gray-500 text-lg">Aucun produit trouvé</p>
        </div>
      ) : (
        <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
          {products?.map((product) => (
            <ProductCard key={product.id} {...product} />
          ))}
        </div>
      )}
    </div>
  );
}
