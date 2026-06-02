@php
    $legacyResult = $result ?? null;
    $profileUser = $user ?? $legacyResult?->user;
    $found = $payload['found'] ?? (bool) $profileUser;
    $license = $profileUser?->licenseSummary;
    $application = $application ?? $legacyResult;
    if (! $application && $profileUser) {
        $application = $profileUser->relationLoaded('permitApplications')
            ? $profileUser->permitApplications->sortByDesc('id')->first()
            : $profileUser->permitApplications()->latest('id')->first();
    }
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

    <div class="flex justify-center py-2">
        @include('licence.partials.status-result-midgt', [
            'user' => $profileUser,
            'profileUser' => $profileUser,
            'license' => $license,
            'application' => $application,
            'payload' => $payload,
            'photoSrc' => $photoSrc ?? null,
        ])
    </div>

    @if (! empty($payload['exam']['show']))
        @include('licence.partials.status-exam-result-sede', [
            'payload' => $payload,
            'exam' => $payload['exam'],
        ])
    @endif
@endif
