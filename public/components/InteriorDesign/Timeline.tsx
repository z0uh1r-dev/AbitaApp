import Image from "next/image";

export default function Timeline() {
  return (
    <section className="py-24 bg-gray-50">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center max-w-3xl mx-auto mb-20">
          <div className="inline-block mb-4 px-4 py-2 bg-primary/10 text-primary rounded-full text-sm font-semibold">
            NOTRE MÉTHODE
          </div>
          <h2 className="text-4xl lg:text-5xl font-bold mb-6">
            Une méthode fluide, de l&apos;idée à la réalisation
          </h2>
        </div>

        <div className="relative">
          {/* Timeline Line */}
          <div className="hidden lg:block absolute left-1/2 top-0 bottom-0 w-0.5 bg-gradient-to-b from-primary via-secondary to-primary transform -translate-x-1/2"></div>

          {/* Steps */}
          <div className="space-y-16 lg:space-y-24">
            {/* Step 1 */}
            <div className="relative flex flex-col lg:flex-row items-center gap-8">
              <div className="lg:w-1/2 lg:text-right lg:pr-16">
                <div className="inline-block lg:float-right">
                  <div className="flex items-center gap-4 mb-4 lg:flex-row-reverse">
                    <div className="w-16 h-16 bg-primary text-white rounded-2xl flex items-center justify-center text-2xl font-bold flex-shrink-0">
                      01
                    </div>
                    <h3 className="text-2xl lg:text-3xl font-bold">
                      Audit & cadrage
                    </h3>
                  </div>
                  <p className="text-gray-600 text-lg">
                    Nous ouvrons le projet par un échange approfondi pour
                    comprendre votre marque, vos usages, vos contraintes et vos
                    objectifs.
                  </p>
                </div>
              </div>
              <div className="hidden lg:block w-6 h-6 bg-white border-4 border-primary rounded-full absolute left-1/2 transform -translate-x-1/2 z-10"></div>
              <div className="lg:w-1/2 lg:pl-16">
                <div className="rounded-2xl overflow-hidden border-2 border-gray-200 relative h-64">
                  <Image
                    src="https://images.unsplash.com/photo-1600508772927-723e3ba305c5?w=600"
                    alt="Découverte"
                    fill
                    loading="lazy"
                    sizes="(max-width: 1024px) 100vw, 50vw"
                    className="w-full h-64 object-cover"
                  />
                </div>
              </div>
            </div>

            {/* Step 2 */}
            <div className="relative flex flex-col lg:flex-row-reverse items-center gap-8">
              <div className="lg:w-1/2 lg:text-left lg:pl-16">
                <div className="flex items-center gap-4 mb-4">
                  <div className="w-16 h-16 bg-secondary text-white rounded-2xl flex items-center justify-center text-2xl font-bold flex-shrink-0">
                    02
                  </div>
                  <h3 className="text-2xl lg:text-3xl font-bold">
                    Conception & visualisation 3D
                  </h3>
                </div>
                <p className="text-gray-600 text-lg">
                  Nous donnons forme à votre projet grâce à des rendus 3D
                  photoréalistes et des planches d&apos;inspiration claires,
                  pensées pour faciliter vos décisions.
                </p>
              </div>
              <div className="hidden lg:block w-6 h-6 bg-white border-4 border-secondary rounded-full absolute left-1/2 transform -translate-x-1/2 z-10"></div>
              <div className="lg:w-1/2 lg:pr-16">
                <div className="rounded-2xl overflow-hidden border-2 border-gray-200 relative h-64">
                  <Image
                    src="https://images.unsplash.com/photo-1631889992037-5b7f0a0943f2?w=600"
                    alt="Conception 3D"
                    fill
                    loading="lazy"
                    sizes="(max-width: 1024px) 100vw, 50vw"
                    className="w-full h-64 object-cover"
                  />
                </div>
              </div>
            </div>

            {/* Step 3 */}
            <div className="relative flex flex-col lg:flex-row items-center gap-8">
              <div className="lg:w-1/2 lg:text-right lg:pr-16">
                <div className="inline-block lg:float-right">
                  <div className="flex items-center gap-4 mb-4 lg:flex-row-reverse">
                    <div className="w-16 h-16 bg-primary text-white rounded-2xl flex items-center justify-center text-2xl font-bold flex-shrink-0">
                      03
                    </div>
                    <h3 className="text-2xl lg:text-3xl font-bold">
                      Ajustements & validation
                    </h3>
                  </div>
                  <p className="text-gray-600 text-lg">
                    Nous affinons chaque détail avec vous jusqu&apos;à parvenir
                    à un résultat parfaitement aligné avec votre vision.
                  </p>
                </div>
              </div>
              <div className="hidden lg:block w-6 h-6 bg-white border-4 border-primary rounded-full absolute left-1/2 transform -translate-x-1/2 z-10"></div>
              <div className="lg:w-1/2 lg:pl-16">
                <div className="rounded-2xl overflow-hidden border-2 border-gray-200 relative h-64">
                  <Image
                    src="https://images.unsplash.com/photo-1571624436279-b272aff752b5?w=600"
                    alt="Révision"
                    fill
                    loading="lazy"
                    sizes="(max-width: 1024px) 100vw, 50vw"
                    className="w-full h-64 object-cover"
                  />
                </div>
              </div>
            </div>

            {/* Step 4 */}
            <div className="relative flex flex-col lg:flex-row-reverse items-center gap-8">
              <div className="lg:w-1/2 lg:text-left lg:pl-16">
                <div className="flex items-center gap-4 mb-4">
                  <div className="w-16 h-16 bg-secondary text-white rounded-2xl flex items-center justify-center text-2xl font-bold flex-shrink-0">
                    04
                  </div>
                  <h3 className="text-2xl lg:text-3xl font-bold">
                    Réalisation & livraison
                  </h3>
                </div>
                <p className="text-gray-600 text-lg">
                  Nous pilotons la mise en œuvre avec exigence, suivi et
                  contrôle qualité, jusqu&apos;à la livraison finale de votre
                  espace.
                </p>
              </div>
              <div className="hidden lg:block w-6 h-6 bg-white border-4 border-secondary rounded-full absolute left-1/2 transform -translate-x-1/2 z-10"></div>
              <div className="lg:w-1/2 lg:pr-16">
                <div className="rounded-2xl overflow-hidden border-2 border-gray-200 relative h-64">
                  <Image
                    src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=600"
                    alt="Livraison"
                    fill
                    loading="lazy"
                    sizes="(max-width: 1024px) 100vw, 50vw"
                    className="w-full h-64 object-cover"
                  />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
