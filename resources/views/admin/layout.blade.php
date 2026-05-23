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
        <aside class="hidden w-64 shrink-0 flex-col bg-[#003366] text-white lg:flex">
            <div class="border-b border-white/10 px-5 py-5">
                <p class="text-xs font-semibold uppercase tracking-widest text-sky-200/80">DGT</p>
                <p class="text-lg font-bold">{{ __('admin.title') }}</p>
                <p class="mt-1 text-xs text-sky-100/70">{{ auth()->user()->email }}</p>
            </div>
            <nav class="flex-1 space-y-0.5 p-3 text-sm">
                @foreach ([
                    ['admin.dashboard', __('admin.nav.dashboard')],
                    ['admin.users.index', __('admin.nav.users')],
                    ['admin.permits.index', __('admin.nav.permits')],
                    ['admin.applications.index', __('admin.nav.applications')],
                    ['admin.vehicles.index', __('admin.nav.vehicles')],
                    ['admin.payments.index', __('admin.nav.payments')],
                    ['admin.documents.index', __('admin.nav.documents')],
                    ['admin.appointments.index', __('admin.nav.appointments')],
                    ['admin.logs.index', __('admin.nav.logs')],
                    ['admin.settings.index', __('admin.nav.settings')],
                ] as [$route, $label])
                    <a href="{{ route($route) }}" class="block rounded-lg px-3 py-2.5 font-medium transition {{ request()->routeIs($route.'*') || request()->routeIs($route) ? 'bg-white/15 text-white' : 'text-sky-100/90 hover:bg-white/10' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </nav>
            <div class="border-t border-white/10 p-4 text-xs text-sky-100/80">
                <a href="{{ portal_route('dashboard') }}" class="font-semibold hover:text-white">{{ __('admin.back_portal') }}</a>
            </div>
        </aside>

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="border-b border-gray-200 bg-white px-4 py-4 shadow-sm lg:px-8">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <h1 class="text-xl font-bold text-[#003366]">@yield('page_title', __('admin.nav.dashboard'))</h1>
                    <p class="text-xs text-amber-800 rounded-lg bg-amber-50 border border-amber-200 px-3 py-1.5 max-w-xl">{{ __('admin.dgt_note') }}</p>
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
    @stack('scripts')
</body>
</html>
