@extends('layouts.app')

@section('title', __('site.registration.identity_title'))

@section('content')
    <div class="border-b border-gray-200 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <p class="text-xs font-medium uppercase text-[#004481]">{{ __('site.registration.identity_step') }}</p>
            <h1 class="text-xl font-bold text-gray-900">{{ __('site.registration.identity_title') }}</h1>
            <p class="mt-1 text-sm text-gray-600">
                {{ __('site.registration.method_label') }} :
                @if ($auth_method === 'clave_mobile') {{ __('site.registration.method_clave_mobile') }}
                @elseif ($auth_method === 'certificate') {{ __('site.registration.method_certificate') }}
                @else {{ __('site.registration.method_clave_permanent') }}
                @endif
            </p>
        </div>
    </div>

    <div class="mx-auto max-w-lg px-4 py-10 sm:px-6 lg:px-8">
        @include('portal._steps', ['current' => 2])
        <form action="{{ route('portal.identity.store') }}" method="post" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="nie" class="block text-sm font-medium text-gray-700">{{ __('site.registration.nie') }}</label>
                    <input type="text" name="nie" id="nie" value="{{ old('nie', $prefillNie ?? '') }}" required autocomplete="off"
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('nie')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="birth_date" class="block text-sm font-medium text-gray-700">{{ __('site.registration.birth_date') }}</label>
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('birth_date')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('site.registration.phone') }}</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $prefillPhone ?? '') }}" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('site.registration.email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $prefillEmail ?? '') }}" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <p class="mt-4 text-xs text-gray-500">{{ __('site.registration.identity_hint') }}</p>
            <button type="submit" class="mt-6 w-full rounded-lg bg-[#004481] py-3 text-sm font-semibold text-white transition hover:bg-[#003366]">
                {{ __('site.registration.receive_code') }}
            </button>
        </form>
    </div>
@endsection
