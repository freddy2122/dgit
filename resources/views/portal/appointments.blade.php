@php $portalNavActive = 'appointments'; @endphp
@extends('layouts.portal')

@section('title', __('portal.appointments.title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('portal.appointments.title') }}</h1>
    <p class="text-sm text-gray-500">{{ __('portal.appointments.subtitle') }}</p>
@endsection

@section('content')
    <div class="grid gap-6 lg:grid-cols-5">
        <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm lg:col-span-3">
            <div class="border-b border-gray-100 bg-slate-50/80 px-5 py-4">
                <h2 class="font-bold text-gray-900">{{ __('portal.appointments.upcoming') }}</h2>
            </div>
            @if ($appointments->isEmpty())
                <p class="p-6 text-sm text-gray-600">{{ __('portal.appointments.empty') }}</p>
            @else
                <ul class="divide-y divide-gray-100">
                    @foreach ($appointments as $appointment)
                        <li class="px-5 py-4">
                            <div class="flex flex-wrap items-start justify-between gap-3">
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $appointment->procedure }}</p>
                                    <p class="mt-1 text-sm text-gray-600">{{ $appointment->office }}</p>
                                    <p class="mt-2 text-sm text-gray-800">
                                        {{ $appointment->appointment_date->format('d/m/Y') }}
                                        — {{ $appointment->appointment_time }}
                                    </p>
                                </div>
                                <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">
                                    {{ __('portal.appointments.confirmed') }}
                                </span>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm lg:col-span-2">
            <h2 class="font-bold text-gray-900">{{ __('portal.appointments.new') }}</h2>
            <p class="mt-1 text-sm text-gray-600">{{ __('portal.appointments.desc') }}</p>
            <form method="post" action="{{ route('portal.appointments.store') }}" class="mt-5 space-y-4">
                @csrf
                <div>
                    <label for="office" class="block text-xs font-medium text-gray-600">{{ __('portal.office') }}</label>
                    <select id="office" name="office" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:ring-1 focus:ring-[#004481]">
                        @foreach ($offices as $office)
                            <option value="{{ $office }}">{{ $office }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="procedure" class="block text-xs font-medium text-gray-600">{{ __('portal.procedure') }}</label>
                    <select id="procedure" name="procedure" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:ring-1 focus:ring-[#004481]">
                        @foreach ($procedures as $procedure)
                            <option value="{{ $procedure }}">{{ $procedure }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label for="appointment_date" class="block text-xs font-medium text-gray-600">{{ __('portal.date') }}</label>
                        @include('partials.form-date', [
                            'name' => 'appointment_date',
                            'id' => 'appointment_date',
                            'value' => old('appointment_date'),
                            'required' => true,
                            'min' => now()->format('Y-m-d'),
                        ])
                    </div>
                    <div>
                        <label for="appointment_time" class="block text-xs font-medium text-gray-600">{{ __('portal.time') }}</label>
                        <input type="time" id="appointment_time" name="appointment_time" required value="10:30" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:ring-1 focus:ring-[#004481]">
                    </div>
                </div>
                <button type="submit" class="w-full rounded-lg bg-[#004481] py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">
                    {{ __('portal.appointments.request') }}
                </button>
            </form>
        </section>
    </div>
@endsection
