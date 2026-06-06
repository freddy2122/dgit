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
    $newsItems = collect(config('dgt_midgt_news', []))
        ->filter(function (array $item) use ($newsLocale): bool {
            $title = trim((string) ($item[$newsLocale] ?? $item['title_es'] ?? $item['title_fr'] ?? ''));

            return $title !== '';
        })
        ->values()
        ->all();
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

<div class="status-result-responsive w-full">
    {{-- Bureau par défaut (md et plus) ; carte miDGT sur petit écran --}}
    <div class="status-result-responsive__desktop max-md:hidden">
        @include('licence.partials.status-result-midgt-desktop')
    </div>

    <div class="status-result-responsive__mobile hidden max-md:block">
        @include('licence.partials.status-result-midgt-mobile')
    </div>
</div>

@once
    @push('head')
        <link rel="stylesheet" href="{{ asset('css/status-midgt-pixel.css') }}?v=11" />
    @endpush
    @push('scripts')
        <script>
            document.querySelectorAll('.midgt-validation__bar[data-pct]').forEach((bar) => {
                const pct = Math.min(100, Math.max(0, Number(bar.dataset.pct) || 0));
                const fill = bar.querySelector('.midgt-validation__fill');
                if (fill) {
                    fill.style.width = pct + '%';
                }
            });

            document.querySelectorAll('[data-midgt-tab]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.midgtTab;
                    const root = btn.closest('.midgt-app');
                    if (!root) {
                        return;
                    }
                    root.querySelectorAll('[data-midgt-tab]').forEach((b) => {
                        const on = b.dataset.midgtTab === id;
                        b.classList.toggle('is-active', on);
                        b.setAttribute('aria-selected', on ? 'true' : 'false');
                    });
                    root.querySelectorAll('[data-midgt-panel]').forEach((panel) => {
                        const on = panel.dataset.midgtPanel === id;
                        panel.classList.toggle('is-active', on);
                        panel.hidden = !on;
                    });
                });
            });
        </script>
    @endpush
@endonce
