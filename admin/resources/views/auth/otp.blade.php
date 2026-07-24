<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex,nofollow,noarchive,nosnippet">
    <title>Verify your identity — {{ config('app.name') }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#00A1E0', dark: '#c9e000' },
                    },
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=Syne:wght@700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Syne', sans-serif; }
    </style>
</head>
<body class="h-full dark">

<div class="flex h-screen items-center justify-center bg-gray-950 text-gray-100 px-4">
    <div class="mx-auto w-full max-w-sm">
        <h2 class="text-3xl font-bold tracking-tight text-brand">Check your email</h2>
        <p class="mt-2 text-sm text-gray-400">
            We sent a 6-digit verification code to your email address. Enter it below to finish signing in — it expires in 10 minutes.
        </p>

        <form method="POST" action="{{ route('otp.verify') }}" class="mt-8 space-y-6">
            @csrf

            <div>
                <label for="code" class="block text-sm font-medium text-gray-300">Verification code</label>
                <div class="mt-2">
                    <input
                        type="text"
                        inputmode="numeric"
                        pattern="[0-9]*"
                        maxlength="6"
                        name="code"
                        id="code"
                        required
                        autofocus
                        class="block w-full appearance-none rounded-lg border border-gray-700 bg-gray-900 px-4 py-3 text-center text-2xl tracking-[0.5em] text-gray-100 placeholder-gray-600 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand"
                        placeholder="000000"
                    >
                    @error('code')
                        <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button
                type="submit"
                class="flex w-full justify-center rounded-lg bg-brand px-4 py-2 text-sm font-semibold text-gray-50 hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 focus:ring-offset-gray-950 transition-colors"
            >
                Verify and sign in
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-500">
            <a href="{{ route('login') }}" class="text-brand hover:underline">Start over</a>
        </p>
    </div>
</div>

</body>
</html>
