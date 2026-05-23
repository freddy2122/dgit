@php
    $bloque = config('dgt_te_puede_interesar', ['ver_mas_url' => '#', 'articulos' => []]);
@endphp

<section class="border-t border-gray-200 bg-white py-10 sm:py-12 md:py-14" aria-labelledby="te-puede-interesar-titulo">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end sm:gap-6">
            <h2 id="te-puede-interesar-titulo" class="text-xl font-bold uppercase tracking-tight text-[#004481] sm:text-2xl">
                Te puede interesar
            </h2>
            @php $_vm = $bloque['ver_mas_url'] ?? '#'; @endphp
            <a
                href="{{ dgt_href($_vm) }}"
                @if (dgt_is_external($_vm)) target="_blank" rel="noopener noreferrer" @endif
                class="inline-flex shrink-0 items-center gap-1 text-sm font-medium text-[#004481] underline-offset-2 hover:underline sm:text-base"
            >
                Accede a más información de interés
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8">
            @foreach ($bloque['articulos'] ?? [] as $item)
                <article class="flex h-full flex-col overflow-hidden rounded-lg bg-white shadow-md ring-1 ring-gray-100 transition hover:shadow-lg hover:ring-[#004481]/20">
                    @php $_au = $item['url'] ?? '#'; @endphp
                    <a
                        href="{{ dgt_href($_au) }}"
                        @if (dgt_is_external($_au)) target="_blank" rel="noopener noreferrer" @endif
                        class="group flex h-full flex-col focus:outline-none focus-visible:ring-2 focus-visible:ring-[#004481] focus-visible:ring-offset-2"
                    >
                        <div class="relative aspect-[16/10] w-full shrink-0 overflow-hidden bg-gray-100">
                            <img
                                src="{{ $item['imagen'] }}"
                                alt="{{ $item['titulo'] }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.03]"
                                width="800"
                                height="500"
                                loading="lazy"
                                decoding="async"
                            />
                        </div>
                        <div class="flex flex-1 flex-col p-4 sm:p-5">
                            <h3 class="text-base font-bold leading-snug text-gray-900 group-hover:text-[#004481] sm:text-lg">
                                {{ $item['titulo'] }}
                            </h3>
                            <p class="mt-auto pt-3 text-sm text-gray-500">
                                {{ $item['fecha'] }}
                            </p>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
