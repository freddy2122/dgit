{{-- Barra « Consulta la actualidad del tráfico » (liens internes uniquement) --}}
<section
    class="bg-[#004481] px-4 py-4 text-white sm:px-6 lg:px-10"
    aria-labelledby="boletin-trafico-titulo"
>
    <div class="mx-auto flex max-w-[1920px] flex-col items-stretch gap-4 sm:flex-row sm:items-center sm:justify-between sm:gap-6">
        <div class="flex items-center gap-3 sm:gap-4">
            <span class="inline-flex shrink-0 text-[#fdb913]" aria-hidden="true">
                <svg class="h-8 w-8 sm:h-9 sm:w-9" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 11 18-5v12L3 14v-3z" />
                    <path d="M11.6 16.8a3 3 0 1 1-5.8-1.6" />
                </svg>
            </span>
            <h2 id="boletin-trafico-titulo" class="text-base font-bold leading-snug sm:text-lg">
                Consulta la actualidad del tráfico
            </h2>
        </div>

        <div class="flex shrink-0 items-center sm:justify-end">
            <a
                href="{{ portal_route('sede.hub') }}"
                class="flex w-full items-center gap-3 rounded-full bg-[#002654] py-2.5 pl-2 pr-4 text-left shadow-sm transition hover:bg-[#001f45] sm:w-auto sm:pr-5"
            >
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-white text-[#004481] shadow-inner" aria-hidden="true">
                    <svg class="h-4 w-4 translate-x-0.5" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z" /></svg>
                </span>
                <span class="text-xs font-semibold uppercase tracking-wide text-white sm:text-sm">
                    Sede electrónica
                </span>
            </a>
        </div>
    </div>
</section>
