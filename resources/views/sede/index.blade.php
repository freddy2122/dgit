@extends('layouts.app')

@section('title', __('site.sede.title'))

@section('content')
    <div class="border-b border-gray-200 bg-gradient-to-r from-[#004481] to-[#003366] text-white">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <h1 class="text-2xl font-bold sm:text-3xl">{{ __('site.sede.title') }}</h1>
            <p class="mt-2 max-w-2xl text-sm text-sky-100 sm:text-base">{{ __('site.sede.subtitle') }}</p>
            <p class="mt-3 max-w-3xl text-sm text-sky-50/90">{{ __('site.sede.intro') }}</p>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($cards as $card)
                @php
                    $href = $card['href'];
                    if (! empty($card['auth']) && ! auth()->check()) {
                        $href = portal_route('login');
                    }
                @endphp
                <a href="{{ $href }}" class="group flex flex-col rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:border-[#004481]/40 hover:shadow-md">
                    <span class="text-3xl" aria-hidden="true">{{ $card['icon'] }}</span>
                    <h2 class="mt-4 text-lg font-bold text-gray-900 group-hover:text-[#004481]">
                        {{ __('site.sede.cards.'.$card['key'].'.title') }}
                    </h2>
                    <p class="mt-2 flex-1 text-sm text-gray-600">
                        {{ __('site.sede.cards.'.$card['key'].'.desc') }}
                    </p>
                    <span class="mt-4 text-sm font-semibold text-[#004481]">{{ __('portal.see_all') }} →</span>
                </a>
            @endforeach
        </div>

        <div class="mt-10 text-center">
            @auth
                <a href="{{ portal_route('dashboard') }}" class="inline-flex items-center rounded bg-[#004481] px-6 py-3 text-sm font-bold text-white hover:bg-[#003366]">
                    {{ __('portal.header.midgt_space') }}
                </a>
            @else
                <a href="{{ midgt_acceso_href() }}" class="inline-flex items-center rounded bg-[#004481] px-6 py-3 text-sm font-bold text-white hover:bg-[#003366]">
                    {{ __('site.sede.access_midgt') }}
                </a>
            @endauth
        </div>
    </div>
@endsection
