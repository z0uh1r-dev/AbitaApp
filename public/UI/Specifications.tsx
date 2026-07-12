import { ProductSpecification } from "@/types/api";

export default function Specifications({
  specifications,
}: {
  specifications: ProductSpecification[];
}) {
  return (
    <div className="bg-white p-6 mb-6 border-2 border-gray-200 rounded-3xl">
      <h3 className="text-xl font-semibold mb-4">Spécifications Techniques</h3>
      <dl className="space-y-3">
        {specifications.map((s, key) => (
          <div key={key} className="flex justify-between">
            <dt className="text-gray-600">{s.label}</dt>
            <dd className="font-medium">{s.value}</dd>
          </div>
        ))}
      </dl>
    </div>
  );
}
