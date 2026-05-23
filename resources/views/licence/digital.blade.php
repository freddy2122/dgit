@php $portalNavActive = 'digital'; @endphp
@extends('layouts.portal')

@section('title', __('portal.license.title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('portal.license.heading') }}</h1>
    <p class="text-sm text-gray-500">{{ __('portal.license.subtitle') }}</p>
@endsection

@section('content')
    @if ($showLicenseCard ?? false)
    <div class="mb-4 inline-flex rounded-lg border border-gray-200 bg-white p-1 shadow-sm" role="tablist">
        <button type="button" data-license-tab="front" class="license-tab rounded-md bg-[#004481] px-4 py-2 text-sm font-semibold text-white" aria-selected="true">
            {{ __('portal.license.front') }}
        </button>
        <button type="button" data-license-tab="back" class="license-tab rounded-md px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50" aria-selected="false">
            {{ __('portal.license.back') }}
        </button>
    </div>

    {{-- QR dynamique miDGT : affiché directement sur le permis (pas seulement dans un menu) --}}
    <div class="mb-6">
        @include('licence.partials.license-qr-panel', [
            'panelId' => 'license-qr-inline',
            'autoStart' => true,
            'ttlSeconds' => $ttlSeconds ?? 180,
            'refreshBefore' => $refreshBefore ?? 15,
        ])
        <p class="mt-2 text-center text-xs text-gray-500">
            <a href="{{ portal_route('documents.verify') }}" class="font-semibold text-[#004481] hover:underline">{{ __('portal.qr.verify_link') }}</a>
        </p>
    </div>
    @include('licence.partials.license-qr-script')
    @else
    <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-950">
        <p class="font-semibold">{{ __('portal.dashboard.no_license_yet') }}</p>
        <p class="mt-2 text-amber-900">{{ __('portal.qr.unpublished_hint') }}</p>
    </div>
    @endif

    <section class="rounded-xl border border-gray-200 bg-white p-4 shadow-sm sm:p-8">
        @if ($showLicenseCard ?? false)
        <div id="license-front" class="flex flex-col items-center py-2">
            @include('portal.partials.license-card-maquette', ['user' => $user, 'license' => $license, 'size' => 'display'])
        </div>
        <div id="license-back" class="hidden flex-col items-center py-2">
            @include('portal.partials.license-card-back', ['user' => $user, 'license' => $license, 'size' => 'display'])
        </div>
        @else
        <p class="rounded-lg border border-dashed border-gray-200 bg-slate-50 px-6 py-10 text-center text-sm text-gray-600">
            {{ __('portal.dashboard.no_license_yet') }}
        </p>
        @endif
        <p class="mt-6 text-center text-sm text-gray-500">{{ __('portal.license.demo_note') }}</p>
    </section>

    @include('portal.partials.license-photo-upload', ['user' => $user, 'redirectTo' => 'licence.digital'])

    @if (session('portal_success'))
        <p class="mt-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('portal_success') }}</p>
    @endif

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm lg:col-span-2">
            <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('portal.license.holder_info') }}</h2>
            <dl class="mt-4 grid gap-4 sm:grid-cols-2">
                <div>
                    <dt class="text-xs text-gray-500">{{ __('portal.license.full_name') }}</dt>
                    <dd class="mt-1 font-semibold">{{ trim(collect([$user->first_name, $user->last_name])->filter()->join(' ')) ?: $user->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500">{{ __('portal.license.nie') }}</dt>
                    <dd class="mt-1 font-mono font-semibold">{{ $user->nie ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500">{{ __('portal.license.categories') }}</dt>
                    <dd class="mt-1 font-semibold">{{ $license?->displayCategoryLabel() ?: ($license?->category ?? '—') }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500">{{ __('portal.license.issued') }}</dt>
                    <dd class="mt-1 font-semibold">{{ $license?->issued_at?->format('d/m/Y') ?? '—' }}</dd>
                </div>
                <div>
                    <dt class="text-xs text-gray-500">{{ __('portal.license.validity') }}</dt>
                    <dd class="mt-1 font-semibold">{{ $license?->valid_until?->format('d/m/Y') ?? '—' }}</dd>
                </div>
            </dl>
        </div>
        <aside class="space-y-4">
            @if ($showLicenseCard ?? false)
            <button
                type="button"
                id="license-qr-open"
                class="flex w-full min-h-[48px] items-center justify-center gap-2 rounded-xl border border-[#004481]/30 bg-white px-4 py-3 text-sm font-semibold text-[#004481] shadow-sm hover:bg-sky-50"
            >
                {{ __('portal.qr.fullscreen') }}
            </button>
            @endif
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-5">
                <p class="text-sm font-semibold text-emerald-900">{{ __('portal.license.valid_badge') }}</p>
                <p class="mt-2 text-3xl font-bold text-emerald-700">{{ $pts ?? '—' }} <span class="text-lg font-medium">/ {{ $maxPts }}</span></p>
                <a href="{{ portal_route('licence.points') }}" class="mt-3 inline-block text-sm font-semibold text-[#004481] hover:underline">{{ __('portal.license.points_detail') }} →</a>
            </div>
            <a href="{{ portal_route('portal.demarches') }}" class="block rounded-xl border border-gray-200 bg-white p-4 text-center text-sm font-semibold text-[#004481] shadow-sm hover:bg-gray-50">
                {{ __('portal.license.my_application') }} →
            </a>
            <a href="{{ portal_route('documents.verify') }}" class="block rounded-xl border border-dashed border-gray-300 bg-gray-50 p-4 text-center text-sm font-semibold text-gray-700 hover:border-[#004481]/40 hover:text-[#004481]">
                {{ __('portal.qr.verify_link') }} →
            </a>
        </aside>
    </div>

    @if ($showLicenseCard ?? false)
        @include('licence.partials.qr-modal', [
            'ttlSeconds' => $ttlSeconds ?? 180,
            'refreshBefore' => $refreshBefore ?? 15,
        ])
    @endif
@endsection

@push('scripts')
<script>
document.querySelectorAll('.license-tab').forEach((btn) => {
    btn.addEventListener('click', () => {
        const tab = btn.dataset.licenseTab;
        const front = document.getElementById('license-front');
        const back = document.getElementById('license-back');
        front.classList.toggle('hidden', tab !== 'front');
        front.classList.toggle('flex', tab === 'front');
        back.classList.toggle('hidden', tab !== 'back');
        back.classList.toggle('flex', tab === 'back');
        document.querySelectorAll('.license-tab').forEach((b) => {
            const active = b.dataset.licenseTab === tab;
            b.classList.toggle('bg-[#004481]', active);
            b.classList.toggle('text-white', active);
            b.classList.toggle('text-gray-700', !active);
            b.setAttribute('aria-selected', active ? 'true' : 'false');
        });
    });
});
</script>
@endpush
