import { ProductCustomization } from "@/types/api";

export default function CustomizationOption({
  option,
}: {
  option: ProductCustomization;
}) {
  return (
    <li className="flex items-start gap-2">
      <svg
        className="h-5 w-5 text-primary mt-0.5 flex-shrink-0"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          strokeLinecap="round"
          strokeLinejoin="round"
          strokeWidth="2"
          d="M5 13l4 4L19 7"
        />
      </svg>
      <span>{option.label}</span>
    </li>
  );
}
