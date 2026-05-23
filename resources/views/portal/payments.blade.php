@php $portalNavActive = 'payments'; @endphp
@extends('layouts.portal')

@section('title', __('portal.payments.title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('portal.payments.title') }}</h1>
    <p class="text-sm text-gray-500">{{ __('portal.payments.subtitle_whatsapp') }}</p>
@endsection

@section('content')
    <section class="mb-6 rounded-xl border border-[#25D366]/30 bg-emerald-50 p-6">
        <p class="text-sm font-semibold text-emerald-900">{{ __('portal.payments.whatsapp_howto') }}</p>
        <p class="mt-2 text-sm text-gray-700">{{ __('portal.payments.whatsapp_steps') }}</p>
    </section>

    <div class="mb-6 rounded-xl border border-[#004481]/20 bg-sky-50 p-6">
        <p class="text-sm text-gray-600">{{ __('portal.payments.pending_total') }}</p>
        <p class="mt-1 text-3xl font-bold text-gray-900">{{ $pendingTotal }} €</p>
    </div>

    <div class="space-y-8">
        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-slate-50/80 px-5 py-4">
                <h2 class="font-bold text-gray-900">{{ __('portal.payments.pending_list') }}</h2>
            </div>
            @if ($pending->isEmpty())
                <p class="p-6 text-sm text-gray-600">{{ __('portal.payments.empty_pending') }}</p>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach ($pending as $payment)
                        <li class="flex flex-wrap items-center gap-4 px-5 py-4">
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-gray-900">{{ $payment->label }}</p>
                                <p class="text-xs text-gray-500">{{ __('portal.reference') }}: {{ $payment->reference }}</p>
                                <p class="mt-1 text-lg font-bold text-gray-900">{{ number_format((float) $payment->amount, 2, ',', '') }} €</p>
                                <p class="text-xs text-gray-500">{{ __('portal.due') }} {{ $payment->due_date->format('d/m/Y') }}</p>
                            </div>
                            <a
                                href="{{ gestoria_whatsapp_url(gestoria_whatsapp_payment_message($payment)) }}"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="inline-flex min-h-[44px] shrink-0 items-center justify-center gap-2 rounded-lg bg-[#25D366] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#1da851]"
                            >
                                {{ __('tramite.pay_whatsapp_btn') }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="border-b border-gray-100 bg-slate-50/80 px-5 py-4">
                <h2 class="font-bold text-gray-900">{{ __('portal.payments.paid_list') }}</h2>
            </div>
            @if ($paid->isEmpty())
                <p class="p-6 text-sm text-gray-600">{{ __('portal.payments.empty_paid') }}</p>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach ($paid as $payment)
                        <li class="flex flex-wrap items-center gap-4 px-5 py-4">
                            <div class="min-w-0 flex-1">
                                <p class="font-medium text-gray-900">{{ $payment->label }}</p>
                                <p class="text-xs text-gray-500">{{ $payment->reference }}</p>
                            </div>
                            <p class="font-bold text-gray-700">{{ number_format((float) $payment->amount, 2, ',', '') }} €</p>
                            <span class="rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-800">{{ __('portal.paid') }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>
    </div>
@endsection
