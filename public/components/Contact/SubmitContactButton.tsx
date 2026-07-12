"use client";

import { useFormStatus } from "react-dom";

export default function SubmitContactButton() {
  const { pending } = useFormStatus();

  return (
    <button
      type="submit"
      disabled={pending}
      aria-busy={pending}
      className="w-full bg-primary text-white px-8 py-4 rounded-xl hover:bg-primary/90 transition-colors font-medium text-lg disabled:opacity-70 disabled:cursor-not-allowed"
    >
      {pending ? (
        <span className="inline-flex items-center justify-center gap-2">
          <span className="h-5 w-5 rounded-full border-2 border-white/40 border-t-white animate-spin" />
          Envoi en cours...
        </span>
      ) : (
        "Envoyer le message"
      )}
    </button>
  );
}
