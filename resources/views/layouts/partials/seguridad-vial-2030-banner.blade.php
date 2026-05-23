{{-- Banda Seguridad Vial 2030 (tras « Te puede interesar », estilo dgt.es/inicio) --}}
<section class="relative overflow-hidden bg-[#e6ebf0]" aria-labelledby="seguridad-vial-2030-titulo">
    <div class="mx-auto flex min-h-[280px] max-w-[1920px] flex-col md:min-h-[320px] md:flex-row">
        {{-- Panel izquierdo: fondo azul + corte diagonal (solo md+) --}}
        <div
            class="relative z-10 flex w-full flex-col justify-center bg-[#0a3d6b] px-6 py-10 text-white md:w-[56%] md:max-w-none md:shrink-0 md:px-10 md:py-14 lg:px-14 md:[clip-path:polygon(0_0,100%_0,82%_100%,0_100%)]"
        >
            <h2 id="seguridad-vial-2030-titulo" class="text-2xl font-bold leading-tight sm:text-3xl md:text-4xl">
                Seguridad Vial 2030
            </h2>
            <p class="mt-4 max-w-xl text-sm leading-relaxed text-white/95 sm:text-base">
                ¿Quieres saber más información sobre políticas y estrategias de seguridad vial?
            </p>
            <p class="mt-2 max-w-xl text-sm leading-relaxed text-white/95 sm:text-base">
                Accede a la web de Seguridad Vial 2030 e infórmate de todo.
            </p>
            <div class="mt-8">
                <a
                    href="{{ portal_route('sede.hub') }}"
                    class="inline-block bg-white px-6 py-3 text-sm font-semibold text-[#0a3d6b] shadow transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-[#0a3d6b] sm:px-8 sm:text-base"
                >
                    Accede a Seguridad Vial 2030
                </a>
            </div>
        </div>

        {{-- Panel derecho: fondo gris-azulado + logo corazón --}}
        <div class="flex flex-1 flex-col items-center justify-center px-6 py-10 md:-ml-8 md:py-14 md:pl-4 lg:-ml-12 lg:pl-8">
            <div class="drop-shadow-sm" aria-hidden="true">
                <svg class="h-28 w-28 text-[#004481] sm:h-32 sm:w-32" viewBox="0 0 64 64" fill="currentColor">
                    <path d="M32 8c-8 0-14 6-14 14 0 10 14 26 14 26s14-16 14-26c0-8-6-14-14-14zm0 20a6 6 0 1 1 0-12 6 6 0 0 1 0 12z"/>
                </svg>
            </div>
            <p class="mt-5 text-center text-[0.65rem] font-bold uppercase tracking-[0.35em] text-[#004481] sm:text-xs md:tracking-[0.4em]">
                SEGURIDAD VIAL 2030
            </p>
        </div>
    </div>
</section>
