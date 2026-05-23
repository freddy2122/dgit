@php $portalNavActive = 'points'; @endphp
@extends('layouts.portal')

@section('title', __('portal.points.title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('portal.points.title') }}</h1>
@endsection

@section('content')
    <div class="grid gap-6 lg:grid-cols-5">
        <div class="space-y-6 lg:col-span-3">
            <section class="rounded-xl border border-gray-200 bg-white p-8 shadow-sm">
                <h2 class="text-sm font-semibold text-gray-600">{{ __('portal.points.balance') }}</h2>
                <p class="mt-3 text-5xl font-bold text-emerald-600">
                    {{ $points }}<span class="text-2xl font-semibold text-gray-400"> / {{ $maxPts }} {{ __('portal.points.points_unit') }}</span>
                </p>
                <div class="mt-6 h-3 w-full overflow-hidden rounded-full bg-gray-200">
                    <div @style(['width' => $pct.'%']) class="h-full rounded-full bg-emerald-500 transition-all"></div>
                </div>
                <p class="mt-4 text-sm text-gray-600">{{ __('portal.points.good_behavior') }}</p>
            </section>

            <section class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                <div class="flex items-start gap-4">
                    <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-sky-50 text-[#004481]" aria-hidden="true">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </span>
                    <div>
                        <p class="font-semibold text-gray-900">{{ __('portal.points.download_cert') }}</p>
                        <p class="mt-1 text-sm text-gray-600">{{ __('portal.points.download_desc') }}</p>
                    </div>
                </div>
                <button type="button" onclick="window.print()" class="shrink-0 rounded-lg bg-[#004481] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">
                    {{ __('portal.points.download_btn') }}
                </button>
            </section>
        </div>

        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm lg:col-span-2">
            <h2 class="font-bold text-gray-900">{{ __('portal.points.history') }}</h2>
            @if (count($history) === 0)
                <p class="mt-5 text-sm text-gray-600">{{ __('portal.points.no_history') }}</p>
            @else
            <ul class="mt-5 space-y-5">
                @foreach ($history as $row)
                    <li class="flex items-start justify-between gap-4 border-b border-gray-50 pb-4 last:border-0 last:pb-0">
                        <div>
                            <p class="text-sm text-gray-500">{{ $row['date'] }}</p>
                            <p class="mt-0.5 text-sm text-gray-800">{{ $row['label'] }}</p>
                        </div>
                        <span class="shrink-0 text-sm font-bold {{ $row['positive'] ? 'text-emerald-600' : 'text-gray-800' }}">
                            {{ $row['delta'] }}
                        </span>
                    </li>
                @endforeach
            </ul>
            @endif
            <p class="mt-6 text-xs text-gray-500">{{ __('portal.points.see_history') }}</p>
        </section>
    </div>
@endsection
