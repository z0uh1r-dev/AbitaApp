import Link from "next/link";

import SectionHeader from "@/UI/SectionHeader";
import { interiorDesign } from "@/data/interior-design";
import InteriorCard from "@/UI/InteriorCard";

export default function InteriorDesign() {
  return (
    <section className="py-20 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <SectionHeader
          title="Design d'intérieur & image de marque"
          description="Nous concevons des espaces professionnels qui reflètent votre identité de marque, du concept à la réalisation."
        />

        <div className="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
          {interiorDesign.map((item, key) => (
            <InteriorCard key={key} {...item} />
          ))}
        </div>

        <div className="text-center">
          <Link
            href="/interior-design"
            className="inline-flex items-center gap-2 bg-primary text-white text-lg px-8 py-4 rounded-xl hover:bg-primary/90 transition-colors"
          >
            Explorer le design d&apos;intérieur
            <svg
              className="h-5 w-5"
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
    </section>
  );
}
