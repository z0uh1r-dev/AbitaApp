import Link from "next/link";

export default function CtaSection() {
  return (
    <section className="relative overflow-hidden">
      <div className="flex flex-col lg:flex-row min-h-[600px]">
        {/* Dark Side */}
        <div className="w-full lg:w-1/2 bg-primary text-white p-8 lg:p-16 flex items-center">
          <div className="max-w-xl mx-auto">
            <h2 className="text-4xl lg:text-5xl font-bold mb-6">
              Prêt à transformer votre espace de travail ?
            </h2>
            <p className="text-xl text-white/90 mb-8">
              Créons un environnement qui inspire votre équipe et impressionne
              vos clients.
            </p>
            <ul className="space-y-4 mb-8">
              <li className="flex items-center gap-3">
                <svg
                  className="h-6 w-6 flex-shrink-0"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M5 13l4 4L19 7"
                  />
                </svg>
                <span>Consultation initiale gratuite</span>
              </li>
              <li className="flex items-center gap-3">
                <svg
                  className="h-6 w-6 flex-shrink-0"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M5 13l4 4L19 7"
                  />
                </svg>
                <span>Visualisation 3D détaillée</span>
              </li>
              <li className="flex items-center gap-3">
                <svg
                  className="h-6 w-6 flex-shrink-0"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M5 13l4 4L19 7"
                  />
                </svg>
                <span>Livraison clé en main</span>
              </li>
            </ul>
            <Link
              href="/get-quote"
              className="inline-flex items-center gap-2 bg-secondary text-white px-8 py-4 rounded-xl hover:bg-secondary/90 transition-all font-semibold text-lg"
            >
              Obtenir votre Devis
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

        {/* Light Side - Contact Info */}
        <div className="w-full lg:w-1/2 bg-gray-50 p-8 lg:p-16 flex items-center">
          <div className="max-w-xl mx-auto w-full">
            <div className="mb-8">
              <h3 className="text-2xl font-bold mb-4">Prendre contact</h3>
              <p className="text-gray-600 text-lg">
                Notre équipe est prête à discuter de votre projet et à vous
                fournir des conseils d&apos;experts.
              </p>
            </div>

            <div className="space-y-6">
              <div className="flex items-start gap-4 p-6 bg-white rounded-xl border border-gray-200">
                <div className="w-12 h-12 bg-primary/10 rounded-xl flex items-center justify-center flex-shrink-0">
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
                      d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                    />
                  </svg>
                </div>
                <div>
                  <div className="font-semibold mb-1">Écrivez-nous</div>
                  <a
                    href="mailto:contact@abitaofficedesign.com"
                    className="text-primary hover:text-primary/80"
                  >
                    contact@abitaofficedesign.com
                  </a>
                </div>
              </div>

              <div className="flex items-start gap-4 p-6 bg-white rounded-xl border border-gray-200">
                <div className="w-12 h-12 bg-secondary/10 rounded-xl flex items-center justify-center flex-shrink-0">
                  <svg
                    className="h-6 w-6 text-secondary"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth="2"
                      d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"
                    />
                  </svg>
                </div>
                <div>
                  <div className="font-semibold mb-1">Appelez-nous</div>
                  <a
                    href="tel:+212708768944"
                    className="text-primary hover:text-primary/80"
                  >
                    +212 708-768944
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
}
