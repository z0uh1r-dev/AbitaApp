import Link from "next/link";
import Image from "next/image";

export default function OurServices() {
  return (
    <section id="services" className="py-24 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="max-w-3xl mb-20">
          <div className="inline-block mb-4 px-4 py-2 bg-secondary/10 text-secondary rounded-full text-sm font-semibold">
            NOTRE EXPERTISE
          </div>
          <h2 className="text-4xl lg:text-5xl font-bold mb-6">
            Solutions de design complètes
          </h2>
          <p className="text-xl text-gray-600">
            Du concept initial à l’exécution finale, nous gérons chaque aspect
            de votre projet de design d’intérieur avec précision et créativité.
          </p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-8">
          {/* Service 1 - Large */}
          <div className="lg:row-span-2 group relative overflow-hidden rounded-2xl bg-gray-900 text-white">
            <Image
              src="https://images.unsplash.com/photo-1631889992037-5b7f0a0943f2?w=800"
              alt="3D Visualization"
              fill
              loading="lazy"
              sizes="(max-width: 1024px) 100vw, 50vw"
              className="absolute inset-0 w-full h-full object-cover opacity-60 group-hover:scale-105 transition-transform duration-700"
            />
            <div className="relative h-full min-h-[500px] p-8 lg:p-12 flex flex-col justify-end bg-gradient-to-t from-black/80 via-black/40 to-transparent">
              <div className="mb-4">
                <div className="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mb-4">
                  <svg
                    className="h-7 w-7"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth="2"
                      d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"
                    />
                  </svg>
                </div>
                <h3 className="text-3xl font-bold mb-3">Visualisation 3D</h3>
                <p className="text-white/90 text-lg mb-6">
                  Visualisez votre espace avant sa construction. Rendus 3D haute
                  fidélité, visites virtuelles et maquettes détaillées qui
                  donnent vie à votre vision.
                </p>
              </div>
              <Link
                href="/get-quote"
                className="inline-flex items-center text-white font-semibold group-hover:gap-3 gap-2 transition-all"
              >
                Commencer
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

          {/* Service 2 */}
          <div className="group relative overflow-hidden rounded-2xl bg-gray-100 min-h-[240px]">
            <Image
              src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=600"
              alt="Interior Architecture"
              fill
              loading="lazy"
              sizes="(max-width: 1024px) 100vw, 50vw"
              className="absolute inset-0 w-full h-full object-cover opacity-30 group-hover:opacity-40 group-hover:scale-105 transition-all duration-700"
            />
            <div className="relative h-full p-8 flex flex-col justify-end">
              <div className="w-12 h-12 bg-primary rounded-xl flex items-center justify-center mb-4">
                <svg
                  className="h-6 w-6 text-white"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"
                  />
                </svg>
              </div>
              <h3 className="text-2xl font-bold mb-2">
                Architecture d’Intérieur
              </h3>
              <p className="text-gray-700">
                Solutions complètes de conception et planification spatiale
              </p>
            </div>
          </div>

          {/* Service 3 */}
          <div className="group relative overflow-hidden rounded-2xl bg-secondary text-white min-h-[240px]">
            <div className="absolute inset-0 opacity-10">
              <div
                className="absolute inset-0"
                style={{
                  backgroundImage:
                    "url('data:image/svg+xml,%3Csvg width=\\'60\\' height=\\'60\\' viewBox=\\'0 0 60 60\\' xmlns=\\'http://www.w3.org/2000/svg\\'%3E%3Cg fill=\\'none\\' fill-rule=\\'evenodd\\'%3E%3Cg fill=\\'%23ffffff\\' fill-opacity=\\'1\\'%3E%3Cpath d=\\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')",
                }}
              ></div>
            </div>
            <div className="relative h-full p-8 flex flex-col justify-end">
              <div className="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center mb-4">
                <svg
                  className="h-6 w-6"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"
                  />
                </svg>
              </div>
              <h3 className="text-2xl font-bold mb-2">
                Image de Marque de l’Espace
              </h3>
              <p className="text-white/90">
                Intégrez votre marque dans chaque recoin de votre espace
              </p>
            </div>
          </div>

          {/* Service 4 */}
          <div className="lg:col-span-2 group relative overflow-hidden rounded-2xl border-2 border-gray-200 bg-white hover:border-primary transition-colors min-h-[200px]">
            <div className="h-full p-8 lg:p-12 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
              <div className="flex-1">
                <div className="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center mb-4">
                  <svg
                    className="h-6 w-6 text-primary"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </div>
                <h3 className="text-2xl lg:text-3xl font-bold mb-3">
                  Exécution Clé en Main
                </h3>
                <p className="text-gray-600 text-lg">
                  De la construction à l’installation finale, nous gérons chaque
                  détail de la livraison de votre projet avec une précision
                  professionnelle.
                </p>
              </div>
              <Link
                href="/get-quote"
                className="flex-shrink-0 bg-primary text-white px-8 py-4 rounded-xl hover:bg-primary/90 transition-all font-semibold whitespace-nowrap"
              >
                Demander un Devis
              </Link>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
