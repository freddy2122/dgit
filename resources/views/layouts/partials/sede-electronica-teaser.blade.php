{{-- Bloque promocional Sede Electrónica (después del hero, estilo dgt.es) --}}
<section class="relative overflow-hidden bg-[#eeeeee] py-10 sm:py-12 md:py-14" aria-labelledby="sede-electronica-teaser-titulo">
    {{-- Pestaña lateral (acceso rápido tipo miDGT / usuarios) --}}
    @auth
        <a
            href="{{ portal_route('dashboard') }}"
            class="absolute right-0 top-1/2 z-10 hidden -translate-y-1/2 flex-col items-center gap-1 rounded-l-lg bg-[#f28c00] px-1.5 py-3 text-white shadow-md transition hover:bg-[#e07d00] md:flex"
            title="{{ __('portal.header.midgt_space') }}"
            aria-label="{{ __('portal.header.midgt_space') }}"
        >
    @else
        <a
            href="{{ midgt_acceso_href() }}"
            class="absolute right-0 top-1/2 z-10 hidden -translate-y-1/2 flex-col items-center gap-1 rounded-l-lg bg-[#f28c00] px-1.5 py-3 text-white shadow-md transition hover:bg-[#e07d00] md:flex"
            title="{{ __('portal.header.midgt_access') }}"
            aria-label="{{ __('portal.header.midgt_access') }}"
        >
    @endauth
        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
        </svg>
    </a>

    <div class="mx-auto grid max-w-7xl items-center gap-8 px-4 sm:px-6 md:grid-cols-2 md:gap-10 lg:px-8">
        <div class="flex justify-center md:justify-start">
            <img
                src="{{ asset('images/sede-electronica-promo.png') }}"
                alt="{{ __('site.sede_teaser.image_alt') }}"
                class="h-auto w-full max-w-md object-contain"
                width="520"
                height="320"
                loading="lazy"
                decoding="async"
            />
        </div>
        <div class="max-w-xl md:pr-10">
            <h2 id="sede-electronica-teaser-titulo" class="text-xl font-bold uppercase leading-snug tracking-tight text-gray-900 sm:text-2xl">
                {{ __('site.sede_teaser.title') }}
            </h2>
            <p class="mt-4 text-base leading-relaxed text-gray-700">
                {{ __('site.sede_teaser.p1') }}
            </p>
            <p class="mt-3 text-base leading-relaxed text-gray-700">
                {{ __('site.sede_teaser.p2') }}
            </p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
                @auth
                    <a
                        href="{{ portal_route('dashboard') }}"
                        class="inline-flex min-h-[48px] items-center justify-center bg-[#004481] px-6 py-3 text-sm font-bold text-white shadow transition hover:bg-[#003366] focus:outline-none focus:ring-2 focus:ring-[#004481] focus:ring-offset-2 sm:px-8 sm:text-base"
                    >
                        {{ __('portal.header.midgt_space') }}
                    </a>
                @else
                    @guest
                        <a
                            href="{{ route('portal.inscription') }}"
                            class="inline-flex min-h-[48px] items-center justify-center bg-[#f28c00] px-6 py-3 text-sm font-bold text-white shadow transition hover:bg-[#e07d00] focus:outline-none focus:ring-2 focus:ring-[#f28c00] focus:ring-offset-2 sm:px-8 sm:text-base"
                        >
                            {{ __('site.sede_teaser.create_account') }}
                        </a>
                    @endguest
                    <a
                        href="{{ clave_plataforma_href() }}"
                        class="inline-flex min-h-[48px] items-center justify-center bg-[#004481] px-6 py-3 text-sm font-bold text-white shadow transition hover:bg-[#003366] focus:outline-none focus:ring-2 focus:ring-[#004481] focus:ring-offset-2 sm:px-8 sm:text-base"
                    >
                        {{ __('site.sede_teaser.clave_register') }}
                    </a>
                    <a
                        href="{{ sede_href('es') }}"
                        class="inline-flex min-h-[48px] items-center justify-center border-2 border-[#004481] bg-white px-6 py-3 text-sm font-semibold text-[#004481] transition hover:bg-gray-50 sm:px-8 sm:text-base"
                    >
                        {{ __('site.sede_teaser.access_sede') }}
                    </a>
                @endauth
            </div>
        </div>
    </div>
</section>
