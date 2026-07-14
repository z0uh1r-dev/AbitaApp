export default function Sidebar() {
  return (
    <div className="space-y-6">
      <div className="bg-white p-6 border-2 border-gray-200 rounded-3xl">
        <h4 className="text-xl font-semibold mb-4">
          Que se passe-t-il ensuite ?
        </h4>
        <ul className="space-y-3 text-sm text-gray-600">
          <li className="flex items-start gap-2">
            <svg
              className="h-5 w-5 text-primary mt-0.5 flex-shrink-0"
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
            <span>Nous analysons votre demande sous 24 heures</span>
          </li>
          <li className="flex items-start gap-2">
            <svg
              className="h-5 w-5 text-primary mt-0.5 flex-shrink-0"
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
            <span>Nous préparons un devis détaillé et structuré</span>
          </li>
          <li className="flex items-start gap-2">
            <svg
              className="h-5 w-5 text-primary mt-0.5 flex-shrink-0"
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
            <span>Nous fournirons des maquettes visuelles si nécessaire</span>
          </li>
          <li className="flex items-start gap-2">
            <svg
              className="h-5 w-5 text-primary mt-0.5 flex-shrink-0"
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
            <span>La production démarre après votre validation</span>
          </li>
        </ul>
      </div>

      <div className="bg-primary text-white p-6 border-2 border-primary rounded-3xl">
        <h4 className="text-xl font-semibold mb-4">Besoin d&apos;aide ?</h4>
        <p className="text-sm text-white/90 mb-4">
          Un doute, une contrainte ou une demande spécifique ? Notre équipe vous
          accompagne à chaque étape.
        </p>
        <div className="space-y-2 text-sm">
          <p>📧 contact@abitaofficedesign.com</p>
          <p>📞 +212 708-768944</p>
        </div>
      </div>
    </div>
  );
}
