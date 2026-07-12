import CategoryCard from "@/UI/CategoryCard";
import { getCategories } from "@/src/api/categories/categories";
import { safeApiCall } from "@/lib/api-error-handler";

export default async function ProductCategories() {
  const response = await safeApiCall(() => getCategories());
  const categories = response?.data?.data || [];

  if (!response || categories.length === 0) {
    return null;
  }

  return (
    <section className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold mb-4">
            Catégories de Produits
          </h2>
          <p className="text-xl text-gray-600">
            Découvrez notre large gamme de produits de bureau et
            d&apos;entreprise personnalisés.
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {categories
            .filter(
              (c): c is typeof c & { id: number; name: string; slug: string } =>
                c.id !== undefined && !!c.name && !!c.slug
            )
            .map((category) => (
              <CategoryCard
                key={category.id}
                {...category}
                imageUrl={category.imageUrl ?? null}
                description={category.description ?? null}
              />
            ))}
        </div>
      </div>
    </section>
  );
}
