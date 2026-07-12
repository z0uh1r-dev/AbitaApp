import { NextResponse } from "next/server";

interface ClientErrorPayload {
  message: string;
  stack?: string;
  source?: string;
  componentStack?: string;
  url?: string;
  userAgent?: string;
  timestamp?: string;
  extra?: Record<string, unknown>;
}

function isValidPayload(payload: unknown): payload is ClientErrorPayload {
  if (!payload || typeof payload !== "object") {
    return false;
  }

  const candidate = payload as Partial<ClientErrorPayload>;
  return typeof candidate.message === "string" && candidate.message.length > 0;
}

export async function POST(request: Request) {
  try {
    const payload = (await request.json()) as unknown;

    if (!isValidPayload(payload)) {
      return NextResponse.json(
        { ok: false, error: "Invalid payload" },
        { status: 400 }
      );
    }

    console.error("Client runtime error reported:", {
      message: payload.message,
      source: payload.source,
      url: payload.url,
      timestamp: payload.timestamp,
      componentStack: payload.componentStack,
      stack: payload.stack,
      userAgent: payload.userAgent,
      extra: payload.extra,
    });

    return NextResponse.json({ ok: true }, { status: 200 });
  } catch {
    return NextResponse.json(
      { ok: false, error: "Failed to process request" },
      { status: 400 }
    );
  }
}
