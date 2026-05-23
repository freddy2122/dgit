@once
    @push('head')
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=ocr-a:400|seaweed-script:400&display=swap" rel="stylesheet">
    @endpush
    @push('styles')
        <style>
            /* Champs machine (numéros, dates normalisées) — style OCR-B / OCR-A */
            .license-ocr {
                font-family: 'OCR A', 'OCR B', 'OCR-A', 'OCR-B', 'OCR A Extended', 'Lucida Console', 'Courier New', monospace;
                font-variant-numeric: tabular-nums;
                letter-spacing: 0.04em;
            }
            /* Texte administratif — Helvetica / Arial, capitales */
            .license-admin {
                font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
            }
        </style>
    @endpush
@endonce
