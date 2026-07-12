import Image from "next/image";

export default function Showcase() {
  return (
    <section className="py-24 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-3xl mx-auto mb-20">
          <div className="inline-block mb-4 px-4 py-2 bg-secondary/10 text-secondary rounded-full text-sm font-semibold">
            NOS RÉALISATIONS
          </div>
          <h2 className="text-4xl lg:text-5xl font-bold mb-6">
            Des espaces réinventés pour chaque secteur
          </h2>
        </div>

        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
          {/* Project 1 - Large */}
          <div className="md:col-span-2 lg:row-span-2 group relative overflow-hidden rounded-2xl min-h-[400px]">
            <Image
              src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=1000"
              alt="Bureau d'entreprise"
              fill
              sizes="(max-width: 768px) 100vw, (max-width: 1280px) 66vw, 50vw"
              className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div className="absolute bottom-0 left-0 right-0 p-8">
                <span className="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm mb-3">
                  Bureau d&apos;entreprise
                </span>
                <h3 className="text-2xl font-bold text-white mb-2">
                  Siège social moderne
                </h3>
                <p className="text-white/90">3500 m² • Rénovation complète</p>
              </div>
            </div>
          </div>

          {/* Project 2 */}
          <div className="group relative overflow-hidden rounded-2xl min-h-[250px]">
            <Image
              src="https://images.unsplash.com/photo-1571624436279-b272aff752b5?w=500"
              alt="Salle de réunion"
              fill
              loading="lazy"
              sizes="(max-width: 768px) 100vw, (max-width: 1280px) 33vw, 25vw"
              className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div className="absolute bottom-0 left-0 right-0 p-6">
                <span className="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm mb-2">
                  Salles de réunion
                </span>
                <h3 className="text-xl font-bold text-white">
                  Suite de direction
                </h3>
              </div>
            </div>
          </div>

          {/* Project 3 */}
          <div className="group relative overflow-hidden rounded-2xl min-h-[250px]">
            <Image
              src="https://images.unsplash.com/photo-1600508772927-723e3ba305c5?w=500"
              alt="Espace de travail"
              fill
              loading="lazy"
              sizes="(max-width: 768px) 100vw, (max-width: 1280px) 33vw, 25vw"
              className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div className="absolute bottom-0 left-0 right-0 p-6">
                <span className="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm mb-2">
                  Espace ouvert
                </span>
                <h3 className="text-xl font-bold text-white">
                  Pôle collaboratif
                </h3>
              </div>
            </div>
          </div>

          {/* Project 4 */}
          <div className="md:col-span-2 group relative overflow-hidden rounded-2xl min-h-[300px]">
            <Image
              src="https://images.unsplash.com/photo-1686100508812-c38b3593b301?w=800"
              alt="Espace d'exposition"
              fill
              loading="lazy"
              sizes="(max-width: 768px) 100vw, (max-width: 1280px) 66vw, 50vw"
              className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div className="absolute bottom-0 left-0 right-0 p-8">
                <span className="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm mb-3">
                  Espace d&apos;exposition
                </span>
                <h3 className="text-2xl font-bold text-white mb-2">
                  Centre d&apos;expérience de marque
                </h3>
                <p className="text-white/90">
                  1200 m² • Aménagement commercial
                </p>
              </div>
            </div>
          </div>

          {/* Project 5 */}
          <div className="group relative overflow-hidden rounded-2xl min-h-[300px]">
            <Image
              src="https://images.unsplash.com/photo-1631889992037-5b7f0a0943f2?w=500"
              alt="Rendu 3D"
              fill
              loading="lazy"
              sizes="(max-width: 768px) 100vw, (max-width: 1280px) 33vw, 25vw"
              className="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
            />
            <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/30 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
              <div className="absolute bottom-0 left-0 right-0 p-6">
                <span className="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm rounded-full text-white text-sm mb-2">
                  Visualisation 3D
                </span>
                <h3 className="text-xl font-bold text-white">
                  Conception sur mesure
                </h3>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
