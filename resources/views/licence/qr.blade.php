@php $portalNavActive = 'digital'; @endphp
@extends('layouts.portal')

@section('title', __('portal.qr.page_title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('portal.qr.page_title') }}</h1>
    <p class="text-sm text-gray-500">{{ __('portal.qr.page_subtitle') }}</p>
@endsection

@section('content')
    <div class="mb-6 rounded-xl border border-amber-200 bg-amber-50 p-5">
        <h2 class="text-sm font-bold uppercase tracking-wide text-amber-900">{{ __('portal.qr.security_title') }}</h2>
        <ul class="mt-3 list-disc space-y-1.5 pl-5 text-sm text-amber-950">
            <li>{{ __('portal.qr.security_1') }}</li>
            <li>{{ __('portal.qr.security_2') }}</li>
            <li>{{ __('portal.qr.security_3') }}</li>
        </ul>
    </div>

    @include('licence.partials.license-qr-panel', [
        'panelId' => 'license-qr-page',
        'autoStart' => true,
        'ttlSeconds' => $ttlSeconds,
        'refreshBefore' => $refreshBefore,
    ])

    <a href="{{ portal_route('licence.digital') }}" class="mt-6 inline-block text-sm font-semibold text-[#004481] hover:underline">
        ← {{ __('portal.qr.back_digital') }}
    </a>

    @include('licence.partials.license-qr-script')
@endsection
