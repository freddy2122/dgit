@php
    $panelId = $panelId ?? 'license-qr-panel';
    $autoStart = $autoStart ?? false;
    $compact = $compact ?? false;
    $ttlSeconds = $ttlSeconds ?? (int) config('dgt_qr.ttl_seconds', 180);
    $refreshBefore = $refreshBefore ?? (int) config('dgt_qr.refresh_before_seconds', 15);
@endphp

<div
    id="{{ $panelId }}"
    class="license-qr-panel rounded-xl border border-[#004481]/25 bg-gradient-to-b from-sky-50 to-white p-5 shadow-sm {{ $compact ? '' : 'sm:p-6' }}"
    data-license-qr-panel
    data-generate-url="{{ portal_route('licence.qr.generate') }}"
    data-ttl-seconds="{{ (int) $ttlSeconds }}"
    data-refresh-before="{{ (int) $refreshBefore }}"
    data-auto-start="{{ $autoStart ? '1' : '0' }}"
    data-error-msg="{{ __('portal.qr.error') }}"
>
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <p class="text-xs font-bold uppercase tracking-wide text-[#004481]">{{ __('portal.qr.card_title') }}</p>
            <p class="mt-1 text-sm text-gray-700">{{ __('portal.qr.card_desc') }}</p>
        </div>
        <div class="license-qr-timer-badge hidden items-center gap-2 rounded-full bg-[#004481]/10 px-3 py-1.5 text-sm font-semibold text-[#004481]">
            <span class="relative flex h-2 w-2">
                <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
            </span>
            <span>{{ __('portal.qr.expires_in') }}</span>
            <span class="license-qr-timer font-mono tabular-nums">3:00</span>
        </div>
    </div>

    <div class="license-qr-loading mt-6 hidden py-8 text-center">
        <p class="text-sm font-medium text-gray-600">{{ __('portal.qr.generating') }}</p>
    </div>

    <div class="license-qr-error mt-4 hidden rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-800"></div>

    <div class="license-qr-content mt-4 hidden flex flex-col items-center text-center">
        <div
            class="license-qr-svg-wrap flex max-w-[min(280px,100%)] items-center justify-center rounded-xl border-2 border-[#004481]/20 bg-white p-4 shadow-inner [&_svg]:h-auto [&_svg]:w-full"
        ></div>
        <p class="mt-3 text-xs text-gray-500">{{ __('portal.qr.scan_hint') }}</p>
        <p class="license-qr-plain-token mt-2 font-mono text-sm font-bold tracking-wide text-gray-800"></p>
        <button
            type="button"
            class="license-qr-regenerate mt-4 inline-flex min-h-[44px] items-center justify-center rounded-lg border-2 border-[#004481] px-5 py-2 text-sm font-semibold text-[#004481] hover:bg-sky-50"
        >
            {{ __('portal.qr.regenerate') }}
        </button>
    </div>

    @unless ($autoStart)
        <button
            type="button"
            class="license-qr-start mt-4 flex w-full min-h-[48px] items-center justify-center gap-2 rounded-lg bg-[#004481] px-4 py-3 text-sm font-bold text-white shadow transition hover:bg-[#003366]"
        >
            {{ __('portal.qr.generate_btn') }}
        </button>
    @endunless
</div>
