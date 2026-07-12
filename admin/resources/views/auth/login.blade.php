<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login — Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: { DEFAULT: '#00A1E0', dark: '#c9e000' },
                    },
                    fontFamily: {
                        display: ['ui-monospace', 'SFMono-Regular', 'monospace'],
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
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-full dark">

<div class="flex h-screen bg-gray-950 text-gray-100">
    <div class="flex flex-1 flex-col justify-center px-4 py-12 sm:px-6 lg:flex-none lg:px-20 xl:px-24">
        <div class="mx-auto w-full max-w-sm lg:w-96">
            <div>
                <h2 class="mt-8 text-3xl font-bold tracking-tight text-brand">Sign in to your account</h2>
            </div>

            <div class="mt-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-300">
                            Email address
                        </label>
                        <div class="mt-2">
                            <input
                                type="email"
                                name="email"
                                id="email"
                                value="{{ old('email') }}"
                                required
                                class="block w-full appearance-none rounded-lg border border-gray-700 bg-gray-900 px-4 py-2 text-gray-100 placeholder-gray-500 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand sm:text-sm"
                                placeholder="you@example.com"
                            >
                            @error('email')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-300">
                            Password
                        </label>
                        <div class="mt-2">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                required
                                class="block w-full appearance-none rounded-lg border border-gray-700 bg-gray-900 px-4 py-2 text-gray-100 placeholder-gray-500 focus:border-brand focus:outline-none focus:ring-1 focus:ring-brand sm:text-sm"
                                placeholder="••••••••"
                            >
                            @error('password')
                                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input
                                type="checkbox"
                                name="remember"
                                id="remember"
                                class="h-4 w-4 rounded border-gray-700 bg-gray-900 text-brand focus:ring-brand"
                            >
                            <label for="remember" class="ml-2 block text-sm text-gray-400">
                                Remember me
                            </label>
                        </div>
                    </div>

                    <button
                        type="submit"
                        class="flex w-full justify-center rounded-lg bg-brand px-4 py-2 text-sm font-semibold text-gray-50 hover:bg-brand-dark focus:outline-none focus:ring-2 focus:ring-brand focus:ring-offset-2 focus:ring-offset-gray-950 transition-colors"
                    >
                        Sign in
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="relative hidden w-0 flex-1 lg:block">
        <div class="absolute inset-0 h-full w-full bg-gradient-to-br from-brand/10 via-gray-900 to-gray-950"></div>
        <div class="relative flex h-full flex-col justify-center px-12 py-12">
            <h1 class="text-4xl font-bold text-brand">AbitaDash Admin</h1>
            <p class="mt-4 text-lg text-gray-400">Manage your products, categories, and quotations</p>
        </div>
    </div>
</div>

</body>
</html>
