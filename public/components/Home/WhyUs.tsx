import { whyAbita } from "@/data/why-abita";
import WhyUsCard from "@/UI/WhyUsCard";

export default function WhyUs() {
  return (
    <section className="py-20 bg-primary text-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold mb-4">
            Pourquoi ABITA
          </h2>
          <p className="text-xl text-white/90">
            Votre partenaire de confiance pour les produits d’entreprise
            personnalisés
          </p>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-8">
          {whyAbita.map((item, key) => (
            <WhyUsCard {...item} key={key} />
          ))}
        </div>
      </div>
    </section>
  );
}
