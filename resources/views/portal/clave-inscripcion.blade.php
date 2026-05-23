@extends('layouts.app')

@section('title', __('portal.clave.inscripcion_title'))

@section('content')
    <div class="border-b border-gray-200 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <h1 class="text-xl font-bold text-gray-900">{{ __('portal.clave.inscripcion_title') }}</h1>
            <p class="mt-1 text-sm text-gray-600">{{ __('portal.clave.inscripcion_sub') }}</p>
        </div>
    </div>

    <div class="mx-auto max-w-lg px-4 py-10 sm:px-6 lg:px-8">
        <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-6 flex items-center gap-3 border-b border-gray-100 pb-6">
                <div class="flex h-12 w-12 items-center justify-center rounded-lg bg-[#004481] text-lg font-bold text-white">@</div>
                <p class="text-sm text-gray-600">{{ __('portal.clave.inscripcion_direct') }}</p>
            </div>

            <form method="post" action="{{ portal_route('clave.inscripcion.submit') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="doc-type" class="block text-sm font-medium text-gray-700">{{ __('portal.clave.doc_type') }}</label>
                    <select id="doc-type" name="doc_type" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]">
                        <option value="DNI" @selected(old('doc_type') === 'DNI')>DNI</option>
                        <option value="NIE" @selected(old('doc_type') === 'NIE')>NIE</option>
                    </select>
                </div>
                <div>
                    <label for="doc-num" class="block text-sm font-medium text-gray-700">{{ __('portal.clave.nie') }}</label>
                    <input
                        type="text"
                        name="nie"
                        id="doc-num"
                        value="{{ old('nie') }}"
                        required
                        placeholder="12345678a"
                        class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2.5 font-mono text-sm lowercase focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]"
                        autocapitalize="off"
                        spellcheck="false"
                    />
                    @error('nie')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('site.registration.phone') }}</label>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('phone')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('site.registration.email') }}</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2.5 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('email')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="w-full rounded-lg bg-[#004481] py-3 text-sm font-bold text-white hover:bg-[#003366]">
                    {{ __('portal.clave.continue_portal') }}
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-gray-600">
                {{ __('portal.clave.already_clave') }}
                <a href="{{ portal_route('clave.conectar') }}" class="font-semibold text-[#004481] hover:underline">{{ __('portal.clave.submit') }}</a>
            </p>
        </article>
    </div>
@endsection
