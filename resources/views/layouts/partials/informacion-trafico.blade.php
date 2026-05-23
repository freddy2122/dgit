@php
    $bloque = config('dgt_informacion_trafico', ['tarjetas' => []]);
@endphp

<section class="border-t border-gray-200 bg-white py-10 sm:py-12 md:py-14" aria-labelledby="informacion-trafico-titulo">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <h2 id="informacion-trafico-titulo" class="mb-8 text-xl font-bold uppercase tracking-tight text-[#004481] sm:mb-10 sm:text-2xl">
            Información de tráfico
        </h2>

        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4 lg:gap-8">
            @foreach ($bloque['tarjetas'] ?? [] as $item)
                <article class="flex h-full flex-col overflow-hidden rounded-lg bg-white shadow-md ring-1 ring-gray-100 transition hover:shadow-lg hover:ring-[#004481]/20">
                    @php $_iu = $item['url'] ?? '#'; @endphp
                    <a
                        href="{{ dgt_href($_iu) }}"
                        @if (dgt_is_external($_iu)) target="_blank" rel="noopener noreferrer" @endif
                        class="group flex h-full flex-col focus:outline-none focus-visible:ring-2 focus-visible:ring-[#004481] focus-visible:ring-offset-2"
                    >
                        <div class="relative aspect-[255/240] w-full shrink-0 overflow-hidden bg-gray-100">
                            <img
                                src="{{ $item['imagen'] }}"
                                alt="{{ $item['titulo'] }}"
                                class="h-full w-full object-cover object-top transition duration-300 group-hover:scale-[1.03]"
                                width="255"
                                height="240"
                                loading="lazy"
                                decoding="async"
                            />
                        </div>
                        <div class="flex flex-1 flex-col p-4 sm:p-5">
                            <h3 class="text-base font-bold leading-snug text-gray-900 group-hover:text-[#004481] sm:text-lg">
                                {{ $item['titulo'] }}
                            </h3>
                            <p class="mt-3 text-sm leading-relaxed text-gray-600">
                                {{ $item['descripcion'] }}
                            </p>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
