import InformationsAndForm from "@/components/Contact/InformationsAndForm";
import Hero from "@/components/Contact/Hero";
import Location from "@/components/Contact/Location";
import { contactService } from "@/services";
import { redirect } from "next/navigation";
import { z } from "zod";

type ContactErrorType = "validation" | "endpoint" | "submit";

const contactFormSchema = z.object({
  fullName: z.string().trim().min(2, "Full name is required"),
  companyName: z.string().trim().min(2, "Company name is required"),
  email: z.string().trim().email("Valid email is required"),
  phone: z
    .string()
    .trim()
    .regex(/^\+?[\d\s-()]+$/, "Valid phone number is required"),
  message: z.string().trim().min(10, "Message must be at least 10 characters"),
});

function getFormValue(formData: FormData, fieldName: string): string {
  const directValue = formData.get(fieldName);
  if (typeof directValue === "string") {
    return directValue;
  }

  const prefixedKeyPattern = new RegExp(`^\\d+_${fieldName}$`);
  for (const [key, value] of formData.entries()) {
    if (prefixedKeyPattern.test(key) && typeof value === "string") {
      return value;
    }
  }

  return "";
}

async function submitContact(formData: FormData) {
  "use server";

  const parsed = contactFormSchema.safeParse({
    fullName: getFormValue(formData, "fullName"),
    companyName: getFormValue(formData, "companyName"),
    email: getFormValue(formData, "email"),
    phone: getFormValue(formData, "phone"),
    message: getFormValue(formData, "message"),
  });

  if (!parsed.success) {
    redirect("/contact?error=validation");
  }

  try {
    await contactService.submit(parsed.data);
  } catch (error) {
    console.error("Failed to submit contact request:", error);
    const message = error instanceof Error ? error.message.toLowerCase() : "";
    if (message.includes("could not be found") || message.includes("404")) {
      redirect("/contact?error=endpoint");
    }

    redirect("/contact?error=submit");
  }

  redirect("/contact?success=1");
}

export default async function Contact({
  searchParams,
}: {
  searchParams: Promise<{ success?: string; error?: ContactErrorType }>;
}) {
  const resolvedSearchParams = await searchParams;
  const showThankYou = resolvedSearchParams?.success === "1";
  const error = resolvedSearchParams?.error;

  return (
    <>
      <Hero />
      <InformationsAndForm
        action={submitContact}
        showThankYou={showThankYou}
        errorType={error}
      />
      <Location />
    </>
  );
}
