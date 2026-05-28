@php
    $active = $portalNavActive ?? 'dashboard';
    $portalNav = [
        ['id' => 'dashboard', 'label' => __('portal.nav.dashboard'), 'href' => portal_route('dashboard'), 'icon' => 'home'],
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

<aside class="hidden w-64 shrink-0 flex-col border-r border-gray-200 bg-white lg:flex" aria-label="{{ __('portal.brand') }}">
    <div class="border-b border-gray-100 px-5 py-5">
        <a href="{{ portal_route('home') }}" class="text-2xl font-bold tracking-tight text-[#004481]">
            mi<span class="font-extrabold">DGT</span>
        </a>
    </div>
    <nav class="flex flex-1 flex-col gap-0.5 overflow-y-auto p-3 text-sm font-medium">
        @include('portal.partials.sidebar-nav-links', ['portalNavActive' => $active, 'nav' => $portalNav])
    </nav>
    <div class="mt-auto space-y-0.5 border-t border-gray-100 p-3">
        <a href="{{ portal_route('sede.hub') }}" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-[#004481]">
            @include('midgt._nav-icon', ['icon' => 'home'])
            {{ __('portal.nav.sede') }}
        </a>
        <a href="{{ portal_route('licence.status') }}" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-[#004481]">
            @include('midgt._nav-icon', ['icon' => 'doc'])
            {{ __('portal.verification.check_status') }}
        </a>
        <form method="post" action="{{ portal_route('logout') }}" class="mt-1">
            @csrf
            <button type="submit" class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm font-medium text-gray-500 hover:bg-gray-50 hover:text-[#004481]">
                {{ __('portal.logout') }}
            </button>
        </form>
    </div>
</aside>
