@php
    $found = $payload['found'] ?? (bool) ($user ?? $result?->user);
    $profileUser = $user ?? $result?->user;
    $license = $profileUser?->licenseSummary;
    $application = $application ?? $result;
@endphp

@if (! $found || ! $profileUser)
    <div class="rounded-lg border border-amber-200 bg-amber-50 p-4 text-sm text-amber-900">
        <p class="font-semibold">{{ __('status.no_result') }}</p>
        <p class="mt-2">{{ __('status.no_result_hint') }}</p>
        <div class="mt-4 flex flex-wrap gap-3">
            <a href="{{ portal_route('portal.inscription') }}" class="font-semibold text-[#004481] hover:underline">{{ __('status.register_cta') }}</a>
            <a href="{{ portal_route('login') }}" class="font-semibold text-[#004481] hover:underline">{{ __('status.login_cta') }}</a>
        </div>
    </div>
@else
    @if (! empty($payload['account_inactive']))
        <p class="mb-4 rounded-lg border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-900">
            {{ __('status.account_inactive_notice') }}
        </p>
    @endif

    @include('licence.partials.status-result-midgt', [
        'user' => $profileUser,
        'profileUser' => $profileUser,
        'license' => $license,
        'application' => $application,
        'payload' => $payload,
        'photoSrc' => $photoSrc ?? null,
    ])
@endif
