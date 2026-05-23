@php $portalNavActive = 'taxes'; @endphp
@extends('layouts.portal')

@section('title', __('site.taxes.receipt_title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('site.taxes.receipt_title') }}</h1>
    <p class="text-sm text-gray-500">{{ __('site.taxes.receipt_intro') }}</p>
@endsection

@section('content')
    @if ($paid->isEmpty())
        <p class="rounded-xl border border-gray-200 bg-white p-8 text-center text-sm text-gray-600">{{ __('site.taxes.receipt_empty') }}</p>
    @else
        <ul class="divide-y divide-gray-100 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
            @foreach ($paid as $tax)
                <li class="flex flex-wrap items-center justify-between gap-4 px-5 py-4">
                    <div>
                        <p class="font-medium text-gray-900">{{ $tax->label }}</p>
                        <p class="text-xs text-gray-500">{{ __('portal.reference') }}: {{ $tax->reference ?? '—' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-bold">{{ number_format((float) $tax->amount, 2, ',', '') }} €</p>
                        <button type="button" class="mt-1 text-xs font-semibold text-[#004481] hover:underline" onclick="window.print()">
                            {{ __('site.taxes.receipt_download') }}
                        </button>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
    <a href="{{ route('taxes.index') }}" class="mt-6 inline-block text-sm font-semibold text-[#004481] hover:underline">← {{ __('site.taxes.title') }}</a>
@endsection
