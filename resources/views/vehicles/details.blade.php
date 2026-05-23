@php $portalNavActive = 'vehicles'; @endphp
@extends('layouts.portal')

@section('title', __('portal.vehicles.detail_title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('portal.vehicles.detail_title') }}</h1>
    <p class="text-sm text-gray-500">{{ __('portal.vehicles.detail_subtitle') }}</p>
@endsection

@section('content')
    <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-100 bg-[#004481] px-6 py-4 text-white">
            <p class="text-xs font-semibold uppercase tracking-wide opacity-90">{{ __('portal.vehicles.plate') }}</p>
            <p class="font-mono text-2xl font-bold">{{ $vehicle->plate }}</p>
        </div>
        <dl class="grid gap-4 px-6 py-6 sm:grid-cols-2">
            <div>
                <dt class="text-xs font-semibold uppercase text-gray-500">{{ __('portal.vehicles.type') }}</dt>
                <dd class="mt-1 text-base font-medium text-gray-900">{{ $vehicle->vehicle_type }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase text-gray-500">{{ __('portal.vehicles.itv') }}</dt>
                <dd class="mt-1 text-base font-medium text-gray-900">{{ $vehicle->itv_valid_until?->format('d/m/Y') ?? '—' }}</dd>
            </div>
            <div>
                <dt class="text-xs font-semibold uppercase text-gray-500">{{ __('portal.vehicles.status') }}</dt>
                <dd class="mt-1">
                    <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $vehicle->status === 'valid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-900' }}">
                        {{ $vehicle->status === 'valid' ? __('portal.valid') : __('portal.vehicles.pending') }}
                    </span>
                </dd>
            </div>
        </dl>
    </section>

    <div class="mt-6 flex flex-wrap gap-3">
        <a href="{{ route('vehicles.report') }}" class="rounded-xl border border-gray-200 bg-white px-4 py-3 text-sm font-semibold text-[#004481] shadow-sm hover:bg-gray-50">
            {{ __('portal.vehicles.back_list') }}
        </a>
        <a href="{{ route('vehicles.report') }}" class="rounded-xl bg-[#004481] px-4 py-3 text-sm font-semibold text-white hover:bg-[#003366]">
            {{ __('portal.vehicles.view_report') }}
        </a>
    </div>
@endsection
