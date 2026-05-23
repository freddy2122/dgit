<div
    id="license-qr-modal"
    class="fixed inset-0 z-[1100] hidden items-center justify-center bg-black/60 p-4"
    role="dialog"
    aria-modal="true"
    aria-labelledby="license-qr-modal-title"
    hidden
>
    <div class="relative max-h-[95vh] w-full max-w-lg overflow-y-auto rounded-2xl bg-white shadow-2xl">
        <button
            type="button"
            id="license-qr-modal-close"
            class="absolute right-3 top-3 z-10 flex h-10 w-10 items-center justify-center rounded-full text-gray-500 hover:bg-gray-100"
            aria-label="{{ __('portal.qr.close') }}"
        >
            <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        <div class="border-b border-amber-200 bg-amber-50 px-6 py-4 pr-14">
            <h2 id="license-qr-modal-title" class="text-lg font-bold text-amber-950">{{ __('portal.qr.modal_title') }}</h2>
            <p class="mt-1 text-sm text-amber-900">{{ __('portal.qr.security_notice') }}</p>
        </div>

        <div class="p-6">
            @include('licence.partials.license-qr-panel', [
                'panelId' => 'license-qr-modal-panel',
                'autoStart' => false,
                'ttlSeconds' => $ttlSeconds ?? (int) config('dgt_qr.ttl_seconds', 180),
                'refreshBefore' => $refreshBefore ?? (int) config('dgt_qr.refresh_before_seconds', 15),
            ])
        </div>
    </div>
</div>

@include('licence.partials.license-qr-script')
