@extends('layouts.perseo')

@section('title', __('verify.title'))

@section('content')
    @include('portal.partials.search-loader', ['title' => __('verify.loading_title'), 'subtitle' => __('verify.loading_sub')])

    <div class="mx-auto max-w-3xl px-4 py-8">
        <nav class="mb-4 flex flex-wrap gap-2 text-sm text-[#004481]">
            <a href="{{ portal_route('home') }}" class="hover:underline">{{ __('status.breadcrumb_home') }}</a>
            <span class="text-gray-300">·</span>
            <a href="{{ portal_route('licence.status') }}" class="hover:underline">{{ __('verify.go_status') }}</a>
            @auth
                <span class="text-gray-300">·</span>
                <a href="{{ portal_route('dashboard') }}" class="hover:underline">{{ __('verify.go_dashboard') }}</a>
            @endauth
        </nav>

        <h1 class="text-2xl font-bold text-[#004481]">{{ __('verify.title') }}</h1>
        <p class="mt-1 text-sm text-gray-600">{{ __('verify.subtitle') }}</p>

        <div class="mt-6 inline-flex rounded-lg border border-gray-200 bg-white p-1 shadow-sm" role="tablist">
            <button type="button" data-verify-tab="qr" class="verify-tab rounded-md bg-[#004481] px-4 py-2 text-sm font-semibold text-white" aria-selected="true">
                {{ __('verify.tab_qr') }}
            </button>
            <button type="button" data-verify-tab="code" class="verify-tab rounded-md px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50" aria-selected="false">
                {{ __('verify.tab_code') }}
            </button>
        </div>

        @if ($authCode ?? null)
            <p class="mt-4 text-sm text-gray-600 verify-code-hint hidden">
                {{ __('status.auth_code_info') }}
                <code class="rounded bg-sky-50 px-2 py-0.5 font-mono font-bold text-[#004481]">{{ $authCode }}</code>
            </p>
        @elseif(auth()->guest())
            <p class="mt-4 text-sm text-gray-500">{{ __('verify.login_hint') }}</p>
        @endif

        <div class="mt-4 overflow-hidden rounded-xl border border-gray-300 bg-white shadow-sm">
            <div class="bg-[#004481] px-5 py-3 text-sm font-semibold text-white" id="verify-panel-label">{{ __('verify.qr_label') }}</div>

            <div id="verify-qr-mode" class="border-b border-gray-100 bg-slate-50 px-5 py-4">
                <p class="text-sm text-gray-600">{{ __('verify.scanner_or_manual') }}</p>
                <button
                    type="button"
                    id="qr-scanner-start"
                    class="mt-3 inline-flex min-h-[48px] w-full items-center justify-center gap-2 rounded-lg bg-[#004481] px-4 py-3 text-sm font-bold text-white hover:bg-[#003366] sm:w-auto"
                >
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ __('verify.scanner_start') }}
                </button>
            </div>

            @include('partials.qr-scanner')

            <form
                id="verify-form"
                class="p-6"
                data-submit-url="{{ portal_route('documents.verify.submit') }}"
                data-not-found="{{ e(__('verify.not_found')) }}"
                data-label-qr="{{ __('verify.qr_label') }}"
                data-label-code="{{ __('verify.code_label') }}"
                data-msg-success-title="{{ __('verify.success_title') }}"
                data-msg-success-desc="{{ __('verify.success_desc') }}"
                data-msg-qr-success-title="{{ __('verify.qr_success_title') }}"
                data-msg-qr-success-desc="{{ __('verify.qr_success_desc') }}"
                data-label-holder="{{ __('verify.holder') }}"
                data-label-nie="{{ __('verify.nie') }}"
                data-label-dossier="{{ __('verify.dossier') }}"
                data-label-license-valid="{{ __('verify.license_valid') }}"
                data-label-points="{{ __('verify.points') }}"
                data-label-categories="{{ __('verify.categories') }}"
                data-label-admin-status="{{ __('verify.administrative_status') }}"
                data-label-issued="{{ __('verify.issued_at') }}"
                data-label-photo="{{ __('verify.holder_photo') }}"
                data-label-verified-at="{{ __('verify.verified_at') }}"
                data-auto-verify-qr="{{ ! empty($autoVerifyQr) ? '1' : '0' }}"
            >
                @csrf
                <div id="verify-manual-wrap">
                <div id="verify-field-qr">
                    <label for="verify-qr-input" class="mb-2 block text-sm font-medium text-gray-700">{{ __('verify.qr_input_label') }}</label>
                    <textarea
                        name="qr_token"
                        id="verify-qr-input"
                        rows="3"
                        placeholder="{{ __('verify.qr_placeholder') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 font-mono text-sm uppercase tracking-wide focus:border-[#004481] focus:outline-none focus:ring-2 focus:ring-[#004481]/30"
                    >{{ $prefillQr ?? '' }}</textarea>
                    <p class="mt-2 text-xs text-gray-500">{{ __('verify.qr_help') }}</p>
                </div>
                </div>
                <div id="verify-field-code" class="hidden">
                    <label for="verify-code-input" class="mb-2 block text-sm font-medium text-gray-700">{{ __('verify.code_label') }}</label>
                    <input
                        type="text"
                        name="verification_code"
                        id="verify-code-input"
                        value="{{ $authCode ?? '' }}"
                        placeholder="{{ __('verify.code_placeholder') }}"
                        class="w-full rounded-lg border border-gray-300 px-4 py-3 font-mono text-lg uppercase tracking-wider focus:border-[#004481] focus:outline-none focus:ring-2 focus:ring-[#004481]/30"
                    />
                </div>
                <button type="submit" class="mt-4 w-full rounded-lg bg-[#004481] py-3 text-sm font-semibold text-white hover:bg-[#003366]">
                    {{ __('verify.verify_btn') }}
                </button>
            </form>
            <div id="verify-result" class="hidden border-t border-gray-100 p-6"></div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
(function () {
    const form = document.getElementById('verify-form');
    const loader = document.getElementById('portal-search-loader');
    const result = document.getElementById('verify-result');
    const submitUrl = form?.dataset.submitUrl ?? '';
    const notFoundMsg = form?.dataset.notFound ?? '';
    const MIN_MS = 2200;
    const qrField = document.getElementById('verify-field-qr');
    const codeField = document.getElementById('verify-field-code');
    const qrInput = document.getElementById('verify-qr-input');
    const codeInput = document.getElementById('verify-code-input');
    const panelLabel = document.getElementById('verify-panel-label');
    const codeHint = document.querySelector('.verify-code-hint');
    let activeTab = 'qr';

    const tabLabels = {
        qr: form?.dataset.labelQr ?? '',
        code: form?.dataset.labelCode ?? '',
    };
    const i18n = {
        successTitle: form?.dataset.msgSuccessTitle ?? '',
        successDesc: form?.dataset.msgSuccessDesc ?? '',
        qrSuccessTitle: form?.dataset.msgQrSuccessTitle ?? '',
        qrSuccessDesc: form?.dataset.msgQrSuccessDesc ?? '',
        holder: form?.dataset.labelHolder ?? '',
        nie: form?.dataset.labelNie ?? '',
        dossier: form?.dataset.labelDossier ?? '',
        licenseValid: form?.dataset.labelLicenseValid ?? '',
        points: form?.dataset.labelPoints ?? '',
        categories: form?.dataset.labelCategories ?? '',
        adminStatus: form?.dataset.labelAdminStatus ?? '',
        issuedAt: form?.dataset.labelIssued ?? '',
        photo: form?.dataset.labelPhoto ?? '',
        verifiedAt: form?.dataset.labelVerifiedAt ?? '',
    };

    document.querySelectorAll('.verify-tab').forEach((btn) => {
        btn.addEventListener('click', () => {
            activeTab = btn.dataset.verifyTab;
            document.querySelectorAll('.verify-tab').forEach((b) => {
                const on = b.dataset.verifyTab === activeTab;
                b.classList.toggle('bg-[#004481]', on);
                b.classList.toggle('text-white', on);
                b.classList.toggle('text-gray-700', !on);
                b.setAttribute('aria-selected', on ? 'true' : 'false');
            });
            qrField?.classList.toggle('hidden', activeTab !== 'qr');
            codeField?.classList.toggle('hidden', activeTab !== 'code');
            codeHint?.classList.toggle('hidden', activeTab !== 'code');
            if (panelLabel) panelLabel.textContent = tabLabels[activeTab] ?? '';
        });
    });

    function renderResult(data) {
        result.classList.remove('hidden');
        if (data.found) {
            const statusClass = data.license_status === 'valid'
                ? 'border-emerald-200 bg-emerald-50 text-emerald-900'
                : 'border-amber-200 bg-amber-50 text-amber-900';
            const title = data.qr_verified ? i18n.qrSuccessTitle : i18n.successTitle;
            const desc = data.qr_verified ? i18n.qrSuccessDesc : i18n.successDesc;
            const maxPts = data.max_points ?? 12;
            result.innerHTML = `
                <div class="rounded-lg border p-4 text-sm ${statusClass}">
                    <p class="font-bold">${title}</p>
                    <p class="mt-1 opacity-90">${desc}</p>
                    ${data.license_status_label ? `<p class="mt-3 inline-flex rounded-full bg-white/80 px-3 py-1 text-xs font-bold uppercase">${data.license_status_label}</p>` : ''}
                    <div class="mt-4 flex flex-col gap-4 sm:flex-row sm:items-start">
                        ${data.photo_url ? `
                        <div class="shrink-0 text-center">
                            <p class="mb-2 text-xs font-semibold uppercase text-gray-600">${i18n.photo}</p>
                            <img src="${data.photo_url}" alt="" class="mx-auto h-28 w-24 rounded-lg border border-white/80 object-cover object-top shadow" width="96" height="112" />
                        </div>` : ''}
                        <dl class="min-w-0 flex-1 space-y-2">
                            <div><dt class="text-gray-600">${i18n.holder}</dt><dd class="font-semibold">${data.holder ?? '—'}</dd></div>
                            <div><dt class="text-gray-600">${i18n.nie}</dt><dd class="font-mono">${data.nie ?? '—'}</dd></div>
                            <div><dt class="text-gray-600">${i18n.dossier}</dt><dd class="font-mono">${data.dossier_number || '—'}</dd></div>
                            ${data.categories ? `<div><dt class="text-gray-600">${i18n.categories}</dt><dd class="font-semibold">${data.categories}</dd></div>` : ''}
                            ${data.administrative_status ? `<div><dt class="text-gray-600">${i18n.adminStatus}</dt><dd>${data.administrative_status}</dd></div>` : ''}
                            ${data.license_issued_at ? `<div><dt class="text-gray-600">${i18n.issuedAt}</dt><dd>${data.license_issued_at}</dd></div>` : ''}
                            ${data.license_valid_until ? `<div><dt class="text-gray-600">${i18n.licenseValid}</dt><dd>${data.license_valid_until}</dd></div>` : ''}
                            ${data.points != null ? `<div><dt class="text-gray-600">${i18n.points}</dt><dd>${data.points} / ${maxPts}</dd></div>` : ''}
                            ${data.verified_at ? `<div><dt class="text-gray-600">${i18n.verifiedAt}</dt><dd>${data.verified_at}</dd></div>` : ''}
                        </dl>
                    </div>
                </div>`;
        } else {
            result.innerHTML = `<p class="text-sm text-amber-800">${data.message || notFoundMsg}</p>`;
        }
    }

    form?.addEventListener('submit', async (e) => {
        e.preventDefault();
        loader?.classList.remove('hidden');
        loader?.classList.add('flex');
        result?.classList.add('hidden');
        const started = Date.now();

        const body = activeTab === 'qr'
            ? { qr_token: qrInput?.value?.trim() ?? '' }
            : { verification_code: codeInput?.value?.trim() ?? '' };

        try {
            const res = await fetch(submitUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify(body),
            });
            const data = await res.json();
            const wait = Math.max(0, MIN_MS - (Date.now() - started));
            setTimeout(() => {
                loader?.classList.add('hidden');
                loader?.classList.remove('flex');
                renderResult(data);
            }, wait);
        } catch {
            loader?.classList.add('hidden');
            loader?.classList.remove('flex');
        }
    });

    if (form?.dataset.autoVerifyQr === '1' && qrInput?.value?.trim()) {
        setTimeout(() => form?.requestSubmit(), 400);
    }
})();
</script>
@endpush
