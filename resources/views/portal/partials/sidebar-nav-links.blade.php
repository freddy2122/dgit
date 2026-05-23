@php
    $active = $portalNavActive ?? 'dashboard';
    $nav = $nav ?? [
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
@foreach ($nav as $item)
    @if ($active === $item['id'])
        <span class="flex items-center gap-3 rounded-lg border-l-4 border-[#004481] bg-sky-50 px-3 py-2.5 text-[#004481]">
            @include('midgt._nav-icon', ['icon' => $item['icon']])
            {{ $item['label'] }}
        </span>
    @else
        <a href="{{ $item['href'] }}" class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-gray-700 transition hover:bg-gray-50 hover:text-[#004481]">
            @include('midgt._nav-icon', ['icon' => $item['icon']])
            {{ $item['label'] }}
        </a>
    @endif
@endforeach
