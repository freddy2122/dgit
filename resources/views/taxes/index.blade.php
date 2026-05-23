@php $portalNavActive = 'taxes'; @endphp
@extends('layouts.portal')

@section('title', __('site.taxes.title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('site.taxes.title') }}</h1>
    <p class="text-sm text-gray-500">{{ __('site.taxes.subtitle') }}</p>
@endsection

@section('content')
    <p class="mb-6 text-sm text-gray-600">{{ __('site.taxes.intro') }}</p>

    @if ($taxes->isEmpty())
        <p class="rounded-xl border border-gray-200 bg-white p-8 text-center text-sm text-gray-600">{{ __('portal.payments.empty_pending') }}</p>
    @else
        <ul class="divide-y divide-gray-100 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            @foreach ($taxes as $tax)
                <li class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
                    <div>
                        <p class="font-medium text-gray-900">{{ $tax->label }}</p>
                        <p class="text-xs text-gray-500">{{ __('portal.due') }} {{ $tax->due_date->format('d/m/Y') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold">{{ number_format((float) $tax->amount, 2, ',', '') }} €</p>
                        <span class="text-xs font-semibold {{ $tax->status === 'paid' ? 'text-emerald-700' : 'text-amber-700' }}">
                            {{ $tax->status === 'paid' ? __('portal.paid') : ($tax->status === 'awaiting_whatsapp' ? __('portal.payments.awaiting_whatsapp') : __('portal.pending')) }}
                        </span>
                    </div>
                </li>
            @endforeach
        </ul>
        <div class="mt-4 flex flex-wrap gap-4">
            <a href="{{ route('taxes.pay') }}" class="text-sm font-semibold text-[#004481] hover:underline">{{ __('site.taxes.pay') }} →</a>
            <a href="{{ route('taxes.receipt') }}" class="text-sm font-semibold text-[#004481] hover:underline">{{ __('site.taxes.receipt') }} →</a>
        </div>
    @endif
@endsection
