<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sede Electrónica')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        dgt: {
                            DEFAULT: '#004481',
                            blue: '#004481',
                        },
                    },
                },
            },
        };
    </script>
    {{-- Swiper : utilisé par le hero carrousel (chargé ici car @push depuis le contenu arrive trop tard pour <head>) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <style>
        .hero-swiper { --hero-min-h: 420px; min-height: var(--hero-min-h); position: relative; z-index: 0; }
        @media (min-width: 768px) { .hero-swiper { --hero-min-h: 500px; } }
        @media (min-width: 1024px) { .hero-swiper { --hero-min-h: 560px; } }
        .hero-swiper .swiper-slide { min-height: var(--hero-min-h); }
        .hero-swiper .swiper-pagination { bottom: 1.5rem !important; }
        .hero-swiper .swiper-pagination-bullet {
            width: 0.625rem; height: 0.625rem; margin: 0 0.35rem !important;
            background: transparent; border: 2px solid #fff; opacity: 1;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.15);
        }
        .hero-swiper .swiper-pagination-bullet-active { background: #fff; border-color: #fff; }
        .hero-swiper .swiper-button-prev,
        .hero-swiper .swiper-button-next {
            color: #fff; width: 2.75rem; height: 2.75rem; margin-top: 0; top: 50%; transform: translateY(-50%);
            border-radius: 9999px; background: rgba(255, 255, 255, 0.12); backdrop-filter: blur(4px);
        }
        .hero-swiper .swiper-button-prev:after,
        .hero-swiper .swiper-button-next:after { font-size: 1rem; font-weight: 700; }
        .hero-swiper .swiper-button-prev:hover,
        .hero-swiper .swiper-button-next:hover { background: rgba(255, 255, 255, 0.22); }
        @media (max-width: 767px) {
            .hero-swiper .swiper-button-prev,
            .hero-swiper .swiper-button-next { display: none; }
        }
    </style>
    @stack('head')
</head>
<body class="flex min-h-screen flex-col bg-white font-sans text-gray-900 antialiased">
    @include('layouts.partials.header')

    <main class="relative z-0 flex-1">
        @if (session('status'))
            <div class="border-b border-sky-100 bg-sky-50 px-4 py-3 text-center text-sm text-[#004481]" role="status">
                {{ session('status') }}
            </div>
        @endif
        @yield('content')
    </main>

    @include('layouts.partials.footer')
    @stack('scripts')
</body>
</html>
