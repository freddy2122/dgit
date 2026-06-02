<footer class="mt-auto bg-[#004481] text-white">
    {{-- Liens du haut --}}
    <div class="border-b border-white/20 px-4 py-4 text-center text-sm">
        <nav class="flex flex-wrap items-center justify-center gap-x-2 gap-y-2 text-xs sm:text-sm" aria-label="{{ __('site.footer.nav_aria') }}">
            @foreach (__('site.footer.top_links') as $i => $label)
                @if ($i > 0)
                    <span class="hidden text-white/50 sm:inline" aria-hidden="true">|</span>
                @endif
                <a href="#" class="whitespace-nowrap hover:underline">{{ $label }}</a>
            @endforeach
        </nav>
        <p class="mt-3">
            <a href="#" class="text-sm font-medium hover:underline">{{ __('site.footer.sitemap') }}</a>
        </p>
    </div>

    {{-- Réseaux sociaux --}}
    <div class="flex justify-center gap-3 border-b border-white/20 px-4 py-5">
        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-md border border-white/40 text-white transition hover:bg-white/10" aria-label="{{ __('site.footer.social_facebook') }}">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 10-11.5 9.95v-7.05H7V12h3.5V9.5c0-3.45 2-5.35 5.2-5.35 1.5 0 3.1.27 3.1.27v3.4h-1.7c-1.7 0-2.2 1.05-2.2 2.13V12h3.75l-.6 3.9h-3.15v7.05A10 10 0 0022 12z"/></svg>
        </a>
        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-md border border-white/40 text-white transition hover:bg-white/10" aria-label="{{ __('site.footer.social_twitter') }}">
            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
        </a>
        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-md border border-white/40 text-white transition hover:bg-white/10" aria-label="{{ __('site.footer.social_youtube') }}">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.5 7.5s-.23-1.66-1-2.38c-.95-1-2-1-2.5-1.12C16.9 3.5 12 3.5 12 3.5h0s-4.9 0-8 .5c-.5.12-1.55.12-2.5 1.12-.77.72-1 2.38-1 2.38S0 9.45 0 11.25v1.5c0 1.8.5 5.75.5 5.75s.23 1.66 1 2.38c.95 1 2.2.97 2.75 1.08 2 .2 8.5.5 8.5.5s4.9-.01 8-.5c.5-.12 1.55-.12 2.5-1.12.77-.72 1-2.38 1-2.38s.5-3.95.5-5.75v-1.5c0-1.8-.5-5.75-.5-5.75zM9.75 15.02V8.98L15.5 12l-5.75 3.02z"/></svg>
        </a>
        <a href="#" class="flex h-10 w-10 items-center justify-center rounded-md border border-white/40 text-white transition hover:bg-white/10" aria-label="{{ __('site.footer.social_instagram') }}">
            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.16c3.2 0 3.58.01 4.85.07 3.25.15 4.77 1.69 4.92 4.92.06 1.27.07 1.65.07 4.85s-.01 3.58-.07 4.85c-.15 3.23-1.66 4.77-4.92 4.92-1.27.06-1.65.07-4.85.07s-3.58-.01-4.85-.07c-3.26-.15-4.77-1.7-4.92-4.92-.06-1.27-.07-1.65-.07-4.85s.01-3.58.07-4.85c.15-3.23 1.7-4.77 4.92-4.92 1.27-.06 1.65-.07 4.85-.07zM12 0C8.74 0 8.33.01 7.05.07 2.7.27.27 2.69.07 7.05.01 8.33 0 8.74 0 12s.01 3.67.07 4.95c.2 4.36 2.62 6.78 6.98 6.98 1.28.06 1.69.07 4.95.07s3.67-.01 4.95-.07c4.35-.2 6.78-2.62 6.98-6.98.06-1.28.07-1.69.07-4.95s-.01-3.67-.07-4.95c-.2-4.35-2.62-6.78-6.98-6.98C15.67.01 15.26 0 12 0zm0 5.84a6.16 6.16 0 100 12.32 6.16 6.16 0 000-12.32zM12 16a4 4 0 110-8 4 4 0 010 8zm6.41-11.85a1.44 1.44 0 11-2.88 0 1.44 1.44 0 012.88 0z"/></svg>
        </a>
    </div>

    {{-- Grille 4 colonnes --}}
    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-4 lg:gap-0">
            <div class="lg:border-r lg:border-white/20 lg:pr-8">
                <h2 class="mb-3 text-sm font-bold uppercase tracking-wide">{{ __('site.footer.col_sede') }}</h2>
                <ul class="list-inside list-disc space-y-2 text-sm text-white/90">
                    <li><a href="{{ portal_route('sede.hub') }}" class="hover:underline">{{ __('site.sede.title') }}</a></li>
                    <li><a href="{{ clave_plataforma_href() }}" class="font-semibold hover:underline">{{ __('site.footer.clave_register') }}</a></li>
                    <li><a href="{{ portal_route('portal.inscription') }}" class="font-semibold hover:underline">{{ __('site.footer.portal_register') }}</a></li>
                    <li>
                        <a href="{{ midgt_acceso_href() }}" class="font-semibold hover:underline">
                            @auth
                                {{ __('portal.header.midgt_space') }}
                            @else
                                {{ __('portal.header.midgt_access') }}
                            @endauth
                        </a>
                    </li>
                    <li><a href="{{ route('permis.index') }}" class="hover:underline">{{ __('site.sede.cards.permis.title') }}</a></li>
                    <li><a href="{{ sede_href('es/vehiculos/informacion-de-vehiculos/informe-de-un-vehiculo') }}" class="hover:underline">{{ __('site.sede.cards.vehicles.title') }}</a></li>
                    <li><a href="{{ route('multas.index') }}" class="hover:underline">{{ __('site.sede.cards.fines.title') }}</a></li>
                    <li><a href="{{ portal_licence_status_href() }}" class="hover:underline">{{ __('portal.verification.check_status') }}</a></li>
                </ul>
            </div>
            <div class="border-t border-white/20 pt-8 md:border-t-0 md:pt-0 lg:border-r lg:border-t-0 lg:px-8">
                <h2 class="mb-3 text-sm font-bold uppercase tracking-wide">{{ __('site.footer.col_permis') }}</h2>
                <ul class="list-inside list-disc space-y-2 text-sm text-white/90">
                    <li><a href="{{ sede_href('es/permisos-de-conducir/obtencion-y-gestion-de-permisos') }}" class="hover:underline">{{ __('site.footer.permis_obtain') }}</a></li>
                    <li><a href="{{ sede_href('es/permisos-de-conducir/obtencion-y-gestion-de-permisos/renovacion-de-permiso-proximo-a-caducar') }}" class="hover:underline">{{ __('site.footer.permis_renew') }}</a></li>
                    <li><a href="{{ sede_href('es/permisos-de-conducir/obtencion-y-gestion-de-permisos/duplicado-de-permisos') }}" class="hover:underline">{{ __('site.footer.permis_duplicate') }}</a></li>
                    <li><a href="{{ sede_href('es/permisos-de-conducir/canjes-de-permisos') }}" class="hover:underline">{{ __('site.footer.permis_exchange') }}</a></li>
                    <li><a href="{{ sede_href('es/permisos-de-conducir/consulta-de-puntos') }}" class="hover:underline">{{ __('site.footer.permis_points') }}</a></li>
                    <li><a href="{{ sede_href('es/permisos-de-conducir/permiso-de-conduccion-internacional') }}" class="hover:underline">{{ __('site.footer.permis_international') }}</a></li>
                    <li><a href="{{ sede_href('es/otros-tramites/cita-previa') }}" class="hover:underline">{{ __('site.footer.permis_appointment') }}</a></li>
                    <li><a href="{{ dgt_href('conoce-el-estado-del-trafico/informacion-e-incidencias-de-trafico') }}" class="hover:underline">{{ __('site.footer.permis_traffic') }}</a></li>
                </ul>
            </div>
            <div class="border-t border-white/20 pt-8 md:border-t-0 md:pt-0 lg:border-r lg:border-t-0 lg:px-8">
                <h2 class="mb-3 text-sm font-bold uppercase tracking-wide">{{ __('site.footer.col_about') }}</h2>
                <ul class="list-inside list-disc space-y-2 text-sm text-white/90">
                    <li><a href="#" class="hover:underline">{{ __('site.footer.about_laws') }}</a></li>
                    <li><a href="#" class="hover:underline">{{ __('site.footer.about_rules') }}</a></li>
                </ul>
            </div>
            <div class="border-t border-white/20 pt-8 md:col-span-2 md:border-t-0 md:pt-0 lg:col-span-1 lg:border-t-0 lg:pl-8">
                <div class="space-y-3 text-sm">
                    <a href="#" class="block font-medium hover:underline">{{ __('site.footer.contact_online') }}</a>
                    <a href="#" class="block font-medium hover:underline">{{ __('site.footer.contact_suggestions') }}</a>
                </div>
                <div class="mt-4">
                    <p class="text-lg font-bold tracking-wide text-white/95" aria-label="{{ __('site.footer.logo_alt') }}">DGT</p>
                    <p class="text-xs text-white/70">{{ __('site.footer.demo_notice') }}</p>
                </div>
                <p class="mt-4 text-xs text-white/80">{{ __('site.footer.copyright') }}</p>
                <div class="mt-4 border-t border-white/20 pt-4">
                    @include('portal.partials.locale-switcher', ['variant' => 'dark'])
                </div>
            </div>
        </div>
    </div>
</footer>
