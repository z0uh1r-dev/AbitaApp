import EventsIcon from "@/UI/Icons/EventsIcon";
import GiftIcon from "@/UI/Icons/GiftIcon";
import OfficeIcon from "@/UI/Icons/office";
import TailorIcon from "@/UI/Icons/TailorIcon";

import { whatWeDo } from "@/data/what-we-do";
import SectionHeader from "@/UI/SectionHeader";

export default function WhatWeDo() {
  const icons = {
    office: <OfficeIcon />,
    gifts: <GiftIcon />,
    events: <EventsIcon />,
    tailor: <TailorIcon />,
  };

  return (
    <section className="py-20 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <SectionHeader
          title="Ce que nous faisons"
          description="Nous sommes spécialisés dans la création de produits d'entreprise personnalisés qui renforcent votre identité de marque"
        />

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          {whatWeDo.map((service, key) => (
            <div
              key={key}
              className="bg-white p-8 border-2 border-gray-200 rounded-3xl transition-all hover:border-primary hover:-translate-y-1"
            >
              <div className="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mb-6">
                {icons[service.icon as keyof typeof icons]}
              </div>
              <h3 className="text-xl font-semibold mb-3">{service.title}</h3>
              <p className="text-gray-600">{service.description}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
