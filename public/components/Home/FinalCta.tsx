import Link from "next/link";

export default function FinalCta() {
  return (
    <section className="py-20 bg-primary text-white">
      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 className="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">
          Un projet, un lancement ou un événement à venir ?
        </h2>
        <p className="text-xl text-white/90 mb-8">
          Imaginons ensemble une solution qui vous ressemble
        </p>
        <Link
          href="/get-quote"
          className="bg-secondary text-white text-lg px-8 py-4 rounded-xl hover:bg-secondary/90 transition-colors inline-flex items-center"
        >
          Obtenir un devis
          <svg
            className="ml-2 h-5 w-5"
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
    </section>
  );
}
