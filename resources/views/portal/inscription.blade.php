@extends('layouts.app')

@section('title', __('site.registration.platform_title'))

@section('content')
    <div class="border-b border-gray-200 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-xl font-bold text-gray-900">{{ __('site.registration.platform_title') }}</h1>
            <p class="mt-1 text-sm text-gray-600">{{ __('site.registration.step1_sub') }}</p>
        </div>
    </div>

    <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-8">
        @include('portal._steps', ['current' => 1])

        <div class="grid gap-6 lg:grid-cols-2">
            {{-- Cl@ve : accès direct (pas de POST intermédiaire) --}}
            <article class="flex flex-col rounded-xl border-2 border-[#f28c00]/50 bg-white p-6 shadow-sm lg:col-span-2 lg:flex-row lg:items-center lg:gap-8">
                <div class="flex-1">
                    <span class="inline-flex w-fit rounded bg-[#f28c00] px-2 py-0.5 text-xs font-bold uppercase text-white">{{ __('site.registration.new_badge') }}</span>
                    <h2 class="mt-4 text-lg font-bold text-gray-900">{{ __('site.registration.clave_mobile') }}</h2>
                    <p class="mt-2 text-sm text-gray-600">{{ __('portal.clave.inscription_card_desc') }}</p>
                </div>
                <div class="flex shrink-0 flex-col gap-3 sm:flex-row lg:flex-col">
                    <a
                        href="{{ portal_route('clave.conectar', ['intent' => 'register']) }}"
                        class="inline-flex min-h-[48px] items-center justify-center rounded-full border-2 border-[#f28c00] bg-[#fff4e6] px-6 py-3 text-sm font-semibold text-[#c45f00] hover:bg-[#ffe8cc]"
                    >
                        {{ __('portal.clave.connect_and_continue') }}
                    </a>
                    <a
                        href="{{ portal_route('clave.inscripcion') }}"
                        class="inline-flex min-h-[48px] items-center justify-center rounded-lg border border-[#004481] px-6 py-3 text-sm font-semibold text-[#004481] hover:bg-sky-50"
                    >
                        {{ __('portal.clave.create_clave') }}
                    </a>
                </div>
            </article>

            {{-- Certificat : parcours page par page --}}
            <form action="{{ portal_route('portal.inscription.choose') }}" method="post" class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                @csrf
                <input type="hidden" name="auth_method" value="certificate">
                <h2 class="text-lg font-bold text-gray-900">{{ __('site.registration.certificate') }}</h2>
                <p class="mt-2 flex-1 text-sm text-gray-600">{{ __('site.registration.certificate_desc') }}</p>
                <p class="mt-3 text-xs font-medium text-[#004481]">{{ __('portal.clave.wizard_hint') }}</p>
                <button type="submit" class="mt-6 inline-flex min-h-[48px] w-full items-center justify-center rounded-full border-2 border-[#004481] bg-sky-50 px-4 py-3 text-sm font-semibold text-[#004481] hover:bg-sky-100">
                    {{ __('site.registration.certificate_btn') }}
                </button>
            </form>

            {{-- Connexion Cl@ve existante --}}
            <article class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                <h2 class="text-lg font-bold text-gray-900">{{ __('portal.clave.already_title') }}</h2>
                <p class="mt-2 flex-1 text-sm text-gray-600">{{ __('portal.clave.already_desc') }}</p>
                <a
                    href="{{ portal_route('clave.conectar') }}"
                    class="mt-6 inline-flex min-h-[48px] w-full items-center justify-center rounded-lg bg-[#004481] px-4 py-3 text-sm font-bold text-white hover:bg-[#003366]"
                >
                    {{ __('portal.clave.submit') }}
                </a>
                <a href="{{ portal_route('login') }}" class="mt-3 text-center text-sm font-semibold text-[#004481] hover:underline">
                    {{ __('portal.clave.email_login') }}
                </a>
            </article>
        </div>

        @if ($errors->any())
            <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ $errors->first() }}
            </div>
        @endif

        <p class="mt-8 text-center text-sm text-gray-600">
            {{ __('site.registration.already_registered') }}
            <a href="{{ portal_route('login') }}" class="font-semibold text-[#004481] hover:underline">{{ __('site.registration.login_link') }}</a>
        </p>
    </div>
@endsection
