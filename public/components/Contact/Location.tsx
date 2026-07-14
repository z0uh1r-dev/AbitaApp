const GOOGLE_MAPS_URL =
  "https://www.google.com/maps/place/ABITA+OFFICE+ET+DESIGN/@33.5344222,-7.6125671,17z/data=!4m6!3m5!1s0xda62d7751e557d3:0x45aa291fdf1de785!8m2!3d33.5344222!4d-7.6125671!16s%2Fg%2F11z21l2ql9!18m1!1e1?entry=ttu&g_ep=EgoyMDI2MDcxMi4wIKXMDSoASAFQAw%3D%3D";

// Centered embed without a place query so Google's default red pin is not
// rendered — the ABITA-branded marker overlay below acts as the marker.
const MAPS_EMBED_URL =
  "https://maps.google.com/maps?ll=33.5344222,-7.6125671&z=16&output=embed";

export default function Location() {
  return (
    <section className="py-20 bg-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="text-center mb-12">
          <h2 className="text-4xl md:text-5xl font-bold mb-4">
            Visitez notre Bureau
          </h2>
          <p className="text-xl text-gray-600">
            Nous serions ravis de vous rencontrer
          </p>
        </div>

        <div className="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
          {/* Address Information */}
          <div className="space-y-6">
            <div className="flex items-start gap-4">
              <div className="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center flex-shrink-0">
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
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"
                  />
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"
                  />
                </svg>
              </div>
              <div>
                <h3 className="font-semibold text-lg mb-2">Adresse</h3>
                <p className="text-gray-600">
                  Étage 2, bureau 13, The Gold Center
                  <br />
                  Bd El Qods, Casablanca 20000
                </p>
                <a
                  href={GOOGLE_MAPS_URL}
                  target="_blank"
                  rel="noopener noreferrer"
                  className="inline-flex items-center gap-1 mt-2 text-primary font-medium hover:underline"
                >
                  Ouvrir dans Google Maps
                  <svg
                    className="h-4 w-4"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      strokeLinecap="round"
                      strokeLinejoin="round"
                      strokeWidth="2"
                      d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"
                    />
                  </svg>
                </a>
              </div>
            </div>

            <div className="flex items-start gap-4">
              <div className="w-12 h-12 bg-secondary/10 rounded-2xl flex items-center justify-center flex-shrink-0">
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
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
              </div>
              <div>
                <h3 className="font-semibold text-lg mb-2">
                  Horaires d&apos;ouverture
                </h3>
                <p className="text-gray-600">
                  Lundi - Vendredi : 9h00 - 18h00
                  <br />
                  Samedi - Dimanche : Fermé
                </p>
              </div>
            </div>
          </div>

          {/* Map with ABITA-branded marker */}
          <div className="relative rounded-3xl overflow-hidden border-2 border-gray-200 aspect-video">
            <iframe
              src={MAPS_EMBED_URL}
              title="ABITA Office et Design — The Gold Center, Bd El Qods, Casablanca"
              className="absolute inset-0 h-full w-full border-0"
              loading="lazy"
              referrerPolicy="no-referrer-when-downgrade"
              allowFullScreen
            />
            {/* Custom marker in ABITA colors, centered on the office */}
            <div className="pointer-events-none absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-full">
              <svg
                width="44"
                height="56"
                viewBox="0 0 44 56"
                fill="none"
                aria-hidden="true"
              >
                <path
                  d="M22 1C10.4 1 1 10.4 1 22c0 15.7 21 33 21 33s21-17.3 21-33C43 10.4 33.6 1 22 1z"
                  fill="#0a2463"
                  stroke="white"
                  strokeWidth="2"
                />
                <circle cx="22" cy="21" r="8" fill="#67b2d8" />
              </svg>
            </div>
            <a
              href={GOOGLE_MAPS_URL}
              target="_blank"
              rel="noopener noreferrer"
              className="absolute bottom-3 right-3 bg-primary text-white text-sm font-medium px-4 py-2 rounded-xl shadow-lg hover:bg-primary/90 transition-colors"
            >
              Itinéraire
            </a>
          </div>
        </div>
      </div>
    </section>
  );
}
