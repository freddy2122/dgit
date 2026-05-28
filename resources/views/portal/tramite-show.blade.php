@php $portalNavActive = 'demarches'; @endphp
@extends('layouts.portal')

@section('title', __('tramite.page_title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('tramite.page_title') }}</h1>
    <p class="text-sm text-gray-500">{{ $typeLabel }} — <span class="font-mono">{{ $application->reference_code }}</span></p>
@endsection

@section('content')
    @if (session('status'))
        <p class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('status') }}</p>
    @endif

    @if (! empty($exam['show']))
        <div class="mb-6 flex flex-col items-center gap-6">
            @include('licence.partials.status-result-midgt', [
                'user' => $profileUser,
                'profileUser' => $profileUser,
                'license' => $license,
                'application' => $application,
                'payload' => $tramitePayload,
            ])
            @include('licence.partials.status-exam-result-sede', ['exam' => $exam, 'payload' => $tramitePayload])
        </div>
    @elseif ($application->examPrevalidated())
        <section class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 p-5">
            <p class="text-sm font-semibold text-emerald-900">{{ __('tramite.exam_prevalidated_title') }}</p>
            <p class="mt-1 text-sm text-emerald-800">{{ __('tramite.exam_prevalidated_hint') }}</p>
        </section>
    @endif

    <section class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('tramite.workflow_title') }}</h2>
        <ol class="mt-4 grid gap-2 sm:grid-cols-3 lg:grid-cols-6">
            @foreach ($workflowSteps as $step)
                <li class="rounded-lg border px-3 py-2 text-center text-xs font-semibold
                    {{ $step['done'] ? 'border-emerald-300 bg-emerald-50 text-emerald-800' : ($step['active'] ? 'border-[#004481] bg-sky-50 text-[#004481]' : 'border-gray-200 text-gray-500') }}">
                    {{ $step['label'] }}
                </li>
            @endforeach
        </ol>
    </section>

    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('tramite.status_block') }}</h2>
            <p class="mt-3 text-2xl font-bold text-[#004481]">{{ permit_status_label($application->status) }}</p>
            <dl class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-600">{{ __('tramite.reference') }}</dt>
                    <dd class="font-mono font-semibold">{{ $application->reference_code }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-600">{{ __('tramite.submitted') }}</dt>
                    <dd>{{ $application->submitted_at?->format('d/m/Y H:i') ?? '—' }}</dd>
                </div>
            </dl>
        </section>

        @if ($requiresMedical)
            <section class="rounded-xl border border-sky-200 bg-sky-50 p-6 shadow-sm">
                <h2 class="text-sm font-bold uppercase tracking-wide text-gray-700">{{ __('tramite.medical_block') }}</h2>
                <p class="mt-2 text-sm text-gray-700">{{ __('tramite.medical_uploaded_hint') }}</p>
                @if ($application->medical_certificate_path)
                    <p class="mt-3 text-sm font-semibold text-emerald-800">✓ {{ __('tramite.medical_on_file') }}</p>
                @else
                    <p class="mt-3 text-sm text-amber-800">{{ __('tramite.medical_pending') }}</p>
                @endif
            </section>
        @endif
    </div>

    <section class="mt-6 rounded-xl border-2 border-[#25D366]/40 bg-white p-6 shadow-sm">
        <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('tramite.payments_block') }}</h2>
        <p class="mt-2 text-sm text-gray-600">{{ __('tramite.payment_whatsapp_intro') }}</p>
        <ul class="mt-4 divide-y divide-gray-100">
            @forelse ($pendingPayments as $payment)
                <li class="flex flex-wrap items-center justify-between gap-4 py-4">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $payment->label }}</p>
                        <p class="text-sm text-gray-500">{{ $payment->reference }} — {{ number_format((float) $payment->amount, 2, ',', ' ') }} €</p>
                    </div>
                    <a
                        href="{{ gestoria_whatsapp_url(gestoria_whatsapp_payment_message($payment)) }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="inline-flex min-h-[44px] items-center justify-center gap-2 rounded-lg bg-[#25D366] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#1da851]"
                    >
                        {{ __('tramite.pay_whatsapp_btn') }}
                    </a>
                </li>
            @empty
                <li class="py-4 text-sm text-gray-500">{{ __('tramite.no_pending_payments') }}</li>
            @endforelse
        </ul>
        <p class="mt-4 text-xs text-gray-500">{{ __('tramite.payment_whatsapp_after') }}</p>
    </section>

    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ portal_route('licence.status') }}" class="text-sm font-semibold text-[#004481] hover:underline">{{ __('tramite.go_status') }}</a>
        <a href="{{ portal_route('portal.payments') }}" class="text-sm font-semibold text-[#004481] hover:underline">{{ __('tramite.go_payments') }}</a>
        <a href="{{ portal_route('portal.demarches') }}" class="text-sm font-semibold text-gray-600 hover:underline">{{ __('tramite.go_demarches') }}</a>
    </div>
@endsection
