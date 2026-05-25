@extends('layouts.app')

@section('title', __('auth.reset_title'))

@section('content')
    <div class="border-b border-gray-200 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-xl font-bold text-gray-900">{{ __('auth.reset_title') }}</h1>
            <p class="mt-1 text-sm text-gray-600">{{ __('auth.reset_subtitle') }}</p>
        </div>
    </div>

    <div class="mx-auto max-w-md px-4 py-10 sm:px-6 lg:px-8">
        @if (session('status'))
            <p class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('status') }}</p>
        @endif

        <form method="post" action="{{ portal_route('password.reset') }}" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('auth.email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $email) }}" required autocomplete="email" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="code" class="block text-sm font-medium text-gray-700">{{ __('auth.reset_code') }}</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" required inputmode="numeric" maxlength="6" autocomplete="one-time-code" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm tracking-[0.3em] focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('code')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('auth.new_password') }}</label>
                    <input type="password" name="password" id="password" required minlength="8" autocomplete="new-password" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('auth.new_password_confirmation') }}</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8" autocomplete="new-password" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                </div>
            </div>

            <button type="submit" class="mt-6 w-full rounded-lg bg-[#004481] py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">
                {{ __('auth.reset_password') }}
            </button>
        </form>

        <p class="mt-6 text-center text-sm">
            <a href="{{ portal_route('password.forgot') }}" class="font-semibold text-[#004481] hover:underline">{{ __('auth.send_reset_code') }}</a>
        </p>
    </div>
@endsection
