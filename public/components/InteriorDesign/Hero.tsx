import Link from "next/link";
import Image from "next/image";

export default function Hero() {
  return (
    <section className="split-section flex flex-col lg:flex-row">
      {/* Left Side - Content */}
      <div className="w-full lg:w-1/2 bg-primary text-white flex items-center justify-center p-8 lg:p-16">
        <div className="max-w-xl">
          <div className="inline-block mb-6 px-4 py-2 bg-white/10 rounded-full text-sm font-medium">
            Conception & aménagement d&apos;espaces professionnels
          </div>
          <h1 className="text-5xl lg:text-6xl xl:text-7xl font-bold mb-6 leading-tight">
            Des espaces pensés pour inspirer
          </h1>
          <p className="text-xl lg:text-2xl text-white/90 mb-8 leading-relaxed">
            Donnez à vos bureaux une identité forte, cohérente et inspirante, au
            service de votre culture d&apos;entreprise
          </p>
          <div className="flex flex-col sm:flex-row gap-4">
            <Link
              href="/get-quote"
              className="bg-secondary text-white px-8 py-4 rounded-xl hover:bg-secondary/90 transition-all text-center font-semibold"
            >
              Lancer votre projet
            </Link>
            <a
              href="#services"
              className="bg-white/10 backdrop-blur-sm text-white px-8 py-4 rounded-xl hover:bg-white/20 transition-all text-center font-semibold"
            >
              Découvrir nos services
            </a>
          </div>
        </div>
      </div>

      {/* Right Side - Image */}
      <div className="w-full lg:w-1/2 h-64 lg:h-auto relative overflow-hidden">
        <Image
          src="https://images.unsplash.com/photo-1497366754035-f200968a6e72?w=1200"
          alt="Intérieur de bureau moderne"
          fill
          priority
          sizes="(max-width: 1024px) 100vw, 50vw"
          className="absolute inset-0 w-full h-full object-cover"
        />
        <div className="absolute inset-0 bg-gradient-to-t lg:bg-gradient-to-r from-primary/20 to-transparent"></div>
      </div>
    </section>
  );
}
