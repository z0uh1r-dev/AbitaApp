import { apiService } from "./api.service";

function normalizeContactEndpoint(rawEndpoint: string | undefined): string {
  const fallback = "/contact-messages";

  if (!rawEndpoint) {
    return fallback;
  }

  const trimmed = rawEndpoint.trim();
  if (!trimmed) {
    return fallback;
  }

  if (/^https?:\/\//i.test(trimmed)) {
    return trimmed;
  }

  const withoutLeadingSlash = trimmed.replace(/^\/+/, "");
  const withoutApiPrefix = withoutLeadingSlash.replace(/^api\/v1\/?/, "");

  if (!withoutApiPrefix) {
    return fallback;
  }

  return `/${withoutApiPrefix}`;
}

const CONTACT_SUBMIT_ENDPOINT = normalizeContactEndpoint(
  process.env.NEXT_PUBLIC_CONTACT_API_ENDPOINT
);

export interface ContactSubmission {
  fullName: string;
  companyName: string;
  email: string;
  phone: string;
  message: string;
}

interface ContactApiResponse {
  message?: string;
}

export const contactService = {
  async submit(data: ContactSubmission): Promise<void> {
    const requestBody: ContactSubmission = data;

    if (/^https?:\/\//i.test(CONTACT_SUBMIT_ENDPOINT)) {
      const response = await fetch(CONTACT_SUBMIT_ENDPOINT, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(requestBody),
        cache: "no-store",
      });

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        throw new Error(
          errorData.message ||
            `Contact request failed with status ${response.status}`
        );
      }

      await response.json().catch(() => ({}) as ContactApiResponse);
      return;
    }

    await apiService.post<ContactApiResponse>(
      CONTACT_SUBMIT_ENDPOINT,
      requestBody,
      {
        cache: "no-store",
      }
    );
  },
};
