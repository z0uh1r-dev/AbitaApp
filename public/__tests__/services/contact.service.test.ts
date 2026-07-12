const postMock = jest.fn();

jest.mock("../../services/api.service", () => ({
  apiService: {
    post: (...args: unknown[]) => postMock(...args),
  },
}));

describe("contactService", () => {
  const payload = {
    fullName: "John Doe",
    companyName: "Acme Corp",
    email: "john@acme.com",
    phone: "+33 1 23 45 67 89",
    message: "Hello from contact form",
  };

  beforeEach(() => {
    jest.resetModules();
    postMock.mockReset();
    delete process.env.NEXT_PUBLIC_CONTACT_API_ENDPOINT;
  });

  it("uses /contact-messages by default", async () => {
    const { contactService } = await import("../../services/contact.service");

    await contactService.submit(payload);

    expect(postMock).toHaveBeenCalledWith("/contact-messages", payload, {
      cache: "no-store",
    });
  });

  it("normalizes api/v1/contact-messages to /contact-messages", async () => {
    process.env.NEXT_PUBLIC_CONTACT_API_ENDPOINT = "api/v1/contact-messages";

    const { contactService } = await import("../../services/contact.service");

    await contactService.submit(payload);

    expect(postMock).toHaveBeenCalledWith("/contact-messages", payload, {
      cache: "no-store",
    });
  });

  it("uses absolute endpoint via fetch", async () => {
    process.env.NEXT_PUBLIC_CONTACT_API_ENDPOINT =
      "http://localhost:8000/api/v1/contact-messages";

    const originalFetch = globalThis.fetch;
    const fetchMock = jest.fn().mockResolvedValue({
      ok: true,
      json: async () => ({ message: "ok" }),
    } as Response);
    Object.assign(globalThis, { fetch: fetchMock });

    const { contactService } = await import("../../services/contact.service");

    await contactService.submit(payload);

    expect(fetchMock).toHaveBeenCalledWith(
      "http://localhost:8000/api/v1/contact-messages",
      expect.objectContaining({
        method: "POST",
        cache: "no-store",
      })
    );
    expect(postMock).not.toHaveBeenCalled();

    if (originalFetch) {
      Object.assign(globalThis, { fetch: originalFetch });
    } else {
      // @ts-expect-error removing test-only fetch shim
      delete globalThis.fetch;
    }
  });
});
