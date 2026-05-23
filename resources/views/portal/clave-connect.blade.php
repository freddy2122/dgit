@extends('layouts.app')

@section('title', __('portal.clave.connect_title'))

@section('content')
    <div class="border-b border-gray-200 bg-gradient-to-r from-[#004481] to-[#003366] text-white">
        <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-xl bg-white/15 text-2xl font-bold">@</div>
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-white/80">Cl@ve</p>
                    <h1 class="text-xl font-bold sm:text-2xl">{{ __('portal.clave.connect_title') }}</h1>
                    <p class="mt-1 text-sm text-sky-100">{{ __('portal.clave.connect_sub') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mx-auto max-w-md px-4 py-10 sm:px-6 lg:px-8">
        @if (session('status'))
            <p class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('status') }}</p>
        @endif

        @if ($intent === 'register')
            <p class="mb-4 rounded-lg border border-sky-200 bg-sky-50 px-4 py-3 text-sm text-[#004481]">
                {{ __('portal.clave.register_banner') }}
            </p>
        @endif

        <form method="post" action="{{ portal_route('clave.conectar.submit') }}" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            @csrf
            <input type="hidden" name="intent" value="{{ $intent }}" />
            @if ($next)
                <input type="hidden" name="next" value="{{ $next }}" />
            @endif

            <div class="space-y-4">
                <div>
                    <label for="clave-nie" class="block text-sm font-medium text-gray-700">{{ __('portal.clave.nie') }}</label>
                    <input
                        type="text"
                        name="nie"
                        id="clave-nie"
                        value="{{ $prefillNie }}"
                        required
                        autocomplete="username"
                        placeholder="12345678a"
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2.5 font-mono text-sm lowercase focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]"
                        autocapitalize="off"
                        spellcheck="false"
                    />
                    @error('nie')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="clave-pass" class="block text-sm font-medium text-gray-700">{{ __('portal.clave.password') }}</label>
                    <input
                        type="password"
                        name="password"
                        id="clave-pass"
                        required
                        autocomplete="current-password"
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]"
                    />
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>

            <button type="submit" class="mt-6 w-full rounded-lg bg-[#004481] py-3 text-sm font-bold text-white shadow transition hover:bg-[#003366]">
                {{ $intent === 'register' ? __('portal.clave.continue_register') : __('portal.clave.submit') }}
            </button>
        </form>

        <div class="mt-6 space-y-3 text-center text-sm text-gray-600">
            @if ($intent !== 'register')
                <p>
                    {{ __('portal.clave.no_clave') }}
                    <a href="{{ portal_route('clave.inscripcion') }}" class="font-semibold text-[#f28c00] hover:underline">{{ __('portal.clave.create_clave') }}</a>
                </p>
            @endif
            <p>
                {{ __('portal.clave.portal_account') }}
                <a href="{{ portal_route('portal.inscription') }}" class="font-semibold text-[#004481] hover:underline">{{ __('portal.clave.portal_wizard') }}</a>
            </p>
            <p>
                <a href="{{ portal_route('login') }}" class="font-semibold text-[#004481] hover:underline">{{ __('portal.clave.email_login') }}</a>
            </p>
        </div>
    </div>
@endsection
