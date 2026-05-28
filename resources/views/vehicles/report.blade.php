@php $portalNavActive = 'vehicles'; @endphp
@extends('layouts.portal')

@section('title', __('portal.vehicles.title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('portal.vehicles.title') }}</h1>
    <p class="text-sm text-gray-500">{{ __('portal.vehicles.count', ['count' => $vehicles->count()]) }}</p>
@endsection

@section('content')
    <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-[#004481] text-white">
                    <tr>
                        <th class="px-5 py-3.5 font-semibold">{{ __('portal.vehicles.plate') }}</th>
                        <th class="px-5 py-3.5 font-semibold">{{ __('portal.vehicles.type') }}</th>
                        <th class="px-5 py-3.5 font-semibold">{{ __('portal.vehicles.itv') }}</th>
                        <th class="px-5 py-3.5 font-semibold">{{ __('portal.vehicles.status') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($vehicles as $v)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-5 py-4">
                                <a href="{{ route('vehicles.details', $v) }}" class="flex items-center gap-3 hover:text-[#004481]">
                                    <span class="text-xl" aria-hidden="true">{{ $v->is_motorcycle ? '🏍' : '🚗' }}</span>
                                    <span class="font-mono text-base font-bold">{{ $v->plate }}</span>
                                </a>
                            </td>
                            <td class="px-5 py-4 text-gray-700">{{ $v->vehicle_type }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $v->itv_valid_until?->format('m/Y') ?? '—' }}</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $v->status === 'valid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-900' }}">
                                    {{ $v->status === 'valid' ? __('portal.valid') : __('portal.vehicles.pending') }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-5 py-12 text-center text-gray-600">
                                {{ __('portal.vehicles.empty') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    <div class="mt-6 grid gap-4 sm:grid-cols-2">
        <a href="{{ portal_route('dashboard') }}" class="rounded-xl border border-gray-200 bg-white p-4 text-sm font-semibold text-[#004481] shadow-sm hover:bg-gray-50">
            {{ __('portal.vehicles.back_dashboard') }}
        </a>
        <a href="{{ route('licence.points') }}" class="rounded-xl border border-gray-200 bg-white p-4 text-sm font-semibold text-[#004481] shadow-sm hover:bg-gray-50">
            {{ __('portal.license.points_detail') }}
        </a>
    </div>
@endsection
