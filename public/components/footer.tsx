import Link from "next/link";

export default function Footer() {
  return (
    <footer className="bg-gray-900 text-gray-300 py-12">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
          <div>
            {/* eslint-disable-next-line @next/next/no-img-element */}
            <img
              src="/images/logo-white.svg"
              alt="ABITA Office & Design"
              className="h-20 w-auto mb-4"
            />
            <p className="text-sm">
              Des créations personnalisées pour les entreprises et les
              événements professionnels
            </p>
          </div>
          <div>
            <h4 className="font-semibold text-white mb-4">Liens Rapides</h4>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/" className="hover:text-white">
                  Accueil
                </Link>
              </li>
              <li>
                <Link href="/products" className="hover:text-white">
                  Produits
                </Link>
              </li>
              <li>
                <Link href="/get-quote" className="hover:text-white">
                  Obtenir un devis
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h4 className="font-semibold text-white mb-4">Catégories</h4>
            <ul className="space-y-2 text-sm">
              <li>
                <Link href="/products" className="hover:text-white">
                  Produits de bureau
                </Link>
              </li>
              <li>
                <Link href="/products" className="hover:text-white">
                  Coffrets cadeaux
                </Link>
              </li>
              <li>
                <Link href="/products" className="hover:text-white">
                  High-tech
                </Link>
              </li>
              <li>
                <Link href="/products" className="hover:text-white">
                  Produits Événementiels
                </Link>
              </li>
            </ul>
          </div>
          <div>
            <h4 className="font-semibold text-white mb-4">Contact</h4>
            <ul className="space-y-2 text-sm">
              <li>📧 contact@abitaofficedesign.com</li>
              <li>📞 +212 708-768944</li>
            </ul>
          </div>
        </div>
        <div className="border-t border-gray-800 mt-8 pt-8 text-center text-sm">
          <p>&copy; 2024 ABITA Office & Design. Tous droits réservés.</p>
        </div>
      </div>
    </footer>
  );
}
