@php
    $bloque = config('dgt_agenda', ['ver_mas_url' => '#', 'eventos' => []]);
@endphp

<section class="border-t-4 border-[#004481] bg-[#e6ebf0] py-10 sm:py-12 md:py-14" aria-labelledby="agenda-titulo">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col justify-between gap-4 sm:flex-row sm:items-end sm:gap-6">
            <h2 id="agenda-titulo" class="text-xl font-bold uppercase tracking-tight text-[#004481] sm:text-2xl">
                Agenda
            </h2>
            @php $_va = $bloque['ver_mas_url'] ?? '#'; @endphp
            <a
                href="{{ dgt_href($_va) }}"
                @if (dgt_is_external($_va)) target="_blank" rel="noopener noreferrer" @endif
                class="inline-flex shrink-0 items-center gap-1 text-sm font-medium text-[#004481] underline-offset-2 hover:underline sm:text-base"
            >
                Accede a la agenda
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="grid gap-6 md:grid-cols-2 md:gap-8">
            @foreach ($bloque['eventos'] ?? [] as $item)
                <article
                    class="overflow-hidden border border-gray-200 bg-white shadow-sm transition hover:shadow-md"
                >
                    @php $_eu = $item['url'] ?? '#'; @endphp
                    <a
                        href="{{ dgt_href($_eu) }}"
                        @if (dgt_is_external($_eu)) target="_blank" rel="noopener noreferrer" @endif
                        class="group flex min-h-[140px] flex-col focus:outline-none focus-visible:ring-2 focus-visible:ring-inset focus-visible:ring-[#004481] sm:min-h-[160px] sm:flex-row"
                    >
                        <div class="relative h-44 w-full shrink-0 bg-gray-100 sm:h-auto sm:w-2/5 sm:max-w-[240px]">
                            <img
                                src="{{ $item['imagen'] }}"
                                alt="{{ $item['titulo'] }}"
                                class="h-full w-full object-cover transition duration-300 group-hover:scale-[1.02] sm:min-h-full"
                                width="400"
                                height="280"
                                loading="lazy"
                                decoding="async"
                            />
                        </div>
                        <div class="flex flex-1 flex-col justify-center p-4 sm:p-5">
                            <h3 class="text-sm font-bold leading-snug text-[#004481] group-hover:underline sm:text-base">
                                {{ $item['titulo'] }}
                            </h3>
                            <p class="mt-2 text-xs text-gray-600 sm:text-sm">
                                {{ $item['fecha'] }}
                            </p>
                        </div>
                    </a>
                </article>
            @endforeach
        </div>
    </div>
</section>
