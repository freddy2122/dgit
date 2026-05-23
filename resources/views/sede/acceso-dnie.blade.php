@extends('layouts.app')

@section('title', __('sede.dnie.title'))

@section('content')
    @include('sede.partials.layout', [
        'navPath' => 'es/acceso/dnie',
        'breadcrumbs' => [
            ['label' => __('sede.acceso.login'), 'path' => 'es/acceso'],
            ['label' => __('sede.dnie.breadcrumb'), 'path' => null],
        ],
    ])

    <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        <h1 class="text-2xl font-bold text-gray-900">{{ __('sede.dnie.heading') }}</h1>
        <p class="mt-4 rounded-lg bg-sky-50 px-4 py-3 text-sm text-[#004481]">{{ __('sede.dnie.banner') }}</p>

        <h2 class="mt-8 text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('sede.dnie.prereq') }}</h2>
        <ul class="mt-3 list-disc space-y-2 pl-5 text-gray-700">
            @foreach (__('sede.dnie.prereq_list') as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>

        <h2 class="mt-8 text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('sede.dnie.connect_title') }}</h2>
        <ol class="mt-4 list-decimal space-y-2 pl-5 text-gray-700">
            @foreach (__('sede.dnie.connect_steps') as $step)
                <li>
                    @if ($loop->first)
                        <a href="{{ sede_href('es') }}" class="font-medium text-[#004481] hover:underline">{{ $step }}</a>
                    @else
                        {{ $step }}
                    @endif
                </li>
            @endforeach
        </ol>

        <a href="{{ sede_href('es') }}" class="mt-8 inline-flex min-h-[44px] items-center justify-center rounded-lg bg-[#004481] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">
            {{ __('sede.dnie.access') }}
        </a>

        <p class="mt-8 text-sm text-gray-600">
            {{ __('sede.dnie.no_dnie') }}
            <a href="{{ clave_plataforma_href() }}" class="font-bold text-[#004481] hover:underline">{{ __('sede.cta.register') }}</a>
        </p>
    </article>

    @include('sede.partials.layout-end')
@endsection
