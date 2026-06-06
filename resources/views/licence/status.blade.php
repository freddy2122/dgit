@extends('layouts.perseo')

@section('title', __('status.title'))

@section('content')
    @include('portal.partials.search-loader')

    <div class="mx-auto max-w-5xl px-4 py-8">
        <nav class="mb-2 flex flex-wrap items-center gap-x-2 gap-y-1 text-sm text-[#004481]">
            <a href="{{ portal_route('home') }}" class="font-medium hover:underline">{{ __('status.breadcrumb_home') }}</a>
            @guest
                <span class="text-gray-300">·</span>
                <a href="{{ portal_route('portal.inscription') }}" class="inline-flex items-center rounded-md bg-[#f28c00] px-2.5 py-1 text-xs font-bold text-white hover:bg-[#e07d00]">
                    {{ __('status.create_account') }}
                </a>
            @endguest
            @auth
                <span class="text-gray-300">·</span>
                <a href="{{ portal_route('dashboard') }}" class="font-medium hover:underline">{{ __('status.breadcrumb_dashboard') }}</a>
            @endauth
            <span class="text-gray-300">·</span>
            <a href="{{ portal_route('documents.verify') }}" class="font-medium hover:underline">{{ __('verify.title') }}</a>
        </nav>

        <h1 class="text-xl font-bold text-[#004481] sm:text-2xl">{{ __('status.title') }}</h1>
        <p class="mt-1 max-w-3xl text-sm text-gray-600">{{ __('status.intro') }}</p>

        @auth
            @if ($authCode)
                <div class="mt-4 flex flex-wrap items-center gap-3 rounded-lg border border-sky-200 bg-sky-50 px-4 py-3 text-sm">
                    <span class="text-gray-700">{{ __('status.auth_code_info') }}</span>
                    <code id="auth-verification-code" class="rounded bg-white px-3 py-1 font-mono text-base font-bold text-[#004481]">{{ $authCode }}</code>
                    <button type="button" data-copy-target="auth-verification-code" class="rounded-lg border border-[#004481] px-3 py-1 text-xs font-semibold text-[#004481] hover:bg-white">
                        {{ __('status.copy_code') }}
                    </button>
                </div>
            @endif
        @endauth

        @if ($errors->any())
            <div class="mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                <ul class="list-inside list-disc space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @php
            $activeTab = $activeTab ?? ($searched ? 'result' : 'search');
            $isResultView = $activeTab === 'result' && $searched;
        @endphp

        <div class="mt-6 flex border-b border-gray-300 text-sm font-semibold" role="tablist">
            <button
                type="button"
                id="tab-search"
                data-status-tab="search"
                role="tab"
                aria-selected="{{ $activeTab === 'search' ? 'true' : 'false' }}"
                class="{{ $activeTab === 'search' ? 'border-b-2 border-[#004481] bg-white px-4 py-2 text-[#004481]' : 'bg-gray-200/80 px-4 py-2 text-gray-500 hover:text-[#004481]' }}"
            >
                {{ __('status.tab_search') }}
            </button>
            <button
                type="button"
                id="tab-result"
                data-status-tab="result"
                role="tab"
                aria-selected="{{ $activeTab === 'result' ? 'true' : 'false' }}"
                aria-disabled="{{ $searched ? 'false' : 'true' }}"
                class="{{ $activeTab === 'result' ? 'border-b-2 border-[#004481] bg-white px-4 py-2 text-[#004481]' : 'bg-gray-200/80 px-4 py-2 text-gray-500' }} {{ $searched ? 'hover:text-[#004481]' : 'cursor-not-allowed opacity-60' }}"
                @disabled(! $searched)
            >
                {{ __('status.tab_result') }}
            </button>
        </div>

        <div class="overflow-hidden rounded-b-lg border border-t-0 border-gray-300 bg-[#eceff2] shadow-sm">
            <div class="{{ $isResultView ? '' : 'flex flex-col lg:flex-row' }}">
                <div class="flex-1 {{ $isResultView ? 'min-w-0' : 'p-6' }}">
                    <div id="panel-search" class="{{ $activeTab === 'search' ? '' : 'hidden' }}">
                        <div class="bg-[#004481] px-4 py-2 text-sm font-semibold text-white">
                            {{ __('status.form_title') }}
                        </div>
                        <div class="border border-t-0 border-gray-300 bg-white p-5">
                            <form id="status-search-form" method="post" action="{{ portal_route('licence.status.search') }}" class="space-y-5">
                                @csrf
                                <div>
                                    <label class="block text-sm font-semibold text-gray-800" for="verification_code">
                                        {{ __('status.verification_code') }}
                                    </label>
                                    <input
                                        id="verification_code"
                                        name="verification_code"
                                        type="text"
                                        value="{{ old('verification_code', $payload['verification_code'] ?? $authCode ?? '') }}"
                                        placeholder="VER-XXXX-XXXX"
                                        class="mt-1 w-full max-w-md rounded border border-gray-400 px-3 py-2 font-mono text-sm uppercase shadow-inner focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]"
                                    />
                                    <p class="mt-1 text-xs text-gray-500">{{ __('status.verification_code_hint') }}</p>
                                    @error('verification_code')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <p class="text-center text-xs font-semibold uppercase tracking-wide text-gray-400">{{ __('status.or_divider') }}</p>

                                <div>
                                    <label class="block text-sm font-semibold text-gray-800" for="nie">
                                        {{ __('status.nie') }}
                                    </label>
                                    <div class="mt-1 flex flex-wrap items-center gap-3">
                                        <input id="nie" name="nie" type="text" value="{{ old('nie', auth()->user()?->nie) }}" class="w-full max-w-xs rounded border border-gray-400 px-3 py-2 text-sm uppercase shadow-inner focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481] sm:w-56" />
                                        <span class="text-xs text-gray-500">{{ __('status.nie_hint') }}</span>
                                    </div>
                                    @error('nie')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-800">{{ __('status.birth_date') }}</label>
                                    <div class="mt-1 flex flex-wrap items-center gap-2">
                                        @php $bd = auth()->user()?->birth_date; @endphp
                                        <input name="birth_day" type="text" inputmode="numeric" maxlength="2" placeholder="JJ" value="{{ old('birth_day', $bd?->format('d')) }}" class="w-14 rounded border border-gray-400 px-2 py-2 text-center text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                                        <span class="text-gray-500">/</span>
                                        <input name="birth_month" type="text" inputmode="numeric" maxlength="2" placeholder="MM" value="{{ old('birth_month', $bd?->format('m')) }}" class="w-14 rounded border border-gray-400 px-2 py-2 text-center text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                                        <span class="text-gray-500">/</span>
                                        <input name="birth_year" type="text" inputmode="numeric" maxlength="4" placeholder="AAAA" value="{{ old('birth_year', $bd?->format('Y')) }}" class="w-20 rounded border border-gray-400 px-2 py-2 text-center text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                                        <span class="text-xs text-gray-500">{{ __('status.birth_hint') }}</span>
                                    </div>
                                    @error('birth_day')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    @error('birth_month')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                    @error('birth_year')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="flex flex-wrap gap-3">
                                    <button type="submit" class="rounded-lg bg-[#004481] px-6 py-2 text-sm font-semibold text-white shadow hover:bg-[#003366]">
                                        {{ __('status.search') }}
                                    </button>
                                    <a href="{{ portal_route('licence.status', ['reset' => 1]) }}" class="rounded-lg border border-[#004481] bg-white px-6 py-2 text-sm font-semibold text-[#004481] hover:bg-sky-50">
                                        {{ __('status.clear') }}
                                    </a>
                                </div>
                                <p class="text-xs text-gray-600">{{ __('status.search_hint') }}</p>
                            </form>
                        </div>
                    </div>

                    <div id="panel-result" class="{{ $activeTab === 'result' ? '' : 'hidden' }}">
                        <div class="bg-[#004481] px-4 py-2 text-sm font-semibold text-white">
                            {{ __('status.result_title') }}
                        </div>
                        <div class="border border-t-0 border-gray-300 bg-white">
                            @if ($searched)
                                <div class="w-full p-4 sm:p-6">
                                @include('licence.partials.status-result-rich', [
                                    'user' => $user ?? null,
                                    'application' => $application ?? null,
                                    'payload' => $payload ?? [],
                                    'photoSrc' => $photoSrc ?? null,
                                ])
                                <div class="mt-6 border-t border-gray-100 pt-4">
                                    <a href="{{ portal_route('licence.status') }}" data-status-tab="search" class="text-sm font-semibold text-[#004481] hover:underline">
                                        ← {{ __('status.tab_search') }}
                                    </a>
                                </div>
                                </div>
                            @else
                                <p class="text-sm text-gray-600">{{ __('status.result_empty') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="{{ $isResultView ? 'hidden' : 'hidden w-40 shrink-0 bg-gradient-to-l from-[#004481]/20 to-transparent lg:block' }}" aria-hidden="true">
                    <div class="flex h-full min-h-[280px] items-end justify-center pb-6 opacity-30">
                        <span class="text-7xl grayscale">🚗</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex flex-wrap gap-4 text-sm">
            @guest
                <a href="{{ portal_route('login') }}" class="font-semibold text-[#004481] hover:underline">{{ __('status.login_cta') }}</a>
                <a href="{{ portal_route('portal.inscription') }}" class="font-semibold text-[#f28c00] hover:underline">{{ __('status.register_cta') }}</a>
            @endguest
            @auth
                <a href="{{ portal_route('dashboard') }}" class="font-semibold text-[#004481] hover:underline">{{ __('status.breadcrumb_dashboard') }}</a>
            @endauth
        </div>
    </div>
@endsection

@push('scripts')
@include('licence.partials.status-search-script')
@endpush
