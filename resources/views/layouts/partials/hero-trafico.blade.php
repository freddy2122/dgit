@php
    /** Carrousel local — pas de chargement d’images depuis dgt.es */
    $heroSlides = [
        [
            'bg' => 'hero-slide-bg-1',
            'title' => '018: atención a víctimas',
            'subtitle' => 'Un número gratuito de atención a víctimas de siniestros de tráfico, disponible las 24 horas.',
            'cta' => 'Más información',
        ],
        [
            'bg' => 'hero-slide-bg-2',
            'title' => 'VMP y vehículos personales ligeros',
            'subtitle' => 'Registro, normas de circulación y trámites para patinetes y otros vehículos de movilidad personal.',
            'cta' => 'Trámites y normativa',
        ],
        [
            'bg' => 'hero-slide-bg-3',
            'title' => 'V16 conectada a DGT 3.0',
            'subtitle' => 'La baliza de preseñalización de emergencia conectada: señalización digital y mayor seguridad en carretera.',
            'cta' => 'Tecnología e innovación',
        ],
        [
            'bg' => 'hero-slide-bg-4',
            'title' => 'ITS y seguridad vial',
            'subtitle' => 'Sistemas inteligentes de transporte para mejorar la seguridad en carretera.',
            'cta' => 'Sede electrónica',
        ],
    ];
@endphp

@once
    @push('head')
        <style>
            .hero-slide-bg-1 { background: linear-gradient(135deg, #0a2540 0%, #004481 45%, #1e5a8a 100%); }
            .hero-slide-bg-2 { background: linear-gradient(135deg, #1a3a52 0%, #2563eb 50%, #0ea5e9 100%); }
            .hero-slide-bg-3 { background: linear-gradient(135deg, #0f172a 0%, #334155 50%, #64748b 100%); }
            .hero-slide-bg-4 { background: linear-gradient(135deg, #134e4a 0%, #0d9488 50%, #14b8a6 100%); }
            .hero-slide-panel { min-height: var(--hero-min-h, 420px); }
        </style>
    @endpush
@endonce

<section class="relative z-0 w-full overflow-hidden bg-[#0a2540]" aria-roledescription="carrusel" aria-labelledby="hero-principal-titulo" aria-label="Destacados">
    <div
        class="swiper hero-swiper w-full"
        id="hero-swiper"
        data-hero-swiper
    >
        <div class="swiper-wrapper">
            @foreach ($heroSlides as $slide)
                <div class="swiper-slide">
                    <div class="hero-slide-panel {{ $slide['bg'] }} relative flex flex-col justify-end px-6 pb-16 pt-24 sm:px-10 lg:px-16">
                        <div class="relative z-10 max-w-2xl text-white">
                            <h2 id="{{ $loop->first ? 'hero-principal-titulo' : '' }}" class="text-2xl font-bold sm:text-3xl lg:text-4xl">{{ $slide['title'] }}</h2>
                            <p class="mt-3 text-sm leading-relaxed text-white/90 sm:text-base">{{ $slide['subtitle'] }}</p>
                            <a
                                href="{{ portal_route('sede.hub') }}"
                                class="mt-6 inline-flex min-h-[44px] items-center rounded-lg bg-[#f28c00] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#e07d00]"
                            >
                                {{ $slide['cta'] }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination hero-swiper-pagination" aria-hidden="true"></div>
        <button type="button" class="swiper-button-prev" aria-label="Diapositiva anterior"></button>
        <button type="button" class="swiper-button-next" aria-label="Diapositiva siguiente"></button>
    </div>
</section>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var el = document.querySelector('[data-hero-swiper]');
            if (!el || typeof Swiper === 'undefined') return;

            new Swiper(el, {
                loop: true,
                autoplay: { delay: 6000, disableOnInteraction: false },
                pagination: {
                    el: el.querySelector('.swiper-pagination'),
                    clickable: true,
                },
                navigation: {
                    nextEl: el.querySelector('.swiper-button-next'),
                    prevEl: el.querySelector('.swiper-button-prev'),
                },
            });
        });
    </script>
@endpush
