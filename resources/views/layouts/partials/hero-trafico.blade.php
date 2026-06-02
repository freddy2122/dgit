@php
    /** Carrousel local avec images embarquées (pas de hotlink externe) */
    $heroSlides = [
        [
            'image' => 'images/dgt-news-remote-1.jpg',
            'title' => '018: atención a víctimas',
            'subtitle' => 'Un número gratuito de atención a víctimas de siniestros de tráfico, disponible las 24 horas.',
            'cta' => 'Más información',
        ],
        [
            'image' => 'images/dgt-news-remote-2.jpg',
            'title' => 'VMP y vehículos personales ligeros',
            'subtitle' => 'Registro, normas de circulación y trámites para patinetes y otros vehículos de movilidad personal.',
            'cta' => 'Trámites y normativa',
        ],
        [
            'image' => 'images/dgt-news-remote-3.jpg',
            'title' => 'V16 conectada a DGT 3.0',
            'subtitle' => 'La baliza de preseñalización de emergencia conectada: señalización digital y mayor seguridad en carretera.',
            'cta' => 'Tecnología e innovación',
        ],
        [
            'image' => 'images/hero-trafico.png',
            'title' => 'ITS y seguridad vial',
            'subtitle' => 'Sistemas inteligentes de transporte para mejorar la seguridad en carretera.',
            'cta' => 'Sede electrónica',
        ],
    ];
@endphp

@once
    @push('head')
        <style>
            .hero-slide-panel { min-height: var(--hero-min-h, 420px); }
            .hero-slide-media {
                position: absolute;
                inset: 0;
                width: 100%;
                height: 100%;
                object-fit: cover;
            }
            .hero-slide-overlay {
                position: absolute;
                inset: 0;
                background: linear-gradient(180deg, rgba(7, 24, 46, 0.3) 0%, rgba(7, 24, 46, 0.75) 100%);
            }
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
                @php
                    $img = (string) ($slide['image'] ?? '');
                    $fallback = 'images/hero-trafico.png';
                    $resolvedImage = ($img !== '' && file_exists(public_path($img))) ? $img : $fallback;
                @endphp
                <div class="swiper-slide">
                    <div class="hero-slide-panel relative flex flex-col justify-end px-6 pb-16 pt-24 sm:px-10 lg:px-16">
                        <img
                            src="{{ asset($resolvedImage) }}"
                            alt=""
                            class="hero-slide-media"
                            loading="lazy"
                            width="1600"
                            height="640"
                            aria-hidden="true"
                        />
                        <span class="hero-slide-overlay" aria-hidden="true"></span>
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
