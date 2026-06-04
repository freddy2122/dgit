@php
    $profileUser = $profileUser ?? $user;
    $license = $license ?? $profileUser?->licenseSummary;
    if (! ($application ?? null) && $profileUser) {
        $application = $profileUser->relationLoaded('permitApplications')
            ? $profileUser->permitApplications->sortByDesc('id')->first()
            : $profileUser->permitApplications()->latest('id')->first();
    }
    $vehicles = $profileUser?->vehicles ?? collect();
    $pts = (int) ($payload['points'] ?? $license?->points ?? 0);
    $exam = $payload['exam'] ?? [];
    $showExam = ! empty($exam['show']);
    $examPassed = (bool) ($exam['passed'] ?? false);
    $validationPct = max(0, min(100, (int) (
        $application
            ? (new \App\Support\ExamResultPresenter($application, $profileUser, $license))->validationPercent()
            : ($exam['validation_percent'] ?? 80)
    )));
    $fullName = mb_strtoupper(trim(collect([$profileUser->last_name, $profileUser->first_name])->filter()->join(' ') ?: (string) ($profileUser->name ?? '')));
    if ($fullName === '') {
        $fullName = mb_strtoupper(__('status.holder_default'));
    }
    $newsLocale = portal_locale() === 'fr' ? 'title_fr' : 'title_es';
    $newsItems = config('dgt_midgt_news', []);
    $vehiclesUrl = auth()->check() && auth()->id() === $profileUser->id
        ? portal_route('vehicles.report')
        : portal_route('login');
    $pointsUrl = auth()->check() && auth()->id() === $profileUser->id
        ? portal_route('licence.points')
        : portal_route('login');
    $hasDossier = (bool) ($application || $license);
    $approveHref = $showExam
        ? '#resultado-examen'
        : portal_licence_status_href(['view' => 'result']);
    $heldCategories = $payload['held_categories'] ?? ($license ? $license->heldCategoryCodesForDisplay() : []);
    $requestedCategory = $payload['requested_category'] ?? $application?->displayRequestedCategory($license);
    $tramiteLabel = $payload['tramite_type'] ?? (
        $application?->tramite_type
            ? app(\App\Services\PermitTramiteService::class)->typeLabel($application->tramite_type)
            : null
    );
    $showProgressTab = (bool) $application;
@endphp
