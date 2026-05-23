@extends('layouts.app')

@section('title', __('sede.conectar.title'))

@section('content')
    @include('sede.partials.layout', [
        'navPath' => 'es/acceso/clave/conectar',
        'breadcrumbs' => [
            ['label' => __('sede.acceso.login'), 'path' => 'es/acceso'],
            ['label' => __('sede.clave.breadcrumb'), 'path' => 'es/acceso/clave'],
            ['label' => __('sede.conectar.breadcrumb'), 'path' => null],
        ],
    ])

    <article class="max-w-lg rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-6">
            <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-[#004481] text-lg font-bold text-white">@</div>
            <div>
                <h1 class="text-xl font-bold text-gray-900">{{ __('sede.conectar.heading') }}</h1>
                <p class="text-sm text-gray-600">{{ __('sede.conectar.sub') }}</p>
            </div>
        </div>

        <form class="space-y-4" action="{{ sede_href('es') }}" method="get">
            <div>
                <label for="clave-user" class="block text-sm font-medium text-gray-700">{{ __('sede.conectar.user') }}</label>
                <input id="clave-user" type="text" autocomplete="username" class="mt-1 w-full border border-gray-300 px-3 py-2.5 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" placeholder="12345678A" />
            </div>
            <div>
                <label for="clave-pass" class="block text-sm font-medium text-gray-700">{{ __('sede.conectar.password') }}</label>
                <input id="clave-pass" type="password" autocomplete="current-password" class="mt-1 w-full border border-gray-300 px-3 py-2.5 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
            </div>
            <button type="submit" class="w-full rounded-lg bg-[#004481] py-3 text-sm font-semibold text-white shadow hover:bg-[#003366]">{{ __('sede.conectar.submit') }}</button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            {{ __('sede.conectar.no_clave') }}
            <a href="{{ clave_plataforma_href() }}" class="font-medium text-[#004481] hover:underline">{{ __('sede.conectar.register') }}</a>
        </p>

        <p class="mt-6 text-center text-sm text-gray-600">
            {{ __('sede.conectar.no_account') }}
            <a href="{{ clave_plataforma_href() }}" class="font-bold text-[#004481] hover:underline">{{ __('sede.conectar.register') }}</a>
        </p>
    </article>

    @include('sede.partials.layout-end')
@endsection
