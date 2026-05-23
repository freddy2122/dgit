@extends('layouts.app')

@section('title', __('sede.registro.title'))

@section('content')
    @include('sede.partials.layout', [
        'navPath' => 'es/acceso/clave/registrarse',
        'breadcrumbs' => [
            ['label' => __('sede.acceso.login'), 'path' => 'es/acceso'],
            ['label' => __('sede.clave.breadcrumb'), 'path' => 'es/acceso/clave'],
            ['label' => __('sede.registro.breadcrumb'), 'path' => null],
        ],
    ])

    <div class="mb-6">
        @include('sede.partials.cta-inscription-clave', ['variant' => 'default'])
    </div>

    <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8" id="clave-registro">
        <p class="text-sm font-medium uppercase tracking-wide text-[#004481]">{{ __('sede.registro.label') }}</p>
        <h1 class="mt-1 text-2xl font-bold text-gray-900">{{ __('sede.registro.heading') }}</h1>
        <p class="mt-2 text-sm text-gray-600">{{ __('sede.registro.intro') }}</p>

        <ol class="mt-8 flex flex-wrap gap-2 border-b border-gray-200 pb-6" aria-label="{{ __('sede.registro.steps_aria') }}">
            @foreach (__('sede.registro.tabs') as $i => $label)
                <li class="clave-step-tab flex items-center gap-2 rounded-full px-3 py-1.5 text-xs font-semibold sm:text-sm {{ $i === 0 ? 'bg-[#004481] text-white' : 'bg-gray-100 text-gray-600' }}" data-step-tab="{{ $i }}">
                    <span class="flex h-6 w-6 items-center justify-center rounded-full bg-white/20 text-xs">{{ $i + 1 }}</span>
                    <span class="hidden sm:inline">{{ $label }}</span>
                </li>
            @endforeach
        </ol>

        <section class="clave-step-panel mt-8" data-step-panel="0">
            <h2 class="text-lg font-bold text-gray-900">{{ __('sede.registro.s1_title') }}</h2>
            <p class="mt-2 text-gray-700">{{ __('sede.registro.s1_text') }}</p>
            <p class="mt-4 rounded-lg border border-sky-200 bg-sky-50 p-4 text-sm text-[#004481]">{{ __('sede.registro.s1_box') }}</p>
            <button type="button" class="clave-next mt-6 rounded-lg bg-[#004481] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">{{ __('sede.registro.continue') }}</button>
        </section>

        <section class="clave-step-panel mt-8 hidden" data-step-panel="1">
            <h2 class="text-lg font-bold text-gray-900">{{ __('sede.registro.s2_title') }}</h2>
            <p class="mt-2 text-gray-700">{{ __('sede.registro.s2_text') }}</p>
            <div class="mt-6 rounded-lg border-2 border-[#004481]/30 bg-sky-50/50 p-8 text-center">
                <button type="button" class="clave-next rounded-lg bg-[#004481] px-8 py-3 text-base font-bold text-white shadow hover:bg-[#003366]">{{ __('sede.registro.s2_btn') }}</button>
            </div>
            <button type="button" class="clave-prev mt-4 text-sm font-medium text-gray-600 hover:text-[#004481]">{{ __('sede.registro.back') }}</button>
        </section>

        <section class="clave-step-panel mt-8 hidden" data-step-panel="2">
            <h2 class="text-lg font-bold text-gray-900">{{ __('sede.registro.s3_title') }}</h2>
            <p class="mt-2 text-gray-700">{{ __('sede.registro.s3_text') }}</p>
            <form class="mt-6 max-w-lg space-y-4" onsubmit="return false;">
                <div>
                    <label for="doc-type" class="block text-sm font-medium text-gray-700">{{ __('sede.registro.doc') }}</label>
                    <select id="doc-type" class="mt-1 w-full border border-gray-300 px-3 py-2.5 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]">
                        <option>DNI</option>
                        <option>NIE</option>
                    </select>
                </div>
                <div>
                    <label for="doc-num" class="block text-sm font-medium text-gray-700">{{ __('sede.registro.doc_num') }}</label>
                    <input id="doc-num" type="text" placeholder="12345678A" class="mt-1 w-full border border-gray-300 px-3 py-2.5 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                </div>
                <div>
                    <label for="doc-exp" class="block text-sm font-medium text-gray-700">{{ __('sede.registro.doc_exp') }}</label>
                    <input id="doc-exp" type="date" class="mt-1 w-full border border-gray-300 px-3 py-2.5 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">{{ __('sede.registro.phone') }}</label>
                    <input id="phone" type="tel" placeholder="+34 600 000 000" class="mt-1 w-full border border-gray-300 px-3 py-2.5 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                </div>
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">{{ __('sede.registro.email') }}</label>
                    <input id="email" type="email" placeholder="usuario@ejemplo.es" class="mt-1 w-full border border-gray-300 px-3 py-2.5 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                </div>
                <div class="flex gap-3 pt-2">
                    <button type="button" class="clave-prev rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('portal.cancel') }}</button>
                    <button type="button" class="clave-next rounded-lg bg-[#004481] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">{{ __('sede.registro.continue') }}</button>
                </div>
            </form>
        </section>

        <section class="clave-step-panel mt-8 hidden" data-step-panel="3">
            <h2 class="text-lg font-bold text-gray-900">{{ __('sede.registro.s4_title') }}</h2>
            <p class="mt-2 text-gray-700">{{ __('sede.registro.s4_text') }}</p>
            <fieldset class="mt-6 space-y-3">
                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-gray-200 p-4 has-[:checked]:border-[#004481] has-[:checked]:bg-sky-50">
                    <input type="radio" name="validacion" value="sms" class="mt-1" checked />
                    <span>
                        <span class="font-semibold text-gray-900">{{ __('sede.registro.sms') }}</span>
                        <span class="mt-1 block text-sm text-gray-600">{{ __('sede.registro.sms_desc') }}</span>
                    </span>
                </label>
                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-gray-200 p-4 has-[:checked]:border-[#004481] has-[:checked]:bg-sky-50">
                    <input type="radio" name="validacion" value="carta" class="mt-1" />
                    <span>
                        <span class="font-semibold text-gray-900">{{ __('sede.registro.letter') }}</span>
                        <span class="mt-1 block text-sm text-gray-600">{{ __('sede.registro.letter_desc') }}</span>
                    </span>
                </label>
                <label class="flex cursor-pointer items-start gap-3 rounded-lg border border-gray-200 p-4 has-[:checked]:border-[#004481] has-[:checked]:bg-sky-50">
                    <input type="radio" name="validacion" value="certificado" class="mt-1" />
                    <span>
                        <span class="font-semibold text-gray-900">{{ __('sede.registro.cert') }}</span>
                        <span class="mt-1 block text-sm text-gray-600">{{ __('sede.registro.cert_desc') }}</span>
                    </span>
                </label>
            </fieldset>
            <div class="mt-6 hidden rounded-lg border border-green-200 bg-green-50 p-4" id="clave-registro-ok">
                <p class="font-semibold text-green-900">{{ __('sede.registro.done_title') }}</p>
                <p class="mt-1 text-sm text-green-800">{{ __('sede.registro.done_text') }}</p>
            </div>
            <div class="mt-6 flex flex-wrap gap-3">
                <button type="button" class="clave-prev rounded-lg border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">{{ __('portal.cancel') }}</button>
                <button type="button" id="clave-finalizar" class="rounded-lg bg-[#004481] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">{{ __('sede.registro.finish') }}</button>
                <a href="{{ sede_href('es/acceso/clave/conectar') }}" id="clave-ir-sede" class="hidden rounded-lg bg-[#f28c00] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#e07d00]">{{ __('sede.registro.go_sede') }}</a>
            </div>
        </section>
    </article>

    @include('sede.partials.layout-end')

    @push('scripts')
    <script>
        (function () {
            var root = document.getElementById('clave-registro');
            if (!root) return;
            var step = 0;
            var tabs = root.querySelectorAll('[data-step-tab]');
            var panels = root.querySelectorAll('[data-step-panel]');
            function showStep(n) {
                step = Math.max(0, Math.min(3, n));
                tabs.forEach(function (tab, i) {
                    var on = i === step;
                    tab.classList.toggle('bg-[#004481]', on);
                    tab.classList.toggle('text-white', on);
                    tab.classList.toggle('bg-gray-100', !on);
                    tab.classList.toggle('text-gray-600', !on);
                });
                panels.forEach(function (p, i) { p.classList.toggle('hidden', i !== step); });
            }
            root.querySelectorAll('.clave-next').forEach(function (btn) {
                btn.addEventListener('click', function () { showStep(step + 1); });
            });
            root.querySelectorAll('.clave-prev').forEach(function (btn) {
                btn.addEventListener('click', function () { showStep(step - 1); });
            });
            tabs.forEach(function (tab) {
                tab.addEventListener('click', function () {
                    showStep(parseInt(tab.getAttribute('data-step-tab'), 10));
                });
            });
            var fin = document.getElementById('clave-finalizar');
            if (fin) {
                fin.addEventListener('click', function () {
                    var ok = document.getElementById('clave-registro-ok');
                    var ir = document.getElementById('clave-ir-sede');
                    if (ok) ok.classList.remove('hidden');
                    if (ir) ir.classList.remove('hidden');
                    fin.classList.add('hidden');
                });
            }
        })();
    </script>
    @endpush
@endsection
