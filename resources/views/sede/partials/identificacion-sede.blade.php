@php
    $context = $context ?? 'sede';
    $isMidgt = $context === 'midgt';
@endphp

@auth
    <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-8 text-center">
        <p class="text-sm text-emerald-900">{{ __('portal.ident.already_logged_in') }}</p>
        <a href="{{ portal_route('dashboard') }}" class="mt-4 inline-flex min-h-[48px] items-center justify-center rounded-lg bg-[#004481] px-8 py-3 text-sm font-bold text-white hover:bg-[#003366]">
            {{ __('portal.header.midgt_space') }}
        </a>
    </div>
@else
<div class="text-center">
    <h1 class="text-2xl font-bold text-[#004481] sm:text-3xl">
        {{ $isMidgt ? __('sede.ident.midgt_title') : __('sede.ident.sede_title') }}
    </h1>
    <p class="mx-auto mt-3 max-w-2xl text-base text-gray-600">
        {{ $isMidgt ? __('sede.ident.midgt_sub') : __('sede.ident.sede_sub') }}
    </p>
</div>

<div class="mt-10 grid gap-6 md:grid-cols-3">
    <article class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 text-center shadow-sm">
        <div class="mx-auto flex h-20 w-full max-w-[140px] items-center justify-center">
            <span class="text-3xl font-bold tracking-tight text-gray-800">cl<span class="text-[#f28c00]">@</span>ve</span>
        </div>
        <h2 class="mt-4 text-lg font-bold text-[#004481]">{{ __('sede.ident.clave') }}</h2>
        <p class="mt-2 flex-1 text-sm text-gray-600">{{ __('sede.ident.clave_desc') }}</p>
        <a href="{{ clave_conectar_href(['next' => 'dashboard']) }}" class="mt-6 inline-flex min-h-[44px] w-full items-center justify-center rounded-lg bg-[#004481] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#003366]">
            {{ __('sede.ident.clave_btn') }}
        </a>
    </article>

    <article class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 text-center shadow-sm">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-lg border-2 border-[#004481]/30 bg-sky-50 text-[#004481]" aria-hidden="true">
            <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <h2 class="mt-4 text-lg font-bold text-[#004481]">{{ __('sede.ident.cert') }}</h2>
        <p class="mt-2 flex-1 text-sm text-gray-600">{{ __('sede.ident.cert_desc') }}</p>
        <a href="{{ sede_href('es/acceso/certificado-electronico') }}" class="mt-6 inline-flex min-h-[44px] w-full items-center justify-center rounded-lg bg-[#004481] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#003366]">
            {{ __('sede.ident.cert_btn') }}
        </a>
    </article>

    <article class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 text-center shadow-sm">
        <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-lg border-2 border-[#004481]/30 bg-sky-50 text-[#004481]" aria-hidden="true">
            <svg class="h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4z"/>
            </svg>
        </div>
        <h2 class="mt-4 text-lg font-bold text-[#004481]">{{ __('sede.ident.dnie') }}</h2>
        <p class="mt-2 flex-1 text-sm text-gray-600">{{ __('sede.ident.dnie_desc') }}</p>
        <a href="{{ sede_href('es/acceso/dnie') }}" class="mt-6 inline-flex min-h-[44px] w-full items-center justify-center rounded-lg bg-[#004481] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#003366]">
            {{ __('sede.ident.dnie_btn') }}
        </a>
    </article>
</div>

<div class="mt-10 flex items-start gap-3 rounded-lg bg-sky-50 px-4 py-4 text-sm text-gray-700 sm:items-center sm:px-5">
    <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-[#004481] text-sm font-bold text-white" aria-hidden="true">i</span>
    <p>
        {{ __('sede.ident.hint') }}
        <a href="{{ clave_plataforma_href() }}" class="font-semibold text-[#004481] hover:underline">{{ __('sede.ident.get_clave') }}</a>
        @guest
            {{ __('sede.ident.or_portal') }}
            <a href="{{ route('portal.inscription') }}" class="font-semibold text-[#f28c00] hover:underline">{{ __('sede.ident.create_portal') }}</a>
        @endguest
    </p>
</div>
@endauth
