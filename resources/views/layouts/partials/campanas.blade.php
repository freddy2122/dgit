@php
    $bloque = config('dgt_campanas', ['ver_mas_url' => '#', 'campanas' => []]);
@endphp

<section class="border-y border-gray-200 bg-white py-10 sm:py-12 md:py-14" aria-labelledby="campanas-titulo">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end sm:gap-6">
            <h2 id="campanas-titulo" class="text-xl font-bold uppercase tracking-tight text-[#004481] sm:text-2xl">
                Campañas
            </h2>
            @php $_vc = $bloque['ver_mas_url'] ?? '#'; @endphp
            <a
                href="{{ dgt_href($_vc) }}"
                @if (dgt_is_external($_vc)) target="_blank" rel="noopener noreferrer" @endif
                class="inline-flex shrink-0 items-center gap-1 text-sm font-medium text-[#004481] underline-offset-2 hover:underline sm:text-base"
            >
                Accede a campañas
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8">
            @foreach ($bloque['campanas'] ?? [] as $item)
                <article class="overflow-hidden bg-white shadow-md ring-1 ring-gray-100 transition hover:shadow-lg hover:ring-[#004481]/20">
                    @php $_ca = $item['url'] ?? '#'; @endphp
                    <a
                        href="{{ dgt_href($_ca) }}"
                        @if (dgt_is_external($_ca)) target="_blank" rel="noopener noreferrer" @endif
                        class="group flex flex-col focus:outline-none focus-visible:ring-2 focus-visible:ring-[#004481] focus-visible:ring-offset-2"
                    >
                        <div class="relative aspect-[4/5] w-full overflow-hidden bg-gray-900 sm:aspect-[3/4]">
                            <img
                                src="{{ $item['imagen'] }}"
                                alt="{{ $item['imagen_alt'] ?? $item['titulo'] }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                                width="500"
                                height="650"
                                loading="lazy"
                                decoding="async"
                            />
                        </div>
                        <div class="border-t border-gray-800 bg-gray-800 px-4 py-3 sm:py-4">
                            <p class="text-sm font-medium leading-snug text-white sm:text-base">
                                {{ $item['titulo'] }}
                            </p>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
