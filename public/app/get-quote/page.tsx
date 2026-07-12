import Header from "@/components/GetQuote/Header";
import QuoteForm from "@/components/GetQuote/QuoteForm";
import Sidebar from "@/components/GetQuote/Sidebar";
import { quotesService } from "@/services";
import { redirect } from "next/navigation";
import { z } from "zod";

const quoteFormSchema = z.object({
  companyName: z.string().trim().min(2, "Company name is required"),
  contactName: z.string().trim().min(2, "Contact name is required"),
  email: z.string().trim().email("Valid email is required"),
  phone: z
    .string()
    .trim()
    .regex(/^\+?[\d\s-()]+$/, "Valid phone number is required"),
  message: z
    .string()
    .trim()
    .min(10, "Additional information must be at least 10 characters"),
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

async function submitQuote(formData: FormData) {
  "use server";

  const parsed = quoteFormSchema.safeParse({
    companyName: getFormValue(formData, "companyName"),
    contactName: getFormValue(formData, "contactName"),
    email: getFormValue(formData, "email"),
    phone: getFormValue(formData, "phone"),
    message: getFormValue(formData, "message"),
  });

  if (!parsed.success) {
    redirect("/get-quote?error=validation");
  }

  const { companyName, contactName, email, phone, message } = parsed.data;

  const payload = {
    company: companyName,
    name: contactName,
    email,
    phone,
    message,
  };

  try {
    await quotesService.submit(payload);
  } catch (error) {
    console.error("Failed to submit quote request:", error);
    redirect("/get-quote?error=submit");
  }

  redirect("/get-quote?success=1");
}

export default async function GetQuotePage({
  searchParams,
}: {
  searchParams: Promise<{ success?: string; error?: string }>;
}) {
  const resolvedSearchParams = await searchParams;
  const showThankYou = resolvedSearchParams?.success === "1";
  const hasError = Boolean(resolvedSearchParams?.error);

  return (
    <>
      <Header />

      <div className="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <QuoteForm
            action={submitQuote}
            showThankYou={showThankYou}
            hasError={hasError}
          />
          <Sidebar />
        </div>
      </div>
    </>
  );
}
