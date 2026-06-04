<div class="midgt-app mx-auto w-full max-w-[390px]">
    <article class="midgt-app__card">
        {{-- Hero profil + puntos (capture miDGT) --}}
        <section class="midgt-hero" aria-label="miDGT">
            <img
                src="{{ asset('images/hero-trafico.png') }}"
                alt=""
                class="midgt-hero__skyline"
                loading="lazy"
                width="400"
                height="52"
                aria-hidden="true"
            />

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
                <a href="{{ $pointsUrl }}" class="midgt-points-ring" aria-label="{{ __('status.points_label') }}: {{ $pts }}">
                    <span class="midgt-points-ring__value">{{ $pts }}</span>
                    <span class="midgt-points-ring__label">{{ __('status.points_label') }}</span>
                </a>
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
                @elseif ($hasDossier)
                    <p class="midgt-hero__wow">{{ __('status.exam_midgt_wow') }}</p>
                    <p class="midgt-hero__line">{{ __('status.exam_midgt_passed_line') }}</p>
                    <a href="{{ $approveHref }}" class="midgt-hero__link">{{ __('status.exam_midgt_pass_link') }} &gt;</a>
                @endif
            </div>
        </section>

        @if ($heldCategories !== [] || $requestedCategory || $tramiteLabel)
            <section class="midgt-permits" aria-label="{{ __('status.permits_section') }}">
                <div class="midgt-permits__row">
                    <span class="midgt-permits__label">{{ __('status.permits_held') }}</span>
                    @if ($heldCategories !== [])
                        <div class="midgt-permits__chips">
                            @foreach ($heldCategories as $code)
                                <span class="midgt-permits__chip midgt-permits__chip--held">{{ $code }}</span>
                            @endforeach
                        </div>
                    @else
                        <span class="midgt-permits__empty">{{ __('status.permits_none_held') }}</span>
                    @endif
                </div>
                @if ($application)
                    <div class="midgt-permits__row">
                        <span class="midgt-permits__label">{{ __('status.permits_requested') }}</span>
                        <div class="midgt-permits__chips">
                            @if ($requestedCategory)
                                <span class="midgt-permits__chip midgt-permits__chip--requested">{{ $requestedCategory }}</span>
                            @endif
                            @if ($tramiteLabel)
                                <span class="midgt-permits__chip midgt-permits__chip--tramite">{{ $tramiteLabel }}</span>
                            @endif
                        </div>
                    </div>
                @endif
            </section>
        @endif

        {{-- Onglets MIS VEHÍCULOS | VALIDACIÓN EN CURSO… --}}
        <nav class="midgt-tabs" role="tablist" aria-label="{{ __('status.midgt_tabs_label') }}">
            <button type="button" class="midgt-tabs__btn is-active" data-midgt-tab="vehicles" role="tab" aria-selected="true" id="midgt-tab-vehicles">
                {{ __('status.my_vehicles') }}
            </button>
            @if ($showProgressTab)
                <button type="button" class="midgt-tabs__btn" data-midgt-tab="validation" role="tab" aria-selected="false" id="midgt-tab-validation">
                    {{ __('status.exam_validation_tab', ['percent' => $validationPct]) }}
                </button>
            @endif
        </nav>

        <div class="midgt-panel is-active" data-midgt-panel="vehicles" role="tabpanel" aria-labelledby="midgt-tab-vehicles">
            <a href="{{ $vehiclesUrl }}" class="midgt-vehicle-tile">
                <div class="midgt-vehicle-tile__visual">
                    <svg viewBox="0 0 140 56" fill="none" aria-hidden="true">
                        <path fill="#ffffff" d="M18 40h94l6-10h14l4 10H18z"/>
                        <path fill="#f5f7f9" d="M24 28h72l10-14h16l6 14H24z"/>
                        <circle cx="36" cy="44" r="7" fill="#ffffff"/>
                        <circle cx="94" cy="44" r="7" fill="#ffffff"/>
                        <rect x="48" y="30" width="28" height="10" rx="2" fill="#e8ecef" opacity="0.9"/>
                    </svg>
                </div>
                <p class="midgt-vehicle-tile__label">{{ __('status.vehicles_card_label') }}</p>
            </a>
        </div>

        @if ($showProgressTab)
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
        @elseif ($hasDossier && auth()->check() && auth()->id() === $profileUser->id)
            <p class="midgt-permits__hint px-4 pb-3 text-xs text-gray-600">
                {{ __('status.no_application_progress') }}
                <a href="{{ portal_route('portal.demarches') }}" class="font-semibold text-[#00a9b8] hover:underline">{{ __('status.open_demarches') }}</a>
            </p>
        @endif

        {{-- ACTUALIDAD DGT --}}
        @if (count($newsItems) > 0)
            <section class="midgt-news" aria-label="{{ __('status.news_section_title') }}">
                <h2 class="midgt-news__title">{{ __('status.news_section_title') }}</h2>
                <div class="midgt-news__scroll">
                    @foreach ($newsItems as $item)
                        @php
                            $configuredImage = (string) ($item['image'] ?? '');
                            $fallbackImage = $loop->even ? 'images/sede-electronica-promo.png' : 'images/hero-trafico.png';
                            $isExternalImage = str_starts_with($configuredImage, 'http://') || str_starts_with($configuredImage, 'https://');
                            $resolvedImage = $isExternalImage || ($configuredImage !== '' && file_exists(public_path($configuredImage)))
                                ? $configuredImage
                                : $fallbackImage;
                        @endphp
                        <a href="{{ portal_route('home') }}" class="midgt-news__item">
                            <img src="{{ $isExternalImage ? $resolvedImage : asset($resolvedImage) }}" alt="" loading="lazy" width="200" height="100" />
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
                @if ($heldCategories !== [])
                    <div class="flex justify-between gap-3">
                        <span class="text-gray-500">{{ __('status.permits_held') }}</span>
                        <span class="font-mono font-semibold">{{ implode(' · ', $heldCategories) }}</span>
                    </div>
                @endif
                @if ($requestedCategory)
                    <div class="flex justify-between gap-3">
                        <span class="text-gray-500">{{ __('status.permits_requested') }}</span>
                        <span class="font-mono font-semibold text-[#0077b3]">{{ $requestedCategory }}</span>
                    </div>
                @endif
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
