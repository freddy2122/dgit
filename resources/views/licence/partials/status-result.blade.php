@php
    $legacyResult = $result ?? null;
@endphp

@include('licence.partials.status-result-rich', [
    'user' => $user ?? $legacyResult?->user ?? null,
    'application' => $application ?? $legacyResult ?? null,
    'payload' => $payload ?? [],
    'photoSrc' => $photoSrc ?? null,
])
