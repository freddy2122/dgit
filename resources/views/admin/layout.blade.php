<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('admin.title')) — DGT</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-slate-100 font-sans text-gray-900 antialiased">
    <div class="flex min-h-screen">
        @include('admin.partials.sidebar')

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-20 border-b border-gray-200 bg-white px-4 py-3 shadow-sm lg:px-8 lg:py-4">
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex min-w-0 flex-1 items-center gap-3">
                        @include('partials.mobile-nav-toggle', ['id' => 'admin-nav', 'label' => __('admin.nav.menu')])
                        <h1 class="min-w-0 truncate text-lg font-bold text-[#003366] sm:text-xl">@yield('page_title', __('admin.nav.dashboard'))</h1>
                    </div>
                    <p class="w-full text-xs text-amber-800 rounded-lg bg-amber-50 border border-amber-200 px-3 py-1.5 lg:max-w-xl lg:w-auto">{{ __('admin.dgt_note') }}</p>
                </div>
            </header>
            <main class="flex-1 p-4 lg:p-8">
                @if (session('status'))
                    <p class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('status') }}</p>
                @endif
                @yield('content')
            </main>
        </div>
    </div>

    @include('admin.partials.mobile-nav-drawer')
    @include('partials.mobile-drawer-script', ['id' => 'admin-nav'])

    <script src="{{ asset('js/date-field.js') }}" defer></script>
    @stack('scripts')
</body>
</html>
