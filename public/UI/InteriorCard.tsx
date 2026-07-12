import { InteriorCardProps } from "@/data/interior-design";
import CheckIcon from "./Icons/CheckIcon";
import OfficeIcon from "./Icons/office";
import InteriorDesignIcon from "./Icons/InteriorDesignIcon";
import Image from "next/image";

export default function InteriorCard({
  title,
  description,
  imageUrl,
  icon,
}: InteriorCardProps) {
  const icons = {
    modeling: <OfficeIcon />,
    design: <InteriorDesignIcon />,
    check: <CheckIcon />,
  };

  return (
    <div className="bg-white border-2 border-gray-200 rounded-3xl overflow-hidden transition-all hover:border-primary hover:-translate-y-1">
      <div className="aspect-video overflow-hidden bg-gradient-to-br from-primary/5 to-primary/10 relative">
        <Image
          src={imageUrl}
          alt={title}
          fill
          className="object-cover hover:scale-105 transition-transform duration-500"
          sizes="(min-width: 1024px) 33vw, 100vw"
        />
      </div>
      <div className="p-8">
        <div className="w-14 h-14 bg-primary/10 rounded-2xl flex items-center justify-center mb-4">
          {icons[icon as keyof typeof icons]}
        </div>
        <h3 className="text-2xl font-bold mb-3">{title}</h3>
        <p className="text-gray-600">{description}</p>
      </div>
    </div>
  );
}
