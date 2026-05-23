@extends('layouts.app')

@section('title', __('sede.clave.title'))

@section('content')
    @include('sede.partials.layout', [
        'navPath' => 'es/acceso/clave',
        'breadcrumbs' => [
            ['label' => __('sede.acceso.login'), 'path' => 'es/acceso'],
            ['label' => __('sede.clave.breadcrumb'), 'path' => null],
        ],
    ])

    <div class="mb-8">
        @include('sede.partials.cta-inscription-clave', ['variant' => 'hero'])
    </div>

    <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        <p class="text-sm font-medium uppercase tracking-wide text-[#004481]">{{ __('sede.clave.system') }}</p>
        <h1 class="mt-1 text-2xl font-bold text-gray-900 sm:text-3xl">{{ __('sede.clave.breadcrumb') }}</h1>
        <p class="mt-4 rounded-lg bg-sky-50 px-4 py-3 text-sm font-medium text-[#004481]">{{ __('sede.clave.banner') }}</p>
        <p class="mt-4 text-gray-700">{{ __('sede.clave.intro') }}</p>

        <h2 class="mt-10 text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('sede.clave.register_steps') }}</h2>
        <ol class="mt-4 space-y-4">
            @foreach (__('sede.clave.steps') as $step)
                <li class="flex gap-4 rounded-lg border border-gray-100 p-4">
                    <span class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#004481] text-sm font-bold text-white">{{ $loop->iteration }}</span>
                    <div class="min-w-0 flex-1">
                        <p class="font-semibold text-gray-900">{{ $step['t'] }}</p>
                        <p class="mt-1 text-sm text-gray-600">{{ $step['d'] }}</p>
                        @if (! empty($step['link']))
                            <a href="{{ sede_href($step['link']) }}" class="mt-3 inline-flex items-center justify-center rounded-lg bg-[#004481] px-4 py-2 text-sm font-bold text-white hover:bg-[#003366]">
                                {{ $step['label'] }}
                            </a>
                        @endif
                    </div>
                </li>
            @endforeach
        </ol>

        <div class="mt-10 rounded-lg border border-gray-200 bg-gray-50 p-5">
            <h2 class="font-bold text-gray-900">{{ __('sede.clave.already_title') }}</h2>
            <p class="mt-2 text-sm text-gray-700">{{ __('sede.clave.already_desc') }}</p>
            <a href="{{ sede_href('es/acceso/clave/conectar') }}" class="mt-4 inline-flex min-h-[44px] items-center justify-center rounded-lg bg-[#f28c00] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[#e07d00]">
                {{ __('sede.clave.connect_btn') }}
            </a>
        </div>
    </article>

    @include('sede.partials.layout-end')
@endsection
