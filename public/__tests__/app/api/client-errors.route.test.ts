/** @jest-environment node */

import { POST } from "@/app/api/client-errors/route";

describe("client-errors API route", () => {
  it("returns 400 for invalid payload", async () => {
    const request = new Request("http://localhost/api/client-errors", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ source: "ErrorBoundary" }),
    });

    const response = await POST(request);
    const data = await response.json();

    expect(response.status).toBe(400);
    expect(data).toEqual({ ok: false, error: "Invalid payload" });
  });

  it("returns 200 for valid payload", async () => {
    const consoleErrorSpy = jest
      .spyOn(console, "error")
      .mockImplementation(() => undefined);

    const request = new Request("http://localhost/api/client-errors", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        message: "Boom",
        source: "ErrorBoundary",
        timestamp: new Date().toISOString(),
      }),
    });

    const response = await POST(request);
    const data = await response.json();

    expect(response.status).toBe(200);
    expect(data).toEqual({ ok: true });
    expect(consoleErrorSpy).toHaveBeenCalledWith(
      "Client runtime error reported:",
      expect.objectContaining({
        message: "Boom",
        source: "ErrorBoundary",
      })
    );

    consoleErrorSpy.mockRestore();
  });
});
