<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('portal.brand'))</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                },
            },
        };
    </script>
    @stack('head')
    @stack('styles')
</head>
<body class="min-h-screen bg-slate-100 font-sans text-gray-900 antialiased">
@php
    $portalUser = auth()->user();
    $portalLicense = $portalUser?->licenseSummary;
    $portalDisplayName = trim(collect([$portalUser->first_name ?? '', $portalUser->last_name ?? ''])->filter()->join(' '))
        ?: ($portalUser->name ?? __('portal.user_default'));
    $portalNie = $portalUser->nie ?? '—';
@endphp
    <div class="flex min-h-screen">
        @include('portal.partials.sidebar', ['portalNavActive' => $portalNavActive ?? 'dashboard'])

        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-20 border-b border-gray-200 bg-white px-4 py-3 shadow-sm sm:px-6 lg:px-8">
                <div class="mx-auto flex max-w-7xl items-center justify-between gap-4">
                    <div class="flex min-w-0 items-center gap-3 lg:hidden">
                        <a href="{{ portal_route('home') }}" class="text-lg font-bold text-[#004481]">{{ __('portal.brand') }}</a>
                    </div>
                    @hasSection('page_heading')
                        <div class="hidden min-w-0 flex-1 lg:block">
                            @yield('page_heading')
                        </div>
                    @endif
                    <div class="ml-auto flex shrink-0 items-center gap-3 sm:gap-4">
                        <button type="button" class="relative hidden h-10 w-10 items-center justify-center rounded-full text-gray-500 hover:bg-gray-100 sm:flex" aria-label="{{ __('portal.notifications') }}">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
                            <span class="absolute right-2 top-2 h-2 w-2 rounded-full bg-[#f28c00]" aria-hidden="true"></span>
                        </button>
                        <div class="hidden text-right sm:block">
                            <p class="text-sm font-bold text-gray-900">{{ strtoupper($portalDisplayName) }}</p>
                            <p class="text-xs text-gray-500">{{ $portalNie }}</p>
                        </div>
                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#004481] text-sm font-bold text-white" aria-hidden="true">
                            {{ strtoupper(mb_substr($portalDisplayName, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-7xl">
                    @hasSection('page_heading')
                        <div class="mb-6 lg:hidden">
                            @yield('page_heading')
                        </div>
                    @endif
                    @include('portal.partials.alert')
                    @yield('content')
                </div>
            </main>

            @include('portal.partials.footer-locale')
        </div>
    </div>
    @stack('scripts')
</body>
</html>
