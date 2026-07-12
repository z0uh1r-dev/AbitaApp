import { process } from "@/data/process-steps";
import ProcessStep from "@/UI/ProcessStep";
import SectionHeader from "@/UI/SectionHeader";

export default function Process() {
  return (
    <section className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <SectionHeader
          title="Processus de Personnalisation"
          description="Des étapes simples pour donner vie à vos produits brandés"
        />

        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
          {process.map((item, key) => (
            <ProcessStep {...item} key={key} />
          ))}
        </div>
      </div>
    </section>
  );
}
