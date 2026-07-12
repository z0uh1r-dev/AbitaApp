<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-950">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Admin</title>

    {{-- Tailwind CDN (swap for compiled asset in production) --}}
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
    @stack('styles')
</head>
<body class="h-full dark">

<div class="flex h-screen bg-gray-950 text-gray-100 overflow-hidden">

    {{-- ── Sidebar ──────────────────────────────────────────────────────── --}}
    <aside class="w-64 flex-shrink-0 flex flex-col bg-gray-900 border-r border-gray-800">

        {{-- Logo --}}
        <div class="h-20 flex items-center justify-center border-b border-gray-800">
            <img src="{{ asset('logo.png') }}" alt="AbitaDash Logo" class="h-16 w-auto">
        </div>

        {{-- Nav --}}
        <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">

            @php
                $navItem = function(string $route, string $icon, string $label, string $matchPrefix = '') use (&$navItem) {
                    $active = request()->routeIs($matchPrefix ?: $route);
                    $base   = 'flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors';
                    $cls    = $active
                        ? "$base bg-brand text-gray-50"
                        : "$base text-gray-400 hover:bg-gray-800 hover:text-gray-50";
                    echo "<a href=\"" . route($route) . "\" class=\"{$cls}\">{$icon} {$label}</a>";
                };
            @endphp

            <div class="px-3 mb-2 text-[10px] font-semibold uppercase tracking-widest text-gray-300">Overview</div>
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.dashboard') ? 'bg-brand text-gray-50' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <div class="px-3 mt-5 mb-2 text-[10px] font-semibold uppercase tracking-widest text-gray-300">Catalog</div>
            <a href="{{ route('admin.categories.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.categories.*') ? 'bg-brand text-gray-50' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                Categories
                <span class="ml-auto bg-gray-800 text-gray-400 text-xs px-2 py-0.5 rounded-full">{{ \App\Models\Category::count() }}</span>
            </a>
            <a href="{{ route('admin.products.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.products.*') ? 'bg-brand text-gray-50' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                Products
                <span class="ml-auto bg-gray-800 text-gray-400 text-xs px-2 py-0.5 rounded-full">{{ \App\Models\Product::count() }}</span>
            </a>

            <div class="px-3 mt-5 mb-2 text-[10px] font-semibold uppercase tracking-widest text-gray-300">Requests</div>
            <a href="{{ route('admin.quotes.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.quotes.*') ? 'bg-brand text-gray-50' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Quotes
                <span class="ml-auto bg-gray-800 text-gray-400 text-xs px-2 py-0.5 rounded-full">{{ \App\Models\Quote::count() }}</span>
            </a>
            <a href="{{ route('admin.messages.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-colors
                      {{ request()->routeIs('admin.messages.*') ? 'bg-brand text-gray-50' : 'text-gray-400 hover:bg-gray-800 hover:text-gray-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                Messages
                <span class="ml-auto bg-gray-800 text-gray-400 text-xs px-2 py-0.5 rounded-full">{{ \App\Models\ContactMessage::count() }}</span>
            </a>
        </nav>

        {{-- User --}}
        <div class="border-t border-gray-800 px-4 py-4">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-sm">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-200 truncate">{{ auth()->user()->name ?? 'Admin' }}</p>
                    <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email ?? '' }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-gray-300 transition-colors" title="Sign out">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- ── Main content ─────────────────────────────────────────────────── --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top bar --}}
        <header class="h-16 flex-shrink-0 bg-gray-900 border-b border-gray-800 flex items-center justify-between px-8">
            <h1 class="font-display text-lg font-bold tracking-tight">@yield('title', 'Dashboard')</h1>
            <div class="flex items-center gap-3">
                @yield('header-actions')
            </div>
        </header>

        {{-- Scrollable page body --}}
        <main class="flex-1 overflow-y-auto p-8">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 bg-green-950 border border-green-800 text-green-300 rounded-xl px-4 py-3 text-sm">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 flex items-center gap-3 bg-red-950 border border-red-800 text-red-300 rounded-xl px-4 py-3 text-sm">
                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')
</body>
</html>
