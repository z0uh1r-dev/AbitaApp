import Image from "next/image";

const partners = [
  { name: "Snapdragon", logo: "/images/clients/snapdragon.jpg" },
  { name: "Dell Technologies", logo: "/images/clients/dell-technologies.jpg" },
  {
    name: "Office National Des Aéroports — Aéroport Rabat-Salé",
    logo: "/images/clients/onda-aeroport-rabat-sale.jpg",
  },
  { name: "ENCG Casablanca", logo: "/images/clients/encg-casablanca.jpg" },
  { name: "ENSET Mohammedia", logo: "/images/clients/enset-mohammedia.jpg" },
  { name: "N.SYNERGY", logo: "/images/clients/n-synergy.jpg" },
  {
    name: "Moroccan Interior Decor",
    logo: "/images/clients/moroccan-interior-decor.jpg",
  },
  {
    name: "Innovative Systems",
    logo: "/images/clients/innovative-systems.jpg",
  },
  { name: "CRC & Consulting", logo: "/images/clients/crc-consulting.jpg" },
  { name: "AIE Solutions", logo: "/images/clients/aie-solutions.jpg" },
  { name: "Prestige Bladi", logo: "/images/clients/prestige-bladi.jpg" },
  { name: "NouvBat", logo: "/images/clients/nouvbat.jpg" },
  { name: "B-LOG", logo: "/images/clients/b-log.jpg" },
  {
    name: "Groupe des Instituts Binaire Santé",
    logo: "/images/clients/instituts-binaire-sante.jpg",
  },
  { name: "Africa Drives", logo: "/images/clients/africa-drives.jpg" },
  { name: "Level Up", logo: "/images/clients/level-up.jpg" },
  { name: "Bellabbes", logo: "/images/clients/bellabbes.jpg" },
  { name: "City Doctor", logo: "/images/clients/city-doctor.jpg" },
  { name: "Chamel Express", logo: "/images/clients/chamel-express.jpg" },
  {
    name: "Logtandem International",
    logo: "/images/clients/logtandem-international.jpg",
  },
];

export default function Partners() {
  return (
    <section className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-16">
          <h2 className="text-4xl md:text-5xl font-bold mb-4">
            Ils nous font confiance
          </h2>
          <p className="text-xl text-gray-600">
            La confiance des entreprises et institutions
          </p>
        </div>

        <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
          {partners.map((partner) => (
            <div
              key={partner.name}
              className="bg-gray-50 rounded-3xl p-6 flex items-center justify-center border-2 border-gray-200 transition-all hover:border-primary"
            >
              <div className="relative w-full aspect-square max-w-[8rem]">
                <Image
                  src={partner.logo}
                  alt={partner.name}
                  fill
                  className="object-contain"
                  sizes="(min-width: 1024px) 20vw, (min-width: 768px) 33vw, 50vw"
                />
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}
