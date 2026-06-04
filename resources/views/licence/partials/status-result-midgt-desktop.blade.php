<div class="status-desktop w-full">
    <header class="status-desktop__header">
        <div class="status-desktop__profile">
            <div class="status-desktop__photo">
                @include('portal.partials.license-photo', [
                    'user' => $profileUser,
                    'photoClass' => 'h-full w-full object-cover object-top',
                    'photoSrc' => $photoSrc ?? null,
                ])
            </div>
            <div class="status-desktop__identity">
                <p class="status-desktop__hello">{{ __('status.greeting_hello') }} <span class="status-desktop__name">{{ $fullName }}</span></p>
                @if ($showExam && $examPassed)
                    <p class="status-desktop__lead">{{ __('status.exam_midgt_passed_line') }}</p>
                    <a href="#resultado-examen" class="status-desktop__action">{{ __('status.exam_midgt_pass_link') }} →</a>
                @elseif ($showExam && ! $examPassed)
                    <p class="status-desktop__lead">{{ __('status.exam_midgt_failed_line') }}</p>
                    <a href="#resultado-examen" class="status-desktop__action">{{ __('status.exam_midgt_see_result') }} →</a>
                @elseif ($application)
                    <p class="status-desktop__lead">{{ __('status.desktop_dossier_lead', ['status' => $payload['status'] ?? permit_status_label($application->status)]) }}</p>
                @endif
            </div>
        </div>
        <a href="{{ $pointsUrl }}" class="status-desktop__points">
            @include('portal.partials.points-ring', ['pts' => $pts, 'max' => $payload['max_points'] ?? 12, 'ringClass' => 'h-24 w-24'])
        </a>
    </header>

    <div class="status-desktop__grid">
        <div class="status-desktop__main">
            <section class="status-desktop__card">
                <h2 class="status-desktop__card-title">{{ __('status.dossier_details') }}</h2>
                <dl class="status-desktop__dl">
                    <div class="status-desktop__dl-row">
                        <dt>{{ __('status.reference') }}</dt>
                        <dd class="font-mono">{{ $payload['reference'] ?? $application?->reference_code ?? '—' }}</dd>
                    </div>
                    <div class="status-desktop__dl-row">
                        <dt>{{ __('status.file_status') }}</dt>
                        <dd>{{ $payload['status'] ?? permit_status_label($application?->status) }}</dd>
                    </div>
                    @if ($tramiteLabel)
                        <div class="status-desktop__dl-row">
                            <dt>{{ __('status.tramite_type') }}</dt>
                            <dd>{{ $tramiteLabel }}</dd>
                        </div>
                    @endif
                    <div class="status-desktop__dl-row">
                        <dt>{{ __('status.permits_held') }}</dt>
                        <dd class="font-mono">
                            @if ($heldCategories !== [])
                                {{ implode(' · ', $heldCategories) }}
                            @else
                                {{ __('status.permits_none_held') }}
                            @endif
                        </dd>
                    </div>
                    @if ($requestedCategory)
                        <div class="status-desktop__dl-row">
                            <dt>{{ __('status.permits_requested') }}</dt>
                            <dd class="font-mono font-semibold text-[#004481]">{{ $requestedCategory }}</dd>
                        </div>
                    @endif
                    <div class="status-desktop__dl-row">
                        <dt>{{ __('status.your_code') }}</dt>
                        <dd class="font-mono">{{ $payload['verification_code'] ?? $profileUser->verification_code }}</dd>
                    </div>
                </dl>
                @auth
                    @if (auth()->id() === $profileUser->id && $application?->id)
                        <a href="{{ portal_route('portal.tramite.show', ['application' => $application->id]) }}" class="status-desktop__action mt-4 inline-block">
                            {{ __('status.view_dossier') }} →
                        </a>
                    @endif
                @endauth
            </section>

            @if ($showProgressTab)
                <section class="status-desktop__card">
                    <h2 class="status-desktop__card-title">{{ __('status.desktop_validation_title', ['percent' => $validationPct]) }}</h2>
                    <div
                        class="midgt-validation__bar status-desktop__bar"
                        role="progressbar"
                        aria-valuenow="{{ $validationPct }}"
                        aria-valuemin="0"
                        aria-valuemax="100"
                        data-pct="{{ $validationPct }}"
                    >
                        <div class="midgt-validation__fill"></div>
                    </div>
                    <p class="status-desktop__muted">{{ __('status.exam_validation_body', ['percent' => $validationPct]) }}</p>
                </section>
            @elseif ($hasDossier && auth()->check() && auth()->id() === $profileUser->id)
                <p class="status-desktop__muted">{{ __('status.no_application_progress') }}
                    <a href="{{ portal_route('portal.demarches') }}" class="status-desktop__action">{{ __('status.open_demarches') }}</a>
                </p>
            @endif
        </div>

        <aside class="status-desktop__aside">
            <section class="status-desktop__card">
                <h2 class="status-desktop__card-title">{{ __('status.my_vehicles') }}</h2>
                <a href="{{ $vehiclesUrl }}" class="status-desktop__vehicles-link">
                    <span class="status-desktop__vehicles-icon" aria-hidden="true">🚗</span>
                    <span>{{ __('status.vehicles_card_label') }}</span>
                    @if ($vehicles->isNotEmpty())
                        <span class="status-desktop__muted">({{ $vehicles->count() }})</span>
                    @endif
                </a>
            </section>

            @if (count($newsItems) > 0)
                <section class="status-desktop__card">
                    <h2 class="status-desktop__card-title">{{ __('status.news_section_title') }}</h2>
                    <ul class="status-desktop__news">
                        @foreach ($newsItems as $item)
                            @php
                                $configuredImage = (string) ($item['image'] ?? '');
                                $fallbackImage = $loop->even ? 'images/sede-electronica-promo.png' : 'images/hero-trafico.png';
                                $isExternalImage = str_starts_with($configuredImage, 'http://') || str_starts_with($configuredImage, 'https://');
                                $resolvedImage = $isExternalImage || ($configuredImage !== '' && file_exists(public_path($configuredImage)))
                                    ? $configuredImage
                                    : $fallbackImage;
                            @endphp
                            <li>
                                <a href="{{ portal_route('home') }}" class="status-desktop__news-item">
                                    <img src="{{ $isExternalImage ? $resolvedImage : asset($resolvedImage) }}" alt="" loading="lazy" width="280" height="140" />
                                    <span>{{ $item[$newsLocale] ?? $item['title_es'] ?? '' }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </section>
            @endif
        </aside>
    </div>
</div>
