@php
    $profileUser = $profileUser ?? $user;
    $license = $license ?? $profileUser?->licenseSummary;
    $vehicles = $profileUser?->vehicles ?? collect();
    $pts = (int) ($payload['points'] ?? $license?->points ?? 0);
    $exam = $payload['exam'] ?? [];
    $showExam = ! empty($exam['show']);
    $examPassed = (bool) ($exam['passed'] ?? false);
    $validationPct = max(0, min(100, (int) ($exam['validation_percent'] ?? 80)));
    $fullName = mb_strtoupper(trim(collect([$profileUser->last_name, $profileUser->first_name])->filter()->join(' ') ?: (string) ($profileUser->name ?? '')));
    if ($fullName === '') {
        $fullName = mb_strtoupper(__('status.holder_default'));
    }
    $newsLocale = portal_locale() === 'fr' ? 'title_fr' : 'title_es';
    $newsItems = config('dgt_midgt_news', []);
    $vehiclesUrl = auth()->check() && auth()->id() === $profileUser->id
        ? portal_route('vehicles.report')
        : portal_route('login');
@endphp

<div class="midgt-app mx-auto w-full max-w-[390px]">
    <article class="midgt-app__card">
        {{-- Hero profil + puntos (capture miDGT) --}}
        <section class="midgt-hero" aria-label="miDGT">
            <svg class="midgt-hero__skyline" viewBox="0 0 400 52" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path fill="var(--midgt-skyline)" d="M0 52 L0 38 L25 34 L50 40 L75 28 L100 36 L125 24 L150 32 L175 22 L200 30 L225 20 L250 28 L275 18 L300 26 L325 16 L350 24 L375 18 L400 22 L400 52 Z"/>
            </svg>

            <div class="midgt-hero__top">
                <div class="midgt-hero__photo">
                    @include('portal.partials.license-photo', [
                        'user' => $profileUser,
                        'photoClass' => 'h-full w-full object-cover object-top',
                        'photoSrc' => $photoSrc ?? null,
                    ])
                </div>
                <div class="midgt-hero__identity">
                    <span class="midgt-hero__hello">{{ __('status.greeting_hello') }}</span>
                    <span class="midgt-hero__name">{{ $fullName }}</span>
                </div>
                <div class="midgt-points-ring" aria-label="{{ __('status.points_label') }}: {{ $pts }}">
                    <span class="midgt-points-ring__value">{{ $pts }}</span>
                    <span class="midgt-points-ring__label">{{ __('status.points_label') }}</span>
                </div>
            </div>

            <div class="midgt-hero__status">
                @if ($showExam && $examPassed)
                    <p class="midgt-hero__wow">{{ __('status.exam_midgt_wow') }}</p>
                    <p class="midgt-hero__line">{{ __('status.exam_midgt_passed_line') }}</p>
                    <a href="#resultado-examen" class="midgt-hero__link">{{ __('status.exam_midgt_pass_link') }} &gt;</a>
                @elseif ($showExam && ! $examPassed)
                    <p class="midgt-hero__wow">{{ __('status.exam_midgt_wow') }}</p>
                    <p class="midgt-hero__line">{{ __('status.exam_midgt_failed_line') }}</p>
                    <a href="#resultado-examen" class="midgt-hero__link">{{ __('status.exam_midgt_see_result') }} &gt;</a>
                @else
                    <p class="midgt-hero__line">{{ __('status.exam_midgt_points_default') }}</p>
                @endif
            </div>
        </section>

        {{-- Onglets MIS VEHÍCULOS | VALIDACIÓN EN CURSO… --}}
        <nav class="midgt-tabs" role="tablist" aria-label="{{ __('status.midgt_tabs_label') }}">
            <button type="button" class="midgt-tabs__btn is-active" data-midgt-tab="vehicles" role="tab" aria-selected="true" id="midgt-tab-vehicles">
                {{ __('status.my_vehicles') }}
            </button>
            <button type="button" class="midgt-tabs__btn" data-midgt-tab="validation" role="tab" aria-selected="false" id="midgt-tab-validation">
                {{ __('status.exam_validation_tab', ['percent' => $validationPct]) }}
            </button>
        </nav>

        <div class="midgt-panel is-active" data-midgt-panel="vehicles" role="tabpanel" aria-labelledby="midgt-tab-vehicles">
            <a href="{{ $vehiclesUrl }}" class="midgt-vehicle-tile">
                <div class="midgt-vehicle-tile__visual">
                    <svg viewBox="0 0 120 48" fill="#ffffff" aria-hidden="true">
                        <path d="M8 34h88l5-8h10l3 8H8z M14 24h68l8-12h12l5 12H14z" opacity="0.95"/>
                        <circle cx="28" cy="38" r="6"/><circle cx="82" cy="38" r="6"/>
                    </svg>
                </div>
                <p class="midgt-vehicle-tile__label">{{ __('status.vehicles_card_label') }}</p>
                @if ($vehicles->isNotEmpty())
                    <span class="midgt-vehicle-tile__plate">{{ $vehicles->first()->plate }}</span>
                @endif
            </a>
        </div>

        <div class="midgt-panel" data-midgt-panel="validation" role="tabpanel" aria-labelledby="midgt-tab-validation" hidden>
            <div class="midgt-validation">
                <div
                    class="midgt-validation__bar"
                    role="progressbar"
                    aria-valuenow="{{ $validationPct }}"
                    aria-valuemin="0"
                    aria-valuemax="100"
                    data-pct="{{ $validationPct }}"
                >
                    <div class="midgt-validation__fill"></div>
                </div>
                <p class="midgt-validation__text">{{ __('status.exam_validation_body', ['percent' => $validationPct]) }}</p>
                @if ($application?->reference_code)
                    <p class="mt-3 text-xs text-gray-500">
                        <span class="font-semibold text-gray-700">{{ __('status.reference') }}:</span>
                        <span class="font-mono">{{ $application->reference_code }}</span>
                    </p>
                @endif
            </div>
        </div>

        {{-- ACTUALIDAD DGT --}}
        @if (count($newsItems) > 0)
            <section class="midgt-news" aria-label="{{ __('status.news_section_title') }}">
                <h2 class="midgt-news__title">{{ __('status.news_section_title') }}</h2>
                <div class="midgt-news__scroll">
                    @foreach ($newsItems as $item)
                        <a href="{{ portal_route('home') }}" class="midgt-news__item">
                            <img src="{{ asset($item['image'] ?? 'images/logo_dgt.svg') }}" alt="" loading="lazy" width="200" height="100" />
                            <p class="midgt-news__caption">{{ $item[$newsLocale] ?? $item['title_es'] ?? '' }}</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <details class="midgt-dossier group">
            <summary>{{ __('status.dossier_details') }}</summary>
            <div class="midgt-dossier__body space-y-2">
                <div class="flex justify-between gap-3">
                    <span class="text-gray-500">{{ __('status.reference') }}</span>
                    <span class="font-mono font-semibold">{{ $payload['reference'] ?? $application?->reference_code ?? '—' }}</span>
                </div>
                <div class="flex justify-between gap-3">
                    <span class="text-gray-500">{{ __('status.file_status') }}</span>
                    <span class="font-semibold text-[#0077b3]">{{ $payload['status'] ?? permit_status_label($application?->status) }}</span>
                </div>
                <div class="flex justify-between gap-3">
                    <span class="text-gray-500">{{ __('status.your_code') }}</span>
                    <span class="font-mono font-semibold">{{ $payload['verification_code'] ?? $profileUser->verification_code }}</span>
                </div>
                @auth
                    @if (auth()->id() === $profileUser->id && $application?->id)
                        <a href="{{ portal_route('portal.tramite.show', ['application' => $application->id]) }}" class="mt-2 inline-block text-sm font-semibold text-[#00a9b8] hover:underline">
                            {{ __('status.view_dossier') }} →
                        </a>
                    @endif
                @endauth
            </div>
        </details>
    </article>
</div>

@once
    @push('head')
        <link rel="stylesheet" href="{{ asset('css/status-midgt-pixel.css') }}?v=1" />
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
                    document.querySelectorAll('[data-midgt-tab]').forEach((b) => {
                        const on = b.dataset.midgtTab === id;
                        b.classList.toggle('is-active', on);
                        b.setAttribute('aria-selected', on ? 'true' : 'false');
                    });
                    document.querySelectorAll('[data-midgt-panel]').forEach((panel) => {
                        const on = panel.dataset.midgtPanel === id;
                        panel.classList.toggle('is-active', on);
                        panel.hidden = !on;
                    });
                });
            });
        </script>
    @endpush
@endonce
