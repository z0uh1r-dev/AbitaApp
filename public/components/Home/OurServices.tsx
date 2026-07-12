import { services } from "@/data/services";
import InteriorDesignIcon from "@/UI/Icons/InteriorDesignIcon";
import OfficeIcon from "@/UI/Icons/office";
import SectionHeader from "@/UI/SectionHeader";
import Link from "next/link";
import Image from "next/image";

export default function OurServices() {
  const icons = {
    office: <OfficeIcon />,
    design: <InteriorDesignIcon />,
  };

  return (
    <section className="py-20 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <SectionHeader
          title="Nos Services"
          description="Deux solutions complètes pour renforcer votre présence de marque"
        />

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
          {services.map((service, key) => (
            <div
              key={key}
              className="bg-white border-2 border-gray-200 rounded-3xl overflow-hidden transition-all hover:border-primary hover:-translate-y-1"
            >
              <div className="aspect-video overflow-hidden bg-gradient-to-br from-primary/5 to-primary/10 relative">
                <Image
                  src={service.imageUrl}
                  alt={service.title}
                  fill
                  className="object-cover hover:scale-105 transition-transform duration-500"
                  sizes="(min-width: 1024px) 50vw, 100vw"
                />
              </div>
              <div className="p-8 lg:p-10">
                <div className="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-6">
                  {icons[service.icon as keyof typeof icons]}
                </div>
                <h3 className="text-3xl font-bold mb-4">{service.title}</h3>
                <p className="text-lg text-gray-600 mb-8">
                  {service.description}
                </p>
                <Link
                  href={service.link}
                  className="w-full bg-primary text-white px-8 py-4 rounded-xl hover:bg-primary/90 transition-colors inline-flex items-center justify-center"
                >
                  {`Découvrir ${service.title}`}
                  <svg
                    className="ml-2 h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth="2"
                      d="M9 5l7 7-7 7"
                    />
                  </svg>
                </Link>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
