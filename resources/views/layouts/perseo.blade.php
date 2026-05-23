<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', __('status.title'))</title>
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
    <style>
        .perseo-grid {
            background-color: #e8eef5;
            background-image:
                linear-gradient(rgba(255,255,255,0.35) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.35) 1px, transparent 1px);
            background-size: 18px 18px;
        }
        @keyframes portal-spin {
            to { transform: rotate(360deg); }
        }
        .portal-spinner {
            animation: portal-spin 0.9s linear infinite;
        }
    </style>
    @stack('head')
</head>
<body class="perseo-grid flex min-h-screen flex-col font-sans text-gray-900 antialiased">
    <div class="flex-1">
        @yield('content')
    </div>
    @include('portal.partials.public-footer-locale')
    @stack('scripts')
</body>
</html>
