import { ProductCustomization } from "@/types/api";
import CustomizationOption from "@/UI/CustomizationOption";

export default function CustomizedOptions({
  options,
}: {
  options: ProductCustomization[];
}) {
  return (
    <div className="bg-white p-6 mb-6 border-2 border-gray-200 rounded-3xl">
      <h3 className="text-xl font-semibold mb-4">
        Options de Personnalisation
      </h3>
      <ul className="space-y-2">
        {options.map((o, key) => (
          <CustomizationOption key={key} option={o} />
        ))}
      </ul>
    </div>
  );
}
