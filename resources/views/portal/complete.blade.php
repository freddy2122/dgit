@extends('layouts.app')

@section('title', __('site.registration.complete_title'))

@section('content')
    <div class="border-b border-gray-200 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <p class="text-xs font-medium uppercase text-[#004481]">{{ __('site.registration.complete_step') }}</p>
            <h1 class="text-xl font-bold text-gray-900">{{ __('site.registration.complete_heading') }}</h1>
        </div>
    </div>

    <div class="mx-auto max-w-xl px-4 py-10 sm:px-6 lg:px-8">
        @include('portal._steps', ['current' => 4])
        @if (session('status'))
            <div class="mb-4 rounded-lg bg-sky-50 px-4 py-3 text-sm text-[#004481]">{{ session('status') }}</div>
        @endif

        <form action="{{ route('portal.complete.store') }}" method="post" enctype="multipart/form-data" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            @csrf
            <div class="grid gap-4 sm:grid-cols-2">
                <div class="sm:col-span-1">
                    <label for="first_name" class="block text-sm font-medium text-gray-700">{{ __('site.registration.first_name') }}</label>
                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('first_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-1">
                    <label for="last_name" class="block text-sm font-medium text-gray-700">{{ __('site.registration.last_name') }}</label>
                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('last_name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="nie" class="block text-sm font-medium text-gray-700">{{ __('site.registration.nie') }}</label>
                    <input type="text" name="nie" id="nie" value="{{ old('nie', $draft->nie) }}" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('nie')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('site.registration.phone') }}</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone', $draft->phone) }}" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('site.registration.email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $draft->email) }}" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2 space-y-4 rounded-lg border-2 border-[#004481]/20 bg-sky-50/50 p-4">
                    <p class="text-sm font-semibold text-[#004481]">{{ __('site.registration.password_section') }}</p>
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700">{{ __('site.registration.password') }}</label>
                        <input type="password" name="password" id="password" required minlength="8" autocomplete="new-password"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                        @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('site.registration.password_confirm') }}</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" required minlength="8" autocomplete="new-password"
                            class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700">{{ __('site.registration.address') }}</label>
                    <textarea name="address" id="address" rows="3" required
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]">{{ old('address') }}</textarea>
                    @error('address')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">{{ __('site.registration.dni_recto') }}</label>
                    <input type="file" name="dni_recto" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 w-full text-sm text-gray-600" />
                    @error('dni_recto')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">{{ __('site.registration.dni_verso') }}</label>
                    <input type="file" name="dni_verso" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 w-full text-sm text-gray-600" />
                    @error('dni_verso')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="sm:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">{{ __('site.registration.signature') }}</label>
                    <p class="mt-1 text-xs text-gray-500">{{ __('site.registration.signature_hint') }}</p>
                    <input type="file" name="signature" accept=".jpg,.jpeg,.png" class="mt-2 w-full text-sm text-gray-600" />
                    @error('signature')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
            </div>
            <button type="submit" class="mt-6 w-full rounded-lg bg-[#f28c00] py-3 text-sm font-semibold text-white transition hover:bg-[#e07d00]">
                {{ __('site.registration.submit') }}
            </button>
        </form>
    </div>
@endsection
