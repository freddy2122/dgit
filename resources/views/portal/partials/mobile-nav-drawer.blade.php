@php
    $active = $portalNavActive ?? 'dashboard';
    $portalNav = [
        ['id' => 'dashboard', 'label' => __('portal.nav.dashboard'), 'href' => portal_route('dashboard'), 'icon' => 'home'],
        ['id' => 'digital', 'label' => __('portal.nav.digital'), 'href' => portal_route('licence.digital'), 'icon' => 'card'],
        ['id' => 'qr', 'label' => __('portal.qr.generate_btn'), 'href' => portal_route('licence.qr'), 'icon' => 'card'],
        ['id' => 'points', 'label' => __('portal.nav.points'), 'href' => portal_route('licence.points'), 'icon' => 'card'],
        ['id' => 'demarches', 'label' => __('portal.nav.demarches'), 'href' => portal_route('portal.demarches'), 'icon' => 'doc'],
        ['id' => 'vehicles', 'label' => __('portal.nav.vehicles'), 'href' => portal_route('vehicles.report'), 'icon' => 'car'],
        ['id' => 'fines', 'label' => __('portal.nav.fines'), 'href' => portal_route('multas.index'), 'icon' => 'doc'],
        ['id' => 'payments', 'label' => __('portal.nav.payments'), 'href' => portal_route('portal.payments'), 'icon' => 'pay'],
        ['id' => 'taxes', 'label' => __('portal.nav.taxes'), 'href' => portal_route('taxes.index'), 'icon' => 'pay'],
        ['id' => 'appointments', 'label' => __('portal.nav.appointments'), 'href' => portal_route('portal.appointments'), 'icon' => 'cal'],
        ['id' => 'documents', 'label' => __('portal.nav.documents'), 'href' => portal_route('documents.verify'), 'icon' => 'doc'],
        ['id' => 'notifications', 'label' => __('portal.nav.notifications'), 'href' => portal_route('portal.notifications'), 'icon' => 'doc'],
        ['id' => 'profile', 'label' => __('portal.nav.profile'), 'href' => portal_route('portal.profile'), 'icon' => 'user'],
    ];
@endphp
<div id="portal-nav-drawer" class="fixed inset-0 z-[100] hidden" aria-hidden="true" role="dialog" aria-modal="true" aria-label="{{ __('portal.nav.menu') }}">
    <div class="fixed inset-0 bg-black/50" data-mobile-nav-close aria-hidden="true"></div>
    <aside data-mobile-nav-panel class="fixed inset-y-0 left-0 z-[101] flex w-[min(100%,18rem)] flex-col bg-white shadow-xl">
        <div class="flex items-center justify-between border-b border-gray-100 px-4 py-4">
            <a href="{{ portal_route('home') }}" class="text-xl font-bold text-[#004481]">mi<span class="font-extrabold">DGT</span></a>
            <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 hover:bg-gray-100" data-mobile-nav-close aria-label="{{ __('portal.nav.menu_close') }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <nav class="flex flex-1 flex-col gap-0.5 overflow-y-auto p-3 text-sm font-medium">
            @include('portal.partials.sidebar-nav-links', ['portalNavActive' => $active, 'nav' => $portalNav])
        </nav>
        <div class="space-y-0.5 border-t border-gray-100 p-3">
            <a href="{{ portal_route('sede.hub') }}" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('portal.nav.sede') }}</a>
            <a href="{{ portal_route('licence.status') }}" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('portal.verification.check_status') }}</a>
            <form method="post" action="{{ portal_route('logout') }}">
                @csrf
                <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm font-medium text-gray-500 hover:bg-gray-50">{{ __('portal.logout') }}</button>
            </form>
        </div>
    </aside>
</div>
