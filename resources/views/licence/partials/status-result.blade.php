@include('licence.partials.status-result-rich', [
    'user' => $user ?? $result?->user ?? null,
    'application' => $application ?? $result ?? null,
    'payload' => $payload ?? [],
    'photoSrc' => $photoSrc ?? null,
])
