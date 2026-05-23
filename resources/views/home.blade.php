@extends('layouts.app')

@section('title', 'Accueil — Sede Electrónica')

@section('content')
    @include('layouts.partials.hero-trafico')
    @include('layouts.partials.sede-electronica-teaser')
    @include('layouts.partials.te-puede-interesar')
    @include('layouts.partials.seguridad-vial-2030-banner')
    @include('layouts.partials.siniestralidad-vial-datos')
    @include('layouts.partials.informacion-trafico')
    @include('layouts.partials.boletin-trafico-barra')
    @include('layouts.partials.agenda')
    @include('layouts.partials.campanas')
    @include('layouts.partials.conocimiento-investigacion')
    @include('layouts.partials.educacion-vial-recursos')

    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <p class="flex flex-wrap items-center gap-x-3 gap-y-2 text-gray-600">
            <a href="{{ portal_route('sede.hub') }}" class="font-semibold text-[#004481] hover:underline">{{ __('site.home.sede_link') }}</a>
            <span class="text-gray-300" aria-hidden="true">·</span>
            <a href="{{ portal_route('permis.index') }}" class="font-semibold text-[#004481] hover:underline">{{ __('site.home.permis_link') }}</a>
            <span class="text-gray-300" aria-hidden="true">·</span>
            @auth
                <a href="{{ portal_route('dashboard') }}" class="inline-flex items-center rounded bg-[#004481] px-4 py-2 text-sm font-bold text-white hover:bg-[#003366]">{{ __('portal.header.midgt_space') }}</a>
            @else
                <a href="{{ midgt_acceso_href() }}" class="inline-flex items-center rounded bg-[#004481] px-4 py-2 text-sm font-bold text-white hover:bg-[#003366]">{{ __('portal.header.midgt_access') }}</a>
            @endauth
        </p>
    </div>
@endsection
