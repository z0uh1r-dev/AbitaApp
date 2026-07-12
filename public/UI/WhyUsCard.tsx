import { WhyUsProps } from "@/data/why-abita";

import PrintingIcon from "./Icons/WhyUs/PrintingIcon";
import SolutionsIcon from "./Icons/WhyUs/SolutionsIcon";
import ExpertiseIcon from "./Icons/WhyUs/ExpertiseIcon";
import DeliveryIcon from "./Icons/WhyUs/DeliveryIcon";
import PremiumIcon from "./Icons/WhyUs/PremiumIcon";

export default function WhyUsCard({ title, description, icon }: WhyUsProps) {
  const icons = {
    premium: <PremiumIcon />,
    printing: <PrintingIcon />,
    solutions: <SolutionsIcon />,
    expertise: <ExpertiseIcon />,
    delivery: <DeliveryIcon />,
  };

  return (
    <div className="text-center">
      <div className="w-20 h-20 bg-secondary/20 rounded-3xl flex items-center justify-center mx-auto mb-6">
        {icons[icon as keyof typeof icons]}
      </div>
      <h4 className="text-xl font-semibold mb-3">{title}</h4>
      <p className="text-white/80">{description}</p>
    </div>
  );
}
