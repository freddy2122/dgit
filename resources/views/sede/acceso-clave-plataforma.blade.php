@extends('layouts.app')

@section('title', __('sede.plataforma.title'))

@section('content')
    <div class="min-h-[70vh] bg-gray-50 py-10 sm:py-14">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
            <header class="text-center">
                <h1 class="text-xl font-bold text-gray-900 sm:text-2xl">{{ __('sede.plataforma.heading') }}</h1>
                <p class="mt-2 text-base text-gray-700">{{ __('sede.plataforma.sub') }}</p>
            </header>

            <div class="mt-10 grid gap-6 lg:grid-cols-3">
                <article class="relative flex flex-col rounded-xl border-2 border-[#f28c00]/50 bg-white p-6 shadow-sm">
                    <span class="absolute left-4 top-4 rounded bg-[#f28c00] px-2 py-0.5 text-xs font-bold uppercase text-white">{{ __('sede.plataforma.new') }}</span>
                    <div class="mt-8 flex min-h-[120px] flex-col items-center justify-center">
                        <span class="text-2xl font-bold text-gray-800">cl<span class="text-[#f28c00]">@</span>ve</span>
                        <span class="mt-1 text-lg font-semibold text-gray-700">móvil</span>
                    </div>
                    <h2 class="text-center text-lg font-bold text-gray-900">{{ __('sede.plataforma.mobile') }}</h2>
                    <p class="mt-3 flex-1 text-center text-sm text-gray-600">
                        {{ __('sede.plataforma.mobile_desc') }}
                        <a href="{{ clave_registro_href() }}" class="font-semibold text-[#e07d00] hover:underline">{{ __('sede.plataforma.register_link') }}</a>.
                    </p>
                    <a href="{{ clave_registro_href() }}" class="mt-6 inline-flex min-h-[48px] w-full items-center justify-center rounded-full border-2 border-[#f28c00] bg-[#fff4e6] px-4 py-3 text-center text-sm font-semibold text-[#c45f00] transition hover:bg-[#ffe8cc]">
                        {{ __('sede.plataforma.mobile_btn') }}
                    </a>
                </article>

                <article class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex min-h-[120px] items-center justify-center rounded-lg bg-gradient-to-br from-amber-50 to-orange-50">
                        <div class="flex items-center gap-3 text-[#004481]">
                            <svg class="h-14 w-14" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <span class="text-4xl" aria-hidden="true">🔐</span>
                        </div>
                    </div>
                    <h2 class="mt-4 text-center text-lg font-bold text-gray-900">{{ __('sede.plataforma.eid') }}</h2>
                    <p class="mt-3 flex-1 text-center text-sm text-gray-600">{{ __('sede.plataforma.eid_desc') }}</p>
                    <a href="{{ sede_href('es/acceso/certificado-electronico') }}" class="mt-6 inline-flex min-h-[48px] w-full items-center justify-center rounded-full border-2 border-[#f28c00] bg-[#fff4e6] px-4 py-3 text-center text-sm font-semibold text-[#c45f00] transition hover:bg-[#ffe8cc]">
                        {{ __('sede.plataforma.eid_btn') }}
                    </a>
                </article>

                <article class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <div class="flex min-h-[120px] items-center justify-center rounded-lg bg-amber-100/80">
                        <div class="flex gap-2 text-xs font-semibold text-gray-800">
                            <span class="rounded-full bg-white px-3 py-2 shadow">DNI</span>
                            <span class="rounded-full bg-white px-3 py-2 shadow">Acceso</span>
                            <span class="rounded-full bg-white px-3 py-2 shadow">SMS</span>
                        </div>
                    </div>
                    <h2 class="mt-4 text-center text-lg font-bold text-gray-900">{{ __('sede.plataforma.permanent') }}</h2>
                    <p class="mt-3 flex-1 text-center text-sm text-gray-600">
                        {{ __('sede.plataforma.permanent_desc') }}
                        <a href="{{ clave_registro_href() }}" class="font-semibold text-[#e07d00] hover:underline">{{ __('sede.plataforma.register_link') }}</a>.
                    </p>
                    <a href="{{ clave_registro_href() }}" class="mt-6 inline-flex min-h-[48px] w-full items-center justify-center rounded-full border-2 border-[#f28c00] bg-[#fff4e6] px-4 py-3 text-center text-sm font-semibold text-[#c45f00] transition hover:bg-[#ffe8cc]">
                        {{ __('sede.plataforma.permanent_btn') }}
                    </a>
                </article>
            </div>

            <p class="mx-auto mt-10 max-w-3xl text-center text-sm text-gray-600">{{ __('sede.plataforma.auto_ident') }}</p>
            <p class="mt-6 text-center text-sm">
                <a href="{{ sede_identificacion_href() }}" class="font-medium text-[#004481] hover:underline">{{ __('sede.plataforma.back') }}</a>
            </p>
        </div>
    </div>
@endsection
