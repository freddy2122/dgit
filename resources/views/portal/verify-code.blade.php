@extends('layouts.app')

@section('title', __('site.registration.verify_title'))

@section('content')
    <div class="border-b border-gray-200 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <p class="text-xs font-medium uppercase text-[#004481]">{{ __('site.registration.verify_sub') }}</p>
            <h1 class="text-xl font-bold text-gray-900">{{ __('site.registration.verify_title') }}</h1>
            <p class="mt-1 text-sm text-gray-600">{{ __('site.registration.verify_sent', ['email' => $draft->email]) }}</p>
        </div>
    </div>

    <div class="mx-auto max-w-md px-4 py-10 sm:px-6 lg:px-8">
        @include('portal._steps', ['current' => 3])
        @if (session('status'))
            <div class="mb-4 rounded-lg bg-sky-50 px-4 py-3 text-sm text-[#004481]">{{ session('status') }}</div>
        @endif

        <form action="{{ route('portal.verify.submit') }}" method="post" class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            @csrf
            <label for="code" class="block text-sm font-medium text-gray-700">{{ __('site.registration.verify_label') }}</label>
            <input type="text" name="code" id="code" inputmode="numeric" pattern="[0-9]{6}" maxlength="6" required autocomplete="one-time-code"
                class="mt-2 w-full rounded-lg border border-gray-300 px-3 py-3 text-center text-2xl tracking-[0.4em] focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
            @error('code')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <button type="submit" class="mt-6 w-full rounded-lg bg-[#004481] py-3 text-sm font-semibold text-white transition hover:bg-[#003366]">
                {{ __('site.registration.verify_btn') }}
            </button>
        </form>
    </div>
@endsection
