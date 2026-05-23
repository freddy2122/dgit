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
<div id="admin-nav-drawer" class="fixed inset-0 z-[100] hidden" aria-hidden="true" role="dialog" aria-modal="true" aria-label="{{ __('admin.nav.menu') }}">
    <div class="fixed inset-0 bg-black/50" data-mobile-nav-close aria-hidden="true"></div>
    <aside data-mobile-nav-panel class="fixed inset-y-0 left-0 z-[101] flex w-[min(100%,18rem)] flex-col bg-[#003366] text-white shadow-xl">
        <div class="flex items-center justify-between border-b border-white/10 px-4 py-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-widest text-sky-200/80">DGT</p>
                <p class="text-base font-bold">{{ __('admin.title') }}</p>
            </div>
            <button type="button" class="inline-flex h-9 w-9 items-center justify-center rounded-lg text-sky-100 hover:bg-white/10" data-mobile-nav-close aria-label="{{ __('admin.nav.menu_close') }}">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
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
</div>
