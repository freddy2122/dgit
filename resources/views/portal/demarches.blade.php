@php $portalNavActive = 'demarches'; @endphp
@extends('layouts.portal')

@section('title', __('portal.demarches.title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('portal.demarches.title') }}</h1>
@endsection

@section('content')
    @if (! $application)
        <section class="rounded-xl border border-amber-200 bg-amber-50 p-6 text-sm text-amber-900">
            <p class="font-semibold">{{ __('portal.demarches.no_file') }}</p>
            <p class="mt-2">{{ __('portal.demarches.no_file_hint') }}</p>
            <a href="{{ portal_licence_status_href() }}" class="mt-4 inline-block font-semibold text-[#004481] hover:underline">{{ __('portal.demarches.search_file') }}</a>
        </section>
    @else
        <section class="mb-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">{{ $typeLabel }}</h2>
                    <p class="mt-2 text-sm text-gray-600">{{ __('portal.demarches.file_number') }} : <span class="font-mono font-semibold">{{ $ref }}</span></p>
                    <p class="text-sm text-gray-600">{{ __('portal.demarches.filed_on') }} {{ $deposed }}</p>
                </div>
                <span class="rounded-full px-4 py-1.5 text-sm font-semibold {{ $badgeClass }}">{{ $badgeLabel }}</span>
            </div>

            <div class="mt-10 grid gap-3 sm:grid-cols-3 lg:grid-cols-6">
                @foreach ($steps as $step)
                    @php
                        $done = $step['n'] < $currentStep;
                        $active = $step['n'] === $currentStep;
                    @endphp
                    <div class="relative flex flex-col items-center text-center">
                        @if (! $loop->last)
                            <div class="absolute left-[calc(50%+1.25rem)] top-5 hidden h-0.5 w-[calc(100%-2.5rem)] sm:block {{ $done || $active ? 'bg-[#004481]' : 'bg-gray-200' }}"></div>
                        @endif
                        <div class="relative z-10 flex h-10 w-10 items-center justify-center rounded-full text-sm font-bold
                            {{ $done ? 'bg-emerald-500 text-white' : ($active ? 'bg-[#004481] text-white ring-4 ring-sky-100' : 'bg-gray-200 text-gray-500') }}">
                            @if ($done)
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            @else
                                {{ $step['n'] }}
                            @endif
                        </div>
                        <p class="mt-3 text-xs font-semibold text-gray-900 sm:text-sm">{{ $step['label'] }}</p>
                        @if ($step['date'] && $step['n'] === 1)
                            <p class="mt-1 text-xs text-gray-500">{{ $step['date'] }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="font-bold text-gray-900">{{ __('portal.demarches.details') }}</h2>
            <dl class="mt-4 space-y-3 text-sm">
                <div class="flex justify-between gap-4 border-b border-gray-50 pb-2">
                    <dt class="text-gray-600">{{ __('portal.demarches.type') }}</dt>
                    <dd class="font-medium text-gray-900">{{ $typeLabel }}</dd>
                </div>
                <div class="flex justify-between gap-4 border-b border-gray-50 pb-2">
                    <dt class="text-gray-600">{{ __('portal.demarches.filed_on') }}</dt>
                    <dd class="font-medium text-gray-900">{{ $deposed }}</dd>
                </div>
                <div class="flex justify-between gap-4 border-b border-gray-50 pb-2">
                    <dt class="text-gray-600">{{ __('portal.demarches.status') }}</dt>
                    <dd class="font-medium text-gray-900">{{ $badgeLabel }}</dd>
                </div>
                <div class="flex justify-between gap-4">
                    <dt class="text-gray-600">{{ __('portal.demarches.office') }}</dt>
                    <dd class="text-right font-medium text-gray-900">{{ __('portal.demarches.office_name') }}</dd>
                </div>
            </dl>
            <div class="mt-6 flex flex-wrap gap-3">
                <a href="{{ portal_licence_status_href(['view' => 'result']) }}" class="inline-flex rounded-lg border-2 border-[#004481] px-5 py-2.5 text-sm font-bold text-[#004481] hover:bg-sky-50">
                    {{ __('status.tab_result') }}
                </a>
                @if ($application && $application->status !== 'valide')
                    <a href="{{ portal_route('portal.tramite.show', ['application' => $application->id]) }}" class="inline-flex rounded-lg bg-[#f28c00] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#e07d00]">
                        {{ __('tramite.manage_cta') }}
                    </a>
                @endif
            </div>
        </section>
    @endif
@endsection
