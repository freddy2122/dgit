<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'miDGT — Espace personnel')</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Instrument Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'] },
                    colors: { dgt: { DEFAULT: '#004481', blue: '#004481' } },
                },
            },
        };
    </script>
</head>
<body class="min-h-screen bg-[#f0f4f8] font-sans text-gray-900 antialiased">
    @yield('content')
    @stack('scripts')
</body>
</html>
