import { ProcessCardProps } from "@/data/process-steps";

export default function ProcessStep({
  id,
  title,
  description,
  parity,
}: ProcessCardProps) {
  return (
    <div className="text-center">
      <div
        className={`w-20 h-20  ${
          parity === "odd" ? "bg-primary" : "bg-secondary"
        } text-white rounded-3xl flex items-center justify-center mx-auto mb-6`}
      >
        <span className="text-3xl font-bold">{id}</span>
      </div>
      <h4 className="text-xl font-semibold mb-3">{title}</h4>
      <p className="text-gray-600">{description}</p>
    </div>
  );
}
