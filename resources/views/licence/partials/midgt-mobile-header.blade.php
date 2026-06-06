@php
    $notificationsHref = auth()->check()
        ? portal_route('portal.notifications')
        : portal_route('login');
    $hasUnread = auth()->check()
        && auth()->user()->portalNotifications()->where('is_read', false)->exists();
@endphp

<header class="midgt-app__header">
    <div class="midgt-app__header-side">
        @include('partials.mobile-nav-toggle', [
            'id' => 'status-midgt-nav',
            'label' => __('portal.nav.menu'),
        ])
    </div>

    <a href="{{ auth()->check() ? portal_route('dashboard') : portal_route('home') }}" class="midgt-app__logo" aria-label="{{ __('portal.header.midgt_space') }}">
        <img
            src="{{ asset('images/midgt-logo.svg') }}"
            alt=""
            width="120"
            height="32"
            class="midgt-app__logo-img"
        />
    </a>

    <div class="midgt-app__header-side midgt-app__header-side--end">
        <a
            href="{{ $notificationsHref }}"
            class="midgt-app__bell"
            aria-label="{{ __('portal.notifications') }}"
        >
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.75" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            @if ($hasUnread)
                <span class="midgt-app__bell-dot" aria-hidden="true"></span>
            @endif
        </a>
    </div>
</header>
