@php
    $dgtNav = config('dgt_inicio_nav', []);
    $dgtNavMega = dgt_nav_tree_with_hrefs($dgtNav);
@endphp

<header
    class="sticky top-0 z-[1000] border-b border-gray-200 bg-white transition-shadow duration-200"
    id="site-header"
    data-site-header
    data-menu-open="{{ __('site.menu.open') }}"
    data-menu-close="{{ __('site.menu.close') }}"
    data-search-open="{{ __('site.menu.search_open') }}"
    data-search-close="{{ __('site.menu.search_close') }}"
>
    {{-- Fila superior: logo + UE + menú móvil + búsqueda --}}
    <div class="mx-auto flex max-w-7xl items-center justify-between gap-2 px-3 py-2.5 sm:gap-3 sm:px-6 sm:py-3 lg:px-8">
        <div class="min-w-0 flex-1">
            <a
                href="{{ portal_route('home') }}"
                class="inline-flex max-w-full items-center py-0.5 focus:outline-none focus:ring-2 focus:ring-[#004481]/30 focus:ring-offset-2 sm:max-w-2xl md:max-w-3xl rounded-sm"
                title="{{ __('site.menu.logo_title') }}"
            >
                <img
                    src="{{ asset('images/Logotipo_Footer-DGT.svg') }}"
                    alt="Gobierno de España. Ministerio del Interior. Dirección General de Tráfico."
                    class="h-7 w-auto max-h-9 max-w-full object-left object-contain sm:h-9 sm:max-h-11 md:h-10 md:max-h-12"
                    width="520"
                    height="80"
                    decoding="async"
                />
            </a>
        </div>

        <div class="flex shrink-0 items-center gap-2 sm:gap-4 md:gap-6">
            <div class="flex items-center gap-2 sm:gap-3">
                @auth
                    <a
                        href="{{ portal_route('dashboard') }}"
                        class="inline-flex min-h-[40px] shrink-0 items-center justify-center rounded bg-[#004481] px-4 py-2 text-xs font-bold text-white shadow-sm transition hover:bg-[#003366] focus:outline-none focus:ring-2 focus:ring-[#004481] focus:ring-offset-2 sm:min-h-[44px] sm:px-5 sm:text-sm"
                    >
                        {{ __('portal.header.midgt_space') }}
                    </a>
                    <form method="post" action="{{ route('logout') }}" class="hidden sm:inline">
                        @csrf
                        <button type="submit" class="text-xs font-semibold text-gray-600 hover:text-[#004481] hover:underline sm:text-sm">
                            {{ __('portal.header.logout') }}
                        </button>
                    </form>
                @else
                    <a
                        href="{{ midgt_acceso_href() }}"
                        class="inline-flex min-h-[40px] shrink-0 items-center justify-center rounded bg-[#004481] px-4 py-2 text-xs font-bold tracking-wide text-white shadow-sm transition hover:bg-[#003366] focus:outline-none focus:ring-2 focus:ring-[#004481] focus:ring-offset-2 sm:min-h-[44px] sm:px-5 sm:text-sm"
                    >
                        {{ __('portal.header.midgt_access') }}
                    </a>
                @endauth
            </div>
            <div class="hidden shrink-0 sm:block">
                <img
                    src="{{ asset('images/FinanciadoUE_PTR.svg') }}"
                    alt="Financiado por la Unión Europea — NextGenerationEU"
                    class="h-7 w-auto max-h-8 max-w-[11rem] object-contain object-left md:h-8 md:max-h-9 md:max-w-[13rem]"
                    width="200"
                    height="56"
                    decoding="async"
                />
            </div>

            <button
                type="button"
                id="header-mobile-nav-toggle"
                class="inline-flex h-11 min-h-[44px] w-11 min-w-[44px] items-center justify-center rounded-lg text-[#004481] transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#004481]/40 md:hidden"
                aria-label="{{ __('site.menu.open') }}"
                aria-expanded="false"
                aria-controls="header-mobile-panel"
            >
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 7h16M4 12h16M4 17h16" />
                </svg>
            </button>

            <button
                type="button"
                id="header-search-toggle"
                class="relative inline-flex h-11 min-h-[44px] w-11 min-w-[44px] items-center justify-center rounded-lg text-[#004481] transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#004481]/40 sm:h-10 sm:min-h-0 sm:w-10 sm:min-w-0"
                aria-label="{{ __('site.menu.search_open') }}"
                aria-expanded="false"
                aria-controls="header-search-panel"
            >
                <span id="header-search-icon-search" class="absolute inset-0 flex items-center justify-center" aria-hidden="true">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.2-5.2M11 18a7 7 0 100-14 7 7 0 000 14z" />
                    </svg>
                </span>
                <span id="header-search-icon-close" class="absolute inset-0 hidden items-center justify-center" aria-hidden="true">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </span>
            </button>
        </div>
    </div>

    {{-- Barra de búsqueda --}}
    <div
        id="header-search-panel"
        class="hidden border-t border-gray-200 bg-gray-50"
        role="search"
        hidden
    >
        <form class="mx-auto flex max-w-7xl gap-0 px-3 py-3 sm:px-6 lg:px-8" action="{{ portal_route('licence.status') }}" method="get">
            <label for="header-search-input" class="sr-only">{{ __('site.menu.search') }}</label>
            <input
                id="header-search-input"
                type="search"
                name="verification_code"
                placeholder="{{ __('site.menu.search_placeholder') }}"
                autocomplete="off"
                class="min-h-[48px] min-w-0 flex-1 border border-r-0 border-gray-300 bg-white px-4 py-3 text-base text-gray-800 placeholder:text-gray-500 focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481] sm:min-h-0 sm:py-2.5 sm:text-sm"
            />
            <button
                type="submit"
                class="flex min-h-[48px] min-w-[48px] shrink-0 items-center justify-center bg-[#004481] px-4 py-2.5 text-white transition hover:bg-[#003366] focus:outline-none focus:ring-2 focus:ring-[#004481] focus:ring-offset-2 sm:min-h-0 sm:min-w-0"
                aria-label="{{ __('site.menu.search_submit') }}"
            >
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.2-5.2M11 18a7 7 0 100-14 7 7 0 000 14z" />
                </svg>
            </button>
        </form>
    </div>

    {{-- Menú escritorio: méga-menu 3 colonnes (données JSON + JS) --}}
    <div class="hidden border-t border-gray-200 bg-white md:block md:overflow-visible">
        <div
            id="dgt-mega-nav-root"
            class="relative md:overflow-visible"
            data-dgt-mega-nav
            data-mega-view-rubrique="{{ __('site.menu.view_rubrique') }}"
            data-mega-no-entries="{{ __('site.menu.no_entries') }}"
        >
            <div class="mx-auto max-w-7xl px-0 sm:px-6 lg:px-8 md:overflow-visible">
                <nav
                    class="header-main-nav hidden divide-x divide-gray-200 md:flex md:overflow-visible md:text-base"
                    aria-label="{{ __('site.menu.main') }}"
                    id="dgt-mega-tabs"
                >
                    @foreach ($dgtNav as $idx => $top)
                        <button
                            type="button"
                            class="dgt-mega-tab shrink-0 border-b-2 border-transparent px-4 py-3 text-sm font-bold text-gray-900 transition hover:bg-gray-50 md:flex-1 md:min-w-0 md:text-center md:text-base"
                            data-mega-tab="{{ $idx }}"
                            aria-expanded="false"
                            aria-controls="dgt-mega-panel"
                        >
                            <span class="truncate">{{ dgt_menu_label($top) }}</span>
                        </button>
                    @endforeach
                </nav>
            </div>
            <div
                id="dgt-mega-panel"
                class="pointer-events-none invisible absolute left-0 right-0 top-full z-[110] max-h-[min(78vh,32rem)] overflow-y-auto border-t border-gray-200 bg-white opacity-0 shadow-lg transition-[opacity,visibility] duration-150"
                role="region"
                aria-label="{{ __('site.menu.submenu') }}"
                aria-hidden="true"
                hidden
            >
                <div class="mx-auto grid max-h-[inherit] max-w-7xl grid-cols-1 gap-0 px-3 py-4 sm:px-6 sm:py-6 lg:grid-cols-3 lg:gap-8 lg:px-8">
                    <div class="min-h-0 border-b border-gray-100 pb-4 lg:border-b-0 lg:border-r lg:pb-0 lg:pr-4" id="dgt-mega-col1"></div>
                    <div class="min-h-0 border-b border-gray-100 py-4 lg:border-b-0 lg:border-r lg:py-0 lg:px-4" id="dgt-mega-col2"></div>
                    <div class="min-h-0 pt-4 lg:pt-0 lg:pl-4" id="dgt-mega-col3"></div>
                </div>
            </div>
        </div>
        <script type="application/json" id="dgt-mega-nav-json">{!! json_encode($dgtNavMega, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT) !!}</script>
    </div>

    {{-- Menú móvil (drawer pantalla completa, < md) --}}
    <div
        id="header-mobile-panel"
        class="fixed inset-0 z-[1200] hidden md:hidden"
        role="dialog"
        aria-modal="true"
        aria-labelledby="header-mobile-panel-title"
        hidden
    >
        <button
            type="button"
            class="absolute inset-0 bg-black/45 backdrop-blur-[1px]"
            id="header-mobile-backdrop"
            aria-label="{{ __('site.menu.close') }}"
        ></button>
        <div
            class="absolute inset-y-0 right-0 flex w-[min(100vw,22rem)] max-w-full flex-col border-l border-gray-200 bg-white shadow-2xl"
            style="padding-top: max(0.75rem, env(safe-area-inset-top, 0px)); padding-bottom: max(0.75rem, env(safe-area-inset-bottom, 0px));"
        >
            <div class="flex shrink-0 items-center justify-between gap-2 border-b border-gray-200 px-4 py-3">
                <p id="header-mobile-panel-title" class="text-base font-bold text-[#004481]">{{ __('site.menu.title') }}</p>
                <button
                    type="button"
                    id="header-mobile-nav-close"
                    class="inline-flex h-11 min-h-[44px] w-11 min-w-[44px] items-center justify-center rounded-lg text-gray-600 transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-[#004481]/40"
                    aria-label="{{ __('site.menu.close') }}"
                >
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="shrink-0 border-b border-gray-200 px-3 py-4">
                @auth
                    <a
                        href="{{ portal_route('dashboard') }}"
                        class="flex min-h-[48px] w-full items-center justify-center rounded bg-[#004481] px-4 text-sm font-bold text-white transition hover:bg-[#003366]"
                    >
                        {{ __('portal.header.midgt_space') }}
                    </a>
                    <form method="post" action="{{ route('logout') }}" class="mt-2">
                        @csrf
                        <button
                            type="submit"
                            class="flex min-h-[44px] w-full items-center justify-center rounded-lg border border-gray-300 bg-white px-4 text-sm font-semibold text-gray-700 transition hover:bg-gray-50"
                        >
                            {{ __('portal.header.logout') }}
                        </button>
                    </form>
                @else
                    <a
                        href="{{ midgt_acceso_href() }}"
                        class="flex min-h-[48px] w-full items-center justify-center rounded bg-[#004481] px-4 text-sm font-bold text-white shadow-sm transition hover:bg-[#003366]"
                    >
                        {{ __('portal.header.midgt_access') }}
                    </a>
                @endauth
            </div>
            <nav class="header-mobile-nav flex-1 overflow-y-auto overscroll-y-contain px-2 pb-6 pt-2" aria-label="{{ __('site.menu.main_mobile') }}">
                @foreach ($dgtNav as $top)
                    <details class="header-mobile-details group border-b border-gray-100 last:border-b-0">
                        <summary
                            class="flex cursor-pointer list-none items-center justify-between gap-2 rounded-lg px-3 py-3.5 text-[0.9375rem] font-bold text-gray-900 outline-none marker:content-none active:bg-gray-50 [&::-webkit-details-marker]:hidden"
                        >
                            <span class="min-w-0 flex-1 leading-snug">{{ dgt_menu_label($top) }}</span>
                            <svg class="h-5 w-5 shrink-0 text-gray-500 transition group-open:rotate-180" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.94a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </summary>
                        <div class="border-t border-gray-100 bg-gray-50/90 pb-2 pt-1">
                            @php $_tru = $top['url'] ?? '#'; @endphp
                            <a
                                href="{{ dgt_href($_tru) }}"
                                @if (! dgt_href_is_internal($_tru)) target="_blank" rel="noopener noreferrer" @endif
                                class="block px-4 py-3 text-xs font-semibold uppercase tracking-wide text-[#004481] underline-offset-2 hover:underline"
                            >
                                {{ __('site.menu.view_section', ['section' => dgt_menu_label($top)]) }}
                            </a>
                            @foreach ($top['children'] ?? [] as $child)
                                @php $_cru = $child['url'] ?? '#'; @endphp
                                <a
                                    href="{{ dgt_href($_cru) }}"
                                    @if (! dgt_href_is_internal($_cru)) target="_blank" rel="noopener noreferrer" @endif
                                    class="block border-t border-gray-100 px-4 py-3 text-[0.9375rem] font-semibold text-[#004481] active:bg-white"
                                >
                                    {{ dgt_menu_label($child) }}
                                </a>
                                @if (!empty($child['children']))
                                    @foreach ($child['children'] as $sub)
                                        @php $_sru = $sub['url'] ?? '#'; @endphp
                                        <a
                                            href="{{ dgt_href($_sru) }}"
                                            @if (! dgt_href_is_internal($_sru)) target="_blank" rel="noopener noreferrer" @endif
                                            class="block border-t border-gray-100/80 py-2.5 pl-7 pr-4 text-sm text-gray-700 active:bg-white"
                                        >
                                            {{ dgt_menu_label($sub) }}
                                        </a>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </details>
                @endforeach
            </nav>
        </div>
    </div>

    <style>
        .header-mobile-details > summary::-webkit-details-marker { display: none; }
        .dgt-mega-tab.is-active {
            border-bottom-color: #004481;
            color: #004481;
        }
    </style>
</header>

@push('scripts')
    <script>
        (function () {
            var header = document.getElementById('site-header');
            var toggle = document.getElementById('header-search-toggle');
            var panel = document.getElementById('header-search-panel');
            var iconSearch = document.getElementById('header-search-icon-search');
            var iconClose = document.getElementById('header-search-icon-close');
            var mobileToggle = document.getElementById('header-mobile-nav-toggle');
            var mobilePanel = document.getElementById('header-mobile-panel');
            var mobileClose = document.getElementById('header-mobile-nav-close');
            var mobileBackdrop = document.getElementById('header-mobile-backdrop');

            function setHeaderShadow() {
                if (!header) return;
                header.classList.toggle('shadow-md', window.scrollY > 3);
            }

            setHeaderShadow();
            window.addEventListener('scroll', setHeaderShadow, { passive: true });

            function setBodyNavLock(lock) {
                document.body.classList.toggle('header-mobile-open', lock);
                document.body.style.overflow = lock ? 'hidden' : '';
            }

            var menuOpenLabel = header ? (header.getAttribute('data-menu-open') || '') : '';
            var menuCloseLabel = header ? (header.getAttribute('data-menu-close') || '') : '';
            var searchOpenLabel = header ? (header.getAttribute('data-search-open') || '') : '';
            var searchCloseLabel = header ? (header.getAttribute('data-search-close') || '') : '';

            function setMobileNavOpen(open) {
                if (!mobilePanel || !mobileToggle) return;
                mobilePanel.classList.toggle('hidden', !open);
                mobilePanel.hidden = !open;
                mobileToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                mobileToggle.setAttribute('aria-label', open ? menuCloseLabel : menuOpenLabel);
                setBodyNavLock(open);
                if (open && toggle && panel && !panel.classList.contains('hidden')) {
                    setSearchOpen(false);
                }
            }

            function setSearchOpen(open) {
                if (!toggle || !panel) return;
                panel.classList.toggle('hidden', !open);
                panel.hidden = !open;
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                toggle.setAttribute('aria-label', open ? searchCloseLabel : searchOpenLabel);
                if (iconSearch) {
                    iconSearch.classList.toggle('hidden', open);
                    iconSearch.classList.toggle('flex', !open);
                }
                if (iconClose) {
                    iconClose.classList.toggle('hidden', !open);
                    iconClose.classList.toggle('flex', open);
                }
                if (open) {
                    if (mobilePanel && !mobilePanel.classList.contains('hidden')) setMobileNavOpen(false);
                    var input = document.getElementById('header-search-input');
                    if (input) setTimeout(function () { input.focus(); }, 10);
                }
            }

            if (toggle && panel) {
                toggle.addEventListener('click', function () {
                    setSearchOpen(panel.classList.contains('hidden'));
                });
            }

            if (mobileToggle && mobilePanel) {
                mobileToggle.addEventListener('click', function () {
                    setMobileNavOpen(mobilePanel.classList.contains('hidden'));
                });
            }
            if (mobileClose) {
                mobileClose.addEventListener('click', function () {
                    setMobileNavOpen(false);
                });
            }
            if (mobileBackdrop) {
                mobileBackdrop.addEventListener('click', function () {
                    setMobileNavOpen(false);
                });
            }

            var megaPanelEl = document.getElementById('dgt-mega-panel');
            var megaCloseFromEscape = function () {};

            document.addEventListener('keydown', function (e) {
                if (e.key !== 'Escape') return;
                if (mobilePanel && !mobilePanel.classList.contains('hidden')) setMobileNavOpen(false);
                else if (panel && !panel.classList.contains('hidden')) setSearchOpen(false);
                else if (megaPanelEl && !megaPanelEl.hidden) megaCloseFromEscape();
            });

            document.addEventListener('click', function (e) {
                if (panel && !panel.classList.contains('hidden')) {
                    if (toggle.contains(e.target) || panel.contains(e.target)) return;
                    setSearchOpen(false);
                }
            });

            window.addEventListener('resize', function () {
                if (window.matchMedia('(min-width:768px)').matches) {
                    setMobileNavOpen(false);
                }
                if (megaPanelEl && !window.matchMedia('(min-width:768px)').matches) {
                    megaCloseFromEscape();
                }
            });

            var megaRoot = document.getElementById('dgt-mega-nav-root');
            var megaPanel = megaPanelEl;
            var megaJsonEl = document.getElementById('dgt-mega-nav-json');
            var megaCol1 = document.getElementById('dgt-mega-col1');
            var megaCol2 = document.getElementById('dgt-mega-col2');
            var megaCol3 = document.getElementById('dgt-mega-col3');
            var megaTabs = document.querySelectorAll('.dgt-mega-tab');

            if (megaRoot && megaPanel && megaJsonEl && megaCol1 && megaCol2 && megaCol3 && megaTabs.length) {
                var megaViewRubrique = megaRoot.getAttribute('data-mega-view-rubrique') || '';
                var megaNoEntries = megaRoot.getAttribute('data-mega-no-entries') || '';
                var megaNavData = [];
                try {
                    megaNavData = JSON.parse(megaJsonEl.textContent || '[]');
                } catch (e) {
                    megaNavData = [];
                }

                function megaLabel(n) {
                    if (!n) return '';
                    if (n.label_display && String(n.label_display).length) return String(n.label_display);
                    return n.label != null ? String(n.label) : '';
                }

                function megaLinkAttrs(external) {
                    return external ? ' target="_blank" rel="noopener noreferrer"' : '';
                }

                var megaLeaveTimer = null;
                var megaOpen = false;
                var megaTopIdx = 0;
                var megaL1Idx = 0;
                var megaL2Idx = -1;

                function megaClearLeaveTimer() {
                    if (megaLeaveTimer) {
                        clearTimeout(megaLeaveTimer);
                        megaLeaveTimer = null;
                    }
                }

                function megaScheduleClose() {
                    megaClearLeaveTimer();
                    megaLeaveTimer = setTimeout(function () {
                        megaLeaveTimer = null;
                        megaSetOpen(false);
                    }, 220);
                }

                function megaSetTabActive(idx) {
                    megaTabs.forEach(function (btn, i) {
                        var on = i === idx;
                        btn.classList.toggle('is-active', on && megaOpen);
                        btn.setAttribute('aria-expanded', on && megaOpen ? 'true' : 'false');
                    });
                }

                function megaSetOpen(open) {
                    megaOpen = open;
                    if (!megaPanel) return;
                    megaPanel.hidden = !open;
                    megaPanel.setAttribute('aria-hidden', open ? 'false' : 'true');
                    megaPanel.classList.toggle('invisible', !open);
                    megaPanel.classList.toggle('opacity-0', !open);
                    megaPanel.classList.toggle('pointer-events-none', !open);
                    megaSetTabActive(megaTopIdx);
                    if (!open) megaClearLeaveTimer();
                }

                function megaFirstIndexWithChildren(nodes) {
                    if (!nodes || !nodes.length) return -1;
                    for (var i = 0; i < nodes.length; i++) {
                        if (nodes[i].children && nodes[i].children.length) return i;
                    }
                    return -1;
                }

                function megaPickL2Default(l1) {
                    if (!l1 || !l1.children || !l1.children.length) return -1;
                    var j = megaFirstIndexWithChildren(l1.children);
                    return j >= 0 ? j : -1;
                }

                function megaSyncIndicesForTop() {
                    var top = megaNavData[megaTopIdx];
                    var ch = top && top.children ? top.children : [];
                    var i1 = megaFirstIndexWithChildren(ch);
                    megaL1Idx = i1 >= 0 ? i1 : 0;
                    var l1 = ch[megaL1Idx];
                    megaL2Idx = megaPickL2Default(l1);
                }

                function megaEsc(s) {
                    return String(s == null ? '' : s)
                        .replace(/&/g, '&amp;')
                        .replace(/</g, '&lt;')
                        .replace(/"/g, '&quot;');
                }

                function megaBindRowHover(container, selector) {
                    container.querySelectorAll(selector).forEach(function (el) {
                        el.addEventListener('mouseenter', function () {
                            var idx = parseInt(el.getAttribute('data-l1'), 10);
                            if (!isNaN(idx)) {
                                megaL1Idx = idx;
                                var l1n = (megaNavData[megaTopIdx].children || [])[megaL1Idx];
                                megaL2Idx = megaPickL2Default(l1n);
                                megaRender();
                                return;
                            }
                            var j = parseInt(el.getAttribute('data-l2'), 10);
                            if (!isNaN(j)) {
                                megaL2Idx = j;
                                megaRender();
                            }
                        });
                    });
                }

                function megaRender() {
                    var top = megaNavData[megaTopIdx];
                    var ch = top && top.children ? top.children : [];
                    var l1 = ch[megaL1Idx];
                    var chevron = '<span class="ml-1 text-gray-400" aria-hidden="true">›</span>';
                    var baseL1 = 'flex w-full items-center justify-between gap-2 border-b border-gray-100 px-1 py-2.5 text-left text-sm ';
                    var baseL2 = 'flex w-full items-center justify-between gap-2 border-t border-gray-100 px-1 py-2.5 text-left text-sm ';

                    var h1 = '';
                    for (var a = 0; a < ch.length; a++) {
                        var row = ch[a];
                        var hasKids = row.children && row.children.length;
                        var active = a === megaL1Idx;
                        var cls = baseL1 + (active ? 'bg-sky-50 font-semibold text-[#004481]' : 'text-gray-800 hover:bg-gray-50');
                        if (hasKids) {
                            h1 += '<button type="button" class="mega-l1 ' + cls + '" data-l1="' + a + '">';
                            h1 += '<span class="min-w-0">' + megaEsc(megaLabel(row)) + '</span>' + chevron;
                            h1 += '</button>';
                        } else {
                            h1 += '<a href="' + megaEsc(row.href || '#') + '"' + megaLinkAttrs(!!row.external) + ' class="mega-l1 ' + cls + '" data-l1="' + a + '">';
                            h1 += '<span class="min-w-0">' + megaEsc(megaLabel(row)) + '</span>';
                            h1 += '</a>';
                        }
                    }
                    megaCol1.innerHTML = h1 || '<p class="text-sm text-gray-500">' + megaEsc(megaNoEntries) + '</p>';
                    megaBindRowHover(megaCol1, '.mega-l1');

                    var h2 = '';
                    if (!l1) {
                        megaCol2.innerHTML = '';
                        megaCol3.innerHTML = '';
                        return;
                    }
                    if (!l1.children || !l1.children.length) {
                        h2 += '<a href="' + megaEsc(l1.href || '#') + '"' + megaLinkAttrs(!!l1.external) + ' class="block rounded px-1 py-2 text-sm font-semibold text-[#004481] underline-offset-2 hover:underline">' + megaEsc(megaLabel(l1)) + '</a>';
                        megaCol2.innerHTML = h2;
                        megaCol3.innerHTML = '';
                        return;
                    }
                    h2 += '<a href="' + megaEsc(l1.href || '#') + '"' + megaLinkAttrs(!!l1.external) + ' class="mb-2 block text-xs font-semibold uppercase tracking-wide text-gray-500 hover:text-[#004481]">' + megaEsc(megaViewRubrique) + '</a>';
                    for (var b = 0; b < l1.children.length; b++) {
                        var row2 = l1.children[b];
                        var has3 = row2.children && row2.children.length;
                        var active2 = b === megaL2Idx;
                        var c2 = baseL2 + (active2 ? 'bg-sky-50 font-semibold text-[#004481]' : 'text-gray-800 hover:bg-gray-50');
                        if (has3) {
                            h2 += '<button type="button" class="mega-l2 ' + c2 + '" data-l2="' + b + '">';
                            h2 += '<span class="min-w-0">' + megaEsc(megaLabel(row2)) + '</span>' + chevron;
                            h2 += '</button>';
                        } else {
                            h2 += '<a href="' + megaEsc(row2.href || '#') + '"' + megaLinkAttrs(!!row2.external) + ' class="mega-l2 ' + c2 + '" data-l2="' + b + '">';
                            h2 += '<span class="min-w-0">' + megaEsc(megaLabel(row2)) + '</span>';
                            h2 += '</a>';
                        }
                    }
                    megaCol2.innerHTML = h2;
                    megaBindRowHover(megaCol2, '.mega-l2');

                    var h3 = '';
                    var l2 = megaL2Idx >= 0 && l1.children[megaL2Idx] ? l1.children[megaL2Idx] : null;
                    if (l2 && l2.children && l2.children.length) {
                        for (var c = 0; c < l2.children.length; c++) {
                            var row3 = l2.children[c];
                            h3 += '<a href="' + megaEsc(row3.href || '#') + '"' + megaLinkAttrs(!!row3.external) + ' class="block border-b border-gray-100 py-2 text-sm text-gray-800 hover:text-[#004481]">' + megaEsc(megaLabel(row3)) + '</a>';
                        }
                    }
                    megaCol3.innerHTML = h3;
                }

                function megaOpenAt(idx) {
                    megaTopIdx = idx;
                    megaSyncIndicesForTop();
                    megaSetOpen(true);
                    megaRender();
                }

                megaRoot.addEventListener('mouseenter', megaClearLeaveTimer);
                megaRoot.addEventListener('mouseleave', megaScheduleClose);

                megaTabs.forEach(function (btn) {
                    btn.addEventListener('mouseenter', function () {
                        megaClearLeaveTimer();
                        var idx = parseInt(btn.getAttribute('data-mega-tab'), 10);
                        if (isNaN(idx)) return;
                        megaOpenAt(idx);
                    });
                    btn.addEventListener('focus', function () {
                        megaClearLeaveTimer();
                    });
                });

                megaCol1.addEventListener('click', function (e) {
                    var t = e.target.closest('.mega-l1');
                    if (!t || t.tagName === 'A') return;
                    megaL1Idx = parseInt(t.getAttribute('data-l1'), 10);
                    var l1 = (megaNavData[megaTopIdx].children || [])[megaL1Idx];
                    megaL2Idx = megaPickL2Default(l1);
                    megaRender();
                });

                megaCol2.addEventListener('click', function (e) {
                    var t = e.target.closest('.mega-l2');
                    if (!t || t.tagName === 'A') return;
                    megaL2Idx = parseInt(t.getAttribute('data-l2'), 10);
                    megaRender();
                });

                if (megaPanel) {
                    megaPanel.addEventListener('click', function (e) {
                        var link = e.target.closest('a');
                        if (!link) return;
                        var href = link.getAttribute('href');
                        if (!href || href === '#') return;
                        megaSetOpen(false);
                    });
                }

                megaCloseFromEscape = function () {
                    megaSetOpen(false);
                };
            }

            var mobileNavEl = document.querySelector('.header-mobile-nav');
            if (mobileNavEl) {
                mobileNavEl.querySelectorAll('.header-mobile-details').forEach(function (d) {
                    d.addEventListener('toggle', function () {
                        if (!d.open) return;
                        mobileNavEl.querySelectorAll('.header-mobile-details').forEach(function (other) {
                            if (other !== d) other.removeAttribute('open');
                        });
                    });
                });
                mobileNavEl.addEventListener('click', function (e) {
                    var a = e.target.closest('a');
                    if (!a) return;
                    var href = a.getAttribute('href');
                    if (href && href !== '#') setMobileNavOpen(false);
                });
            }
        })();
    </script>
@endpush
