@php
    $variant = $variant ?? 'default';
    $inscriptionUrl = clave_plataforma_href();
    $connexionUrl = clave_conectar_href();
@endphp

@if ($variant === 'hero')
    <div class="rounded-2xl border-2 border-[#004481] bg-gradient-to-br from-[#004481] to-[#003366] p-6 text-white shadow-lg sm:p-8">
        <p class="text-xs font-bold uppercase tracking-widest text-white/80">{{ __('sede.cta.digital_id') }}</p>
        <h2 class="mt-2 text-2xl font-bold sm:text-3xl">{{ __('sede.cta.hero_title') }}</h2>
        <p class="mt-3 max-w-xl text-sm leading-relaxed text-white/90 sm:text-base">{{ __('sede.cta.hero_desc') }}</p>
        <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:flex-wrap">
            <a href="{{ $inscriptionUrl }}" class="inline-flex min-h-[48px] items-center justify-center rounded-lg bg-white px-8 py-3.5 text-base font-bold text-[#004481] shadow transition hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-[#004481]">
                {{ __('sede.cta.register') }}
            </a>
            <a href="{{ $connexionUrl }}" class="inline-flex min-h-[48px] items-center justify-center rounded-lg border-2 border-white/80 bg-transparent px-6 py-3.5 text-base font-semibold text-white transition hover:bg-white/10">
                {{ __('sede.cta.already') }}
            </a>
        </div>
    </div>
@else
    <div class="rounded-xl border-2 border-[#004481]/30 bg-sky-50 p-5 sm:p-6">
        <h2 class="text-lg font-bold text-[#004481]">{{ __('sede.cta.default_title') }}</h2>
        <p class="mt-1 text-sm text-gray-700">{{ __('sede.cta.default_desc') }}</p>
        <a href="{{ $inscriptionUrl }}" class="mt-4 inline-flex w-full items-center justify-center rounded-lg bg-[#004481] px-5 py-3 text-sm font-bold text-white shadow transition hover:bg-[#003366] sm:w-auto sm:min-w-[220px]">
            {{ __('sede.cta.register') }}
        </a>
    </div>
@endif
