@extends('layouts.app')

@section('title', __('auth.login_title'))

@section('content')
    <div class="border-b border-gray-200 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-xl font-bold text-gray-900">{{ __('auth.login_title') }}</h1>
            <p class="mt-1 text-sm text-gray-600">{{ __('auth.login_subtitle') }}</p>
        </div>
    </div>

    <div class="mx-auto max-w-md px-4 py-10 sm:px-6 lg:px-8">
        @if (session('status'))
            <p class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('status') }}</p>
        @endif

        <a
            href="{{ portal_route('clave.conectar') }}"
            class="mb-4 flex w-full min-h-[48px] items-center justify-center gap-2 rounded-xl border-2 border-[#f28c00] bg-[#fff4e6] px-4 py-3 text-sm font-bold text-[#c45f00] shadow-sm transition hover:bg-[#ffe8cc]"
        >
            <span class="text-lg font-bold text-gray-800">cl<span class="text-[#f28c00]">@</span>ve</span>
            <span>{{ __('portal.clave.submit') }}</span>
        </a>

        <p class="mb-4 text-center text-xs text-gray-500">{{ __('portal.clave.or_email') }}</p>

        <form method="post" action="{{ portal_route('login') }}" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('auth.email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required autocomplete="username" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('auth.password') }}</label>
                    <input type="password" name="password" id="password" required autocomplete="current-password" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <button type="submit" class="mt-6 w-full rounded-lg bg-[#004481] py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">
                {{ __('auth.submit') }}
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-gray-600">
            {{ __('auth.no_account') }}
            <a href="{{ portal_route('portal.inscription') }}" class="font-semibold text-[#f28c00] hover:underline">{{ __('auth.register') }}</a>
        </p>
        <p class="mt-3 text-center text-sm">
            <a href="{{ route('licence.status') }}" class="font-semibold text-[#004481] hover:underline">{{ __('auth.status_check') }} →</a>
        </p>
    </div>
@endsection
