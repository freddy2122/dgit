@php
    $profileUser = $profileUser ?? $user;
    $license = $license ?? $profileUser?->licenseSummary;
    $vehicles = $profileUser?->vehicles ?? collect();
    $pts = (int) ($payload['points'] ?? $license?->points ?? 0);
    $maxPts = (int) ($payload['max_points'] ?? \App\Models\LicenseSummary::MAX_POINTS);
    $firstName = ucfirst(mb_strtolower((string) ($profileUser->first_name ?: strtok((string) $profileUser->name, ' ') ?: __('status.holder_default'))));
    $canViewLicense = $license?->isPublishedForClient();
    $licenseUrl = auth()->check() && auth()->id() === $profileUser->id
        ? portal_route('licence.digital')
        : (auth()->check() ? portal_route('licence.digital') : portal_route('login'));
@endphp

<div class="status-midgt mx-auto max-w-lg overflow-hidden rounded-2xl border border-gray-200 bg-white shadow-lg">
    {{-- En-tête profil --}}
    <div class="flex items-center gap-4 px-5 pb-4 pt-5">
        <div class="h-[4.5rem] w-[4.5rem] shrink-0 overflow-hidden rounded-full border-2 border-sky-200 bg-sky-100 shadow-inner">
            @include('portal.partials.license-photo', [
                'user' => $profileUser,
                'photoClass' => 'h-full w-full object-cover object-top',
                'photoSrc' => $photoSrc ?? null,
            ])
        </div>
        <div class="min-w-0">
            <p class="text-xl font-bold text-gray-900">{{ __('status.greeting', ['name' => $firstName]) }}</p>
            @if ($canViewLicense)
                <a href="{{ $licenseUrl }}" class="mt-1 inline-flex items-center gap-1 text-sm font-bold uppercase tracking-wide text-[#004481] hover:underline">
                    {{ __('status.view_license') }}
                    <span aria-hidden="true">›</span>
                </a>
            @else
                <p class="mt-1 text-xs text-gray-500">{{ __('status.license_not_active') }}</p>
            @endif
        </div>
    </div>

    {{-- Bandeau points --}}
    <div class="status-midgt-points relative overflow-hidden bg-gradient-to-b from-slate-100 to-slate-200/80 px-5 py-6">
        <div class="pointer-events-none absolute inset-x-0 bottom-0 h-16 opacity-30" aria-hidden="true">
            <svg class="h-full w-full" viewBox="0 0 400 60" preserveAspectRatio="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="#94a3b8" d="M0 60 L0 40 L30 35 L60 42 L90 28 L120 38 L150 25 L180 35 L210 22 L240 32 L270 20 L300 30 L330 18 L360 28 L400 24 L400 60 Z"/>
            </svg>
        </div>
        <div class="relative flex items-center justify-between gap-4">
            <p class="max-w-[11rem] text-sm font-semibold leading-snug text-gray-800">
                @if ($pts >= $maxPts * 0.8)
                    {{ __('status.points_congrats', ['points' => $pts]) }}
                @else
                    {{ __('status.points_balance_short', ['points' => $pts, 'max' => $maxPts]) }}
                @endif
            </p>
            <div class="status-midgt-points-badge relative shrink-0">
                <span class="status-midgt-confetti status-midgt-confetti--1" aria-hidden="true"></span>
                <span class="status-midgt-confetti status-midgt-confetti--2" aria-hidden="true"></span>
                <span class="status-midgt-confetti status-midgt-confetti--3" aria-hidden="true"></span>
                <span class="status-midgt-confetti status-midgt-confetti--4" aria-hidden="true"></span>
                <span class="status-midgt-confetti status-midgt-confetti--5" aria-hidden="true"></span>
                <div class="flex h-[5.5rem] w-[5.5rem] flex-col items-center justify-center rounded-full border-[3px] border-[#004481] bg-white shadow-md">
                    <span class="text-3xl font-black leading-none text-[#004481]">{{ $pts }}</span>
                    <span class="mt-0.5 text-[11px] font-bold uppercase text-[#004481]">{{ __('status.points_label') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Véhicules --}}
    <div class="border-t border-gray-100 px-5 py-4">
        <div class="mb-3 flex items-center justify-between">
            <h3 class="text-xs font-bold uppercase tracking-wider text-gray-800">{{ __('status.my_vehicles') }}</h3>
            @if ($vehicles->isNotEmpty() && auth()->check() && auth()->id() === $profileUser->id)
                <a href="{{ portal_route('vehicles.report') }}" class="text-[#004481] hover:text-[#003366]" aria-label="{{ __('portal.see_all') }}">›</a>
            @endif
        </div>

        @if ($vehicles->isEmpty())
            <p class="rounded-xl bg-slate-50 px-4 py-6 text-center text-sm text-gray-500">{{ __('status.no_vehicles') }}</p>
        @else
            <div class="status-midgt-vehicles -mx-1 flex gap-3 overflow-x-auto px-1 pb-2 snap-x snap-mandatory scroll-smooth" role="list">
                @foreach ($vehicles as $index => $vehicle)
                    @php
                        $hasAlert = $vehicle->status !== 'valid'
                            || ($vehicle->itv_valid_until && $vehicle->itv_valid_until->isPast());
                        $isActive = $index === 0;
                    @endphp
                    <button
                        type="button"
                        class="status-midgt-vehicle-card snap-center shrink-0 text-left {{ $isActive ? 'is-active' : '' }}"
                        data-vehicle-card
                        role="listitem"
                    >
                        <div class="status-midgt-vehicle-visual relative flex h-28 w-36 items-center justify-center rounded-lg transition {{ $isActive ? 'bg-[#004481]' : 'bg-slate-200' }}">
                            @if ($vehicle->is_motorcycle)
                                <svg class="h-14 w-20 text-white opacity-95" viewBox="0 0 80 40" fill="currentColor" aria-hidden="true">
                                    <circle cx="18" cy="30" r="6"/><circle cx="58" cy="30" r="6"/>
                                    <path d="M22 18h12l8-10h8l6 10h-20l-4 12H26L22 18z"/>
                                </svg>
                            @else
                                <svg class="h-12 w-24 text-white opacity-95" viewBox="0 0 96 40" fill="currentColor" aria-hidden="true">
                                    <path d="M8 28h72l4-6h8l2 6H8z M12 20h56l6-8h10l4 8H12z"/>
                                    <circle cx="24" cy="32" r="5"/><circle cx="68" cy="32" r="5"/>
                                </svg>
                            @endif
                            <span class="absolute bottom-2 left-1/2 flex h-7 w-7 -translate-x-1/2 items-center justify-center rounded-full {{ $hasAlert ? 'bg-red-600' : ($isActive ? 'bg-white/90 text-[#004481]' : 'bg-slate-400 text-white') }} shadow">
                                @if ($hasAlert)
                                    <svg class="h-4 w-4 text-white" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2L1 21h22L12 2zm0 4.5L18.5 19h-13L12 6.5zM11 10h2v5h-2v-5zm0 6h2v2h-2v-2z"/></svg>
                                @else
                                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" aria-hidden="true"><path d="M5 13l4 4L19 7"/></svg>
                                @endif
                            </span>
                        </div>
                        <p class="mt-2 text-center font-mono text-sm font-bold text-gray-900">{{ $vehicle->plate }}</p>
                        <p class="text-center text-[11px] font-medium uppercase text-gray-500">{{ $vehicle->vehicle_type }}</p>
                    </button>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Détails dossier (repliable) --}}
    <details class="group border-t border-gray-100 bg-slate-50/80">
        <summary class="cursor-pointer list-none px-5 py-3 text-sm font-semibold text-[#004481] marker:content-none hover:bg-slate-100/80 [&::-webkit-details-marker]:hidden">
            <span class="flex items-center justify-between">
                {{ __('status.dossier_details') }}
                <span class="text-xs font-normal text-gray-500 group-open:hidden">{{ __('status.show') }}</span>
                <span class="hidden text-xs font-normal text-gray-500 group-open:inline">{{ __('status.hide') }}</span>
            </span>
        </summary>
        <div class="space-y-3 border-t border-gray-100 px-5 py-4 text-sm">
            <div class="flex justify-between gap-4">
                <span class="text-gray-500">{{ __('status.reference') }}</span>
                <span class="font-mono font-semibold text-gray-900">{{ $payload['reference'] ?? $application?->reference_code ?? '—' }}</span>
            </div>
            <div class="flex justify-between gap-4">
                <span class="text-gray-500">{{ __('status.file_status') }}</span>
                <span class="font-semibold text-[#004481]">{{ $payload['status'] ?? permit_status_label($application?->status) }}</span>
            </div>
            <div class="flex justify-between gap-4">
                <span class="text-gray-500">{{ __('status.your_code') }}</span>
                <span class="font-mono font-semibold text-gray-900">{{ $payload['verification_code'] ?? $profileUser->verification_code }}</span>
            </div>
            @if (! empty($payload['tramite_type']))
            <div class="flex justify-between gap-4">
                <span class="text-gray-500">{{ __('status.tramite_type') }}</span>
                <span class="font-semibold text-gray-900">{{ $payload['tramite_type'] }}</span>
            </div>
            @endif
            @auth
                @if (auth()->id() === $profileUser->id)
                    <div class="flex flex-wrap gap-2 pt-2">
                        <a href="{{ portal_route('dashboard') }}" class="rounded-lg bg-[#004481] px-3 py-1.5 text-xs font-semibold text-white hover:bg-[#003366]">{{ __('status.breadcrumb_dashboard') }}</a>
                        @if ($application?->id)
                            <a href="{{ portal_route('portal.tramite.show', ['application' => $application->id]) }}" class="rounded-lg border border-[#004481] px-3 py-1.5 text-xs font-semibold text-[#004481] hover:bg-white">{{ __('status.view_dossier') }}</a>
                        @endif
                    </div>
                @endif
            @else
                <p class="text-xs text-gray-600">{{ __('status.login_for_more') }}</p>
                <a href="{{ portal_route('login') }}" class="text-xs font-semibold text-[#004481] hover:underline">{{ __('status.login_cta') }}</a>
            @endauth
        </div>
    </details>
</div>

@once
    @push('head')
        <style>
            .status-midgt-confetti {
                position: absolute;
                width: 6px;
                height: 6px;
                border-radius: 50%;
            }
            .status-midgt-confetti--1 { top: 4px; right: 2px; background: #ef4444; }
            .status-midgt-confetti--2 { top: 18px; right: -6px; background: #22c55e; }
            .status-midgt-confetti--3 { bottom: 8px; right: 0; background: #eab308; }
            .status-midgt-confetti--4 { top: 8px; left: -4px; background: #3b82f6; }
            .status-midgt-confetti--5 { bottom: 2px; left: 4px; background: #f97316; }
            .status-midgt-vehicle-card .status-midgt-vehicle-visual { opacity: 0.85; }
            .status-midgt-vehicle-card.is-active .status-midgt-vehicle-visual,
            .status-midgt-vehicle-card:focus-visible .status-midgt-vehicle-visual { opacity: 1; }
            .status-midgt-vehicles::-webkit-scrollbar { height: 4px; }
            .status-midgt-vehicles::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        </style>
    @endpush
    @push('scripts')
        <script>
            document.querySelectorAll('[data-vehicle-card]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    document.querySelectorAll('[data-vehicle-card]').forEach((card) => {
                        card.classList.remove('is-active');
                        const visual = card.querySelector('.status-midgt-vehicle-visual');
                        visual?.classList.remove('bg-[#004481]');
                        visual?.classList.add('bg-slate-200');
                    });
                    btn.classList.add('is-active');
                    const activeVisual = btn.querySelector('.status-midgt-vehicle-visual');
                    activeVisual?.classList.remove('bg-slate-200');
                    activeVisual?.classList.add('bg-[#004481]');
                });
            });
        </script>
    @endpush
@endonce
