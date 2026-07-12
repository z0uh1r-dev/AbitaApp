import Link from "next/link";
import SubmitQuoteButton from "./SubmitQuoteButton";

interface QuoteFormProps {
  action: (formData: FormData) => Promise<void>;
  showThankYou: boolean;
  hasError?: boolean;
}

export default function QuoteForm({
  action,
  showThankYou,
  hasError = false,
}: QuoteFormProps) {
  if (showThankYou) {
    return (
      <div className="lg:col-span-2">
        <div className="bg-white p-12 text-center border-2 border-gray-200 rounded-3xl">
          <div className="w-20 h-20 bg-green-100 rounded-2xl flex items-center justify-center mx-auto mb-6">
            <svg
              className="h-10 w-10 text-green-600"
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
          </div>
          <h1 className="text-4xl font-bold mb-4">Merci !</h1>
          <p className="text-xl text-gray-600 mb-8">
            Nous avons bien reçu votre demande de devis et vous répondrons sous
            24 heures.
          </p>
          <div className="flex flex-col sm:flex-row gap-4 justify-center">
            <Link
              href="/"
              className="bg-primary text-white px-6 py-3 rounded-xl hover:bg-primary/90 transition-colors"
            >
              Retour à l&apos;Accueil
            </Link>
            <Link
              href="/products"
              className="border-2 border-gray-900 text-gray-900 px-6 py-3 rounded-xl hover:bg-gray-50 transition-colors"
            >
              Voir les produits
            </Link>
          </div>
        </div>
      </div>
    );
  }

  return (
    <div className="lg:col-span-2">
      <div className="bg-white p-6 md:p-8 border-2 border-gray-200 rounded-3xl">
        {hasError && (
          <div className="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
            Nous n&apos;avons pas pu envoyer votre demande. Veuillez vérifier
            vos informations et réessayer.
          </div>
        )}
        <form id="quote-form" className="space-y-6" action={action}>
          {/* Company Information */}
          <div>
            <h3 className="text-2xl font-semibold mb-4">
              Informations sur l&apos;entreprise
            </h3>
            <div className="space-y-4">
              <div>
                <label
                  htmlFor="companyName"
                  className="block text-sm font-medium mb-2"
                >
                  Nom de l&apos;entreprise *
                </label>
                <input
                  type="text"
                  id="companyName"
                  name="companyName"
                  required
                  className="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-primary"
                  placeholder="Nom de votre entreprise"
                />
              </div>

              <div>
                <label
                  htmlFor="contactName"
                  className="block text-sm font-medium mb-2"
                >
                  Nom du contact *
                </label>
                <input
                  type="text"
                  id="contactName"
                  name="contactName"
                  required
                  className="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-primary"
                  placeholder="Votre nom complet"
                />
              </div>

              <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                  <label
                    htmlFor="email"
                    className="block text-sm font-medium mb-2"
                  >
                    E-mail *
                  </label>
                  <input
                    type="email"
                    id="email"
                    name="email"
                    required
                    className="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-primary"
                    placeholder="nom@entreprise.com"
                  />
                </div>

                <div>
                  <label
                    htmlFor="phone"
                    className="block text-sm font-medium mb-2"
                  >
                    Numéro de téléphone *
                  </label>
                  <input
                    type="tel"
                    id="phone"
                    name="phone"
                    required
                    className="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-primary"
                    placeholder="+212 708-768944"
                  />
                </div>
              </div>
            </div>
          </div>

          {/* Project Details */}
          <div>
            <h3 className="text-2xl font-semibold mb-4">Détails du projet</h3>
            <div className="space-y-4">
              <div>
                <label
                  htmlFor="message"
                  className="block text-sm font-medium mb-2"
                >
                  Informations complémentaires *
                </label>
                <textarea
                  id="message"
                  name="message"
                  rows={6}
                  required
                  minLength={10}
                  className="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-primary resize-none"
                  placeholder="Décrivez votre projet, vos besoins en personnalisation, vos délais, etc."
                />
              </div>
            </div>
          </div>

          <SubmitQuoteButton />
        </form>
      </div>
    </div>
  );
}
