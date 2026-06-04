@php $portalNavActive = 'dashboard'; @endphp
@extends('layouts.portal')

@section('title', __('portal.dashboard.title'))

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ __('portal.dashboard.welcome') }}</h1>
        <p class="mt-1 max-w-2xl text-sm text-gray-600 sm:text-base">{{ __('portal.dashboard.subtitle') }}</p>
    </div>

    @if (auth()->user()->verification_code)
        <section class="mb-6 flex flex-col gap-4 rounded-xl border border-[#004481]/20 bg-gradient-to-r from-sky-50 to-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-semibold uppercase tracking-wide text-[#004481]">{{ __('portal.verification.title') }}</p>
                <code class="mt-2 block font-mono text-xl font-bold text-gray-900">{{ auth()->user()->verification_code }}</code>
                <p class="mt-1 text-xs text-gray-500">{{ __('portal.verification.subtitle') }}</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ portal_licence_status_href() }}" class="rounded-lg bg-[#004481] px-4 py-2 text-sm font-semibold text-white hover:bg-[#003366]">{{ __('portal.verification.check_status') }}</a>
                <a href="{{ route('documents.verify') }}" class="rounded-lg border border-[#004481] px-4 py-2 text-sm font-semibold text-[#004481] hover:bg-white">{{ __('portal.verification.verify_doc') }}</a>
            </div>
        </section>
    @endif

    @if ($application || $license)
        <section class="mb-8">
            @include('licence.partials.status-result-midgt', [
                'user' => auth()->user(),
                'profileUser' => auth()->user(),
                'license' => $license,
                'application' => $application,
                'payload' => $statusPayload ?? ['points' => $pts, 'exam' => $exam],
            ])
        </section>
    @endif

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 bg-slate-50/80 px-5 py-4">
                <h2 class="text-base font-bold text-gray-900">{{ __('portal.dashboard.licenses') }}</h2>
                {{-- Permis recto/verso : consultation réservée à l’admin (fiche client) --}}
                <div class="flex flex-wrap items-center gap-3">
                    <a href="{{ route('licence.points') }}" class="text-sm font-semibold text-[#004481] hover:underline">{{ __('portal.license.points_detail') }}</a>
                </div>
            </div>
            <div class="flex flex-col gap-5 p-5 sm:flex-row sm:items-center">
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ __('portal.dashboard.license_type') }}</p>
                    <p class="mt-1 font-mono text-sm font-bold text-gray-900">{{ strtoupper(preg_replace('/\s+/', '', $nie ?? '')) ?: '—' }}</p>
                    @if ($hasLicenseData ?? false)
                    <dl class="mt-4 space-y-2 rounded-lg border border-gray-100 bg-slate-50/80 p-4 text-sm">
                        @if ($license?->category)
                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-500">{{ __('portal.dashboard.license_category') }}</dt>
                            <dd class="font-semibold text-gray-900">{{ $license->category }}</dd>
                        </div>
                        @endif
                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-500">{{ __('portal.valid_until') }}</dt>
                            <dd class="font-semibold text-gray-900">{{ $license?->valid_until?->format('d-m-Y') ?? '—' }}</dd>
                        </div>
                        <div class="flex justify-between gap-4">
                            <dt class="text-gray-500">{{ __('portal.dashboard.license_status') }}</dt>
                            <dd class="font-semibold text-[#004481]">{{ permit_status_label($license?->application_status) }}</dd>
                        </div>
                    </dl>
                    {{-- Bouton permis numérique désactivé côté client — voir admin/users/{id}/permis-digital --}}
                    {{--
                    <a href="{{ portal_route('licence.digital') }}" class="mt-4 inline-flex min-h-[44px] items-center justify-center rounded-lg bg-[#004481] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">
                        {{ __('portal.dashboard.view_digital_license') }}
                    </a>
                    <p class="mt-2 text-xs text-gray-500">{{ __('portal.dashboard.license_card_hint') }}</p>
                    --}}
                    @else
                    <p class="mt-4 rounded-lg border border-dashed border-gray-200 bg-slate-50 p-6 text-sm text-gray-600">{{ __('portal.dashboard.no_license_yet') }}</p>
                    @if ($application)
                    <a href="{{ portal_route('portal.tramite.show', ['application' => $application->id]) }}" class="mt-3 inline-block text-sm font-semibold text-[#004481] hover:underline">{{ __('portal.dashboard.track_application') }}</a>
                    @endif
                    @endif
                </div>
                @if ($license)
                    <a href="{{ route('licence.points') }}" class="flex shrink-0 flex-col items-center self-center sm:self-start">
                        @include('portal.partials.points-ring', ['pts' => $pts, 'max' => $maxPts])
                    </a>
                @endif
            </div>
        </section>

        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 bg-slate-50/80 px-5 py-4">
                <h2 class="text-base font-bold text-gray-900">{{ __('portal.dashboard.vehicles') }}</h2>
                <a href="{{ route('vehicles.report') }}" class="text-sm font-semibold text-[#004481] hover:underline">{{ __('portal.see_all') }}</a>
            </div>
            @if ($vehicles->isEmpty())
                <p class="p-5 text-sm text-gray-600">{{ __('portal.dashboard.no_vehicles') }}</p>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach ($vehicles->take(2) as $v)
                        <li>
                            <a href="{{ route('vehicles.report') }}" class="flex items-center gap-4 px-5 py-4 transition hover:bg-slate-50">
                                <span class="flex h-11 w-11 items-center justify-center rounded-lg bg-slate-100 text-xl" aria-hidden="true">{{ $v->is_motorcycle ? '🏍' : '🚗' }}</span>
                                <div class="min-w-0 flex-1">
                                    <p class="font-mono font-bold text-gray-900">{{ $v->plate }}</p>
                                    <p class="text-sm text-gray-500">{{ $v->vehicle_type }}</p>
                                    <p class="text-xs text-gray-500">{{ __('portal.dashboard.itv_until') }} {{ $v->itv_valid_until?->format('d-m-Y') ?? '—' }}</p>
                                </div>
                                <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $v->status === 'valid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-900' }}">
                                    {{ $v->status === 'valid' ? __('portal.valid') : __('portal.pending') }}
                                </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 bg-slate-50/80 px-5 py-4">
                <h2 class="text-base font-bold text-gray-900">{{ __('portal.dashboard.procedures') }}</h2>
                <a href="{{ route('portal.demarches') }}" class="text-sm font-semibold text-[#004481] hover:underline">{{ __('portal.see_all') }}</a>
            </div>
            @if (count($procedures) === 0)
                <p class="p-5 text-sm text-gray-600">{{ __('portal.dashboard.no_procedures') }}</p>
            @else
            <ul class="divide-y divide-gray-100">
                @foreach ($procedures as $procedure)
                    <li class="flex items-center justify-between gap-3 px-5 py-3.5">
                        @if (! empty($procedure['url']))
                        <a href="{{ $procedure['url'] }}" class="text-sm font-medium text-[#004481] hover:underline">{{ $procedure['label'] }}</a>
                        @else
                        <span class="text-sm font-medium text-gray-800">{{ $procedure['label'] }}</span>
                        @endif
                        <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $procedure['badgeClass'] }}">{{ $procedure['status'] }}</span>
                    </li>
                @endforeach
            </ul>
            @endif
        </section>

        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="flex items-center justify-between border-b border-gray-100 bg-slate-50/80 px-5 py-4">
                <h2 class="text-base font-bold text-gray-900">{{ __('portal.dashboard.notifications') }}</h2>
                <a href="{{ route('portal.notifications') }}" class="text-sm font-semibold text-[#004481] hover:underline">{{ __('portal.see_all') }}</a>
            </div>
            @if ($notifications->isEmpty())
                <p class="p-5 text-sm text-gray-600">{{ __('portal.dashboard.no_notifications') }}</p>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach ($notifications as $notification)
                        <li class="flex items-start justify-between gap-3 px-5 py-3.5">
                            <div class="min-w-0">
                                <p class="truncate text-sm font-medium text-gray-800">{{ $notification->display_title }}</p>
                                <p class="text-xs text-gray-500">{{ $notification->notified_at->format('d/m/Y') }}</p>
                            </div>
                            @unless ($notification->is_read)
                                <span class="mt-1.5 h-2 w-2 shrink-0 rounded-full bg-[#004481]" aria-hidden="true"></span>
                            @endunless
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <h2 class="text-base font-bold text-gray-900">{{ __('portal.dashboard.payments') }}</h2>
                <a href="{{ route('portal.payments') }}" class="text-sm font-semibold text-[#004481] hover:underline">{{ __('portal.see_all') }}</a>
            </div>
            <p class="mt-4 text-4xl font-bold text-gray-900">{{ $pendingTotal > 0 ? $pendingTotal : '0,00' }} <span class="text-2xl font-semibold">€</span></p>
            <p class="text-sm text-gray-500">{{ __('portal.dashboard.pending_total') }}</p>
            @if (($pendingTotalAmount ?? 0) > 0)
            <a href="{{ route('portal.payments') }}" class="mt-5 block w-full rounded-lg bg-[#25D366] py-2.5 text-center text-sm font-semibold text-white transition hover:bg-[#1da851]">
                {{ __('tramite.pay_whatsapp_btn') }}
            </a>
            @else
            <p class="mt-5 text-sm text-gray-500">{{ __('portal.dashboard.no_pending_payments') }}</p>
            @endif
            <p class="mt-3 text-xs text-gray-500">{{ __('portal.dashboard.traffic_fees', ['amount' => $pendingTotal]) }}</p>
            <p class="text-xs text-gray-500">{{ __('portal.dashboard.due_date', ['date' => $paymentDue]) }}</p>
        </section>
    </div>

    <section class="mt-6 flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:items-center sm:justify-between sm:p-6">
        <div>
            <h2 class="text-base font-bold text-gray-900">{{ __('portal.dashboard.appointment') }}</h2>
            @if ($nextAppointment ?? null)
            <p class="mt-1 text-sm text-gray-600">
                {{ __('portal.dashboard.appointment_next', [
                    'date' => $nextAppointment->appointment_date->format('d/m/Y'),
                    'time' => $nextAppointment->appointment_time ?? '—',
                    'office' => $nextAppointment->office,
                ]) }}
            </p>
            @else
            <p class="mt-1 text-sm text-gray-600">{{ __('portal.dashboard.appointment_desc') }}</p>
            @endif
        </div>
        <a href="{{ route('portal.appointments') }}" class="inline-flex shrink-0 items-center justify-center rounded-lg border-2 border-[#004481] px-6 py-2.5 text-sm font-semibold text-[#004481] transition hover:bg-sky-50">
            {{ __('portal.dashboard.request_appointment') }}
        </a>
    </section>
@endsection
