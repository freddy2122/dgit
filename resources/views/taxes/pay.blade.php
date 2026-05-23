@php $portalNavActive = 'taxes'; @endphp
@extends('layouts.portal')

@section('title', __('site.taxes.pay_title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('site.taxes.pay_title') }}</h1>
    <p class="text-sm text-gray-500">{{ __('site.taxes.subtitle') }}</p>
@endsection

@section('content')
    <p class="mb-6 text-sm text-gray-600">{{ __('site.taxes.pay_intro') }}</p>

    @if ($pending->isEmpty())
        <p class="rounded-xl border border-gray-200 bg-white p-8 text-center text-sm text-gray-600">{{ __('portal.payments.empty_pending') }}</p>
    @else
        <form method="post" action="{{ route('taxes.pay.submit') }}">
            @csrf
            <ul class="divide-y divide-gray-100 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                @foreach ($pending as $tax)
                    <li class="flex flex-wrap items-center gap-4 px-5 py-4">
                        <input type="checkbox" name="payment_ids[]" value="{{ $tax->id }}" checked class="h-4 w-4 rounded text-[#004481]">
                        <div class="min-w-0 flex-1">
                            <p class="font-medium text-gray-900">{{ $tax->label }}</p>
                            <p class="text-xs text-gray-500">{{ __('portal.due') }} {{ $tax->due_date->format('d/m/Y') }}</p>
                        </div>
                        <p class="font-bold">{{ number_format((float) $tax->amount, 2, ',', '') }} €</p>
                    </li>
                @endforeach
            </ul>
            <button type="submit" class="mt-4 rounded-lg bg-[#004481] px-6 py-3 text-sm font-semibold text-white hover:bg-[#003366]">
                {{ __('site.taxes.pay') }}
            </button>
        </form>
    @endif
@endsection
