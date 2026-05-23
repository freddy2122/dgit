@php
    $adminNav = [
        ['admin.dashboard', __('admin.nav.dashboard')],
        ['admin.users.index', __('admin.nav.users')],
        ['admin.permits.index', __('admin.nav.permits')],
        ['admin.applications.index', __('admin.nav.applications')],
        ['admin.vehicles.index', __('admin.nav.vehicles')],
        ['admin.payments.index', __('admin.nav.payments')],
        ['admin.documents.index', __('admin.nav.documents')],
        ['admin.appointments.index', __('admin.nav.appointments')],
        ['admin.logs.index', __('admin.nav.logs')],
        ['admin.settings.index', __('admin.nav.settings')],
    ];
    $adminNavLinkClass = function (string $route): string {
        $active = request()->routeIs($route.'*') || request()->routeIs($route);

        return 'block rounded-lg px-3 py-2.5 font-medium transition '.($active ? 'bg-white/15 text-white' : 'text-sky-100/90 hover:bg-white/10');
    };
@endphp

<aside class="hidden w-64 shrink-0 flex-col bg-[#003366] text-white lg:flex">
    <div class="border-b border-white/10 px-5 py-5">
        <p class="text-xs font-semibold uppercase tracking-widest text-sky-200/80">DGT</p>
        <p class="text-lg font-bold">{{ __('admin.title') }}</p>
        <p class="mt-1 text-xs text-sky-100/70">{{ auth()->user()->email }}</p>
    </div>
    <nav class="flex-1 space-y-0.5 overflow-y-auto p-3 text-sm">
        @foreach ($adminNav as [$route, $label])
            <a href="{{ route($route) }}" class="{{ $adminNavLinkClass($route) }}">{{ $label }}</a>
        @endforeach
    </nav>
    <div class="border-t border-white/10 p-4 text-xs text-sky-100/80">
        <a href="{{ portal_route('dashboard') }}" class="font-semibold hover:text-white">{{ __('admin.back_portal') }}</a>
    </div>
</aside>
