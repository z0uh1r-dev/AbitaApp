import { ProductCustomization, ProductSpecification } from "@/types/api";
import Specifications from "@/UI/Specifications";
import Link from "next/link";
import CustomizedOptions from "./CustomizedOptions";

interface ProductInfoProps {
  name: string;
  category: string;
  description: string;
  specifications: ProductSpecification[] | null;
  customized: ProductCustomization[] | null;
}

export default function ProductInfo({
  name,
  category,
  description,
  specifications,
  customized,
}: ProductInfoProps) {
  return (
    <div className="lg:sticky lg:top-24 lg:h-fit">
      <div className="flex gap-2 mb-4 flex-wrap">
        <span className="bg-primary text-white px-3 py-1 rounded-full text-sm font-medium">
          Meilleure vente
        </span>
        <span className="bg-secondary text-white px-3 py-1 rounded-full text-sm font-medium">
          Haut de gamme
        </span>
      </div>

      <h1 className="text-4xl font-bold mb-2">{name}</h1>
      <p className="text-gray-600 mb-6">{category}</p>

      <div className="mb-8">
        <p className="text-gray-700">{description}</p>
      </div>

      {/* Specifications */}
      {specifications && specifications.length > 0 && (
        <Specifications specifications={specifications} />
      )}

      {/* Customization Options */}
      {customized && customized.length > 0 && (
        <CustomizedOptions options={customized} />
      )}

      {/* CTA */}
      <div className="sticky bottom-0 bg-white py-4 border-t-2 border-gray-200 lg:border-0">
        <Link
          href="/get-quote"
          className="block w-full bg-primary text-white px-6 py-4 rounded-xl hover:bg-primary/90 transition-colors text-center font-semibold text-lg"
        >
          Obtenir un devis
        </Link>
      </div>
    </div>
  );
}
