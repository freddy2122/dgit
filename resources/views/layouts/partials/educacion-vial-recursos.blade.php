@php
    $bloque = config('dgt_educacion_vial', ['recursos' => []]);
@endphp

<section
    class="bg-gradient-to-b from-[#004481] to-[#00345f] py-10 text-white sm:py-12 md:py-14"
    aria-labelledby="educacion-vial-recursos-titulo"
>
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2
            id="educacion-vial-recursos-titulo"
            class="mb-8 text-xl font-bold uppercase tracking-tight text-white sm:mb-10 sm:text-2xl"
        >
            Recursos de educación vial
        </h2>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8">
            @foreach ($bloque['recursos'] ?? [] as $item)
                <article class="overflow-hidden rounded-lg bg-white shadow-lg ring-1 ring-white/10 transition hover:ring-white/30">
                    @php $_ed = $item['url'] ?? '#'; @endphp
                    <a
                        href="{{ dgt_href($_ed) }}"
                        @if (dgt_is_external($_ed)) target="_blank" rel="noopener noreferrer" @endif
                        class="group flex flex-col focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-offset-2 focus-visible:ring-offset-[#004481]"
                    >
                        <div class="relative aspect-square w-full overflow-hidden bg-gray-100">
                            <img
                                src="{{ $item['imagen'] }}"
                                alt="{{ $item['titulo'] }}"
                                class="h-full w-full object-cover object-center transition duration-300 group-hover:scale-[1.03]"
                                width="500"
                                height="500"
                                loading="lazy"
                                decoding="async"
                            />
                        </div>
                        <div class="border-t border-gray-100 bg-white px-4 py-3 sm:py-4">
                            <p class="text-center text-sm font-bold text-gray-900 sm:text-base">
                                {{ $item['titulo'] }}
                            </p>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
