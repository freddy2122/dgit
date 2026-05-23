@php
    $b = config('dgt_conocimiento_investigacion', [
        'titulo' => 'Conocimiento e investigación',
        'texto' => '',
        'boton' => 'Accede a las publicaciones',
        'url' => '#',
        'icono' => '',
    ]);
@endphp

<section class="border-t border-gray-200 bg-[#e6ebf0] py-10 sm:py-12 md:py-14" aria-labelledby="conocimiento-investigacion-titulo">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2
            id="conocimiento-investigacion-titulo"
            class="mb-8 text-xl font-bold uppercase tracking-tight text-[#004481] sm:mb-10 sm:text-2xl"
        >
            {{ $b['titulo'] }}
        </h2>

        <div class="flex flex-col gap-8 md:flex-row md:items-center md:gap-10 lg:gap-14">
            <div class="flex shrink-0 justify-center md:w-[280px] lg:w-[320px]">
                @if (! empty($b['icono']))
                    <img
                        src="{{ $b['icono'] }}"
                        alt=""
                        class="h-auto w-full max-w-[220px] object-contain md:max-w-none"
                        width="280"
                        height="200"
                        loading="lazy"
                        decoding="async"
                    />
                @endif
            </div>
            <div class="min-w-0 flex-1">
                <p class="text-base leading-relaxed text-gray-800 sm:text-lg">
                    {{ $b['texto'] }}
                </p>
                <div class="mt-6 sm:mt-8">
                    @php $_co = $b['url'] ?? '#'; @endphp
                    <a
                        href="{{ dgt_href($_co) }}"
                        @if (dgt_is_external($_co)) target="_blank" rel="noopener noreferrer" @endif
                        class="inline-block bg-[#004481] px-6 py-3 text-sm font-semibold text-white shadow transition hover:bg-[#003366] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#004481] focus-visible:ring-offset-2 sm:px-8 sm:text-base"
                    >
                        {{ $b['boton'] }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
