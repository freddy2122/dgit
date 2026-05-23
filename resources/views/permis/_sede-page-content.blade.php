@php
    $sedePath = $page['path'] ?? '';
    $displayTitle = sede_page_title_localized($page);
    $role = sede_page_field($page, 'role');
    $intro = sede_page_list_field($page, 'intro');
    $body = sede_page_list_field($page, 'body');
    $requirements = sede_page_list_field($page, 'requirements');
    $functions = sede_page_list_field($page, 'functions');
    $steps = sede_page_list_field($page, 'steps');
@endphp

@if (! empty($page['title']) && sede_locale() === 'fr' && ($page['title'] ?? '') !== ($page['title_fr'] ?? ''))
    <p class="text-sm font-medium uppercase tracking-wide text-gray-500">{{ $page['title'] }}</p>
@elseif (! empty($page['title_fr']) && sede_locale() === 'es' && ($page['title'] ?? '') !== ($page['title_fr'] ?? ''))
    <p class="text-sm font-medium uppercase tracking-wide text-gray-500">{{ $page['title_fr'] }}</p>
@endif

<h1 class="mt-1 text-2xl font-bold text-gray-900 sm:text-3xl">{{ $displayTitle }}</h1>

@if ($role)
    <p class="mt-4 rounded-lg bg-sky-50 px-4 py-3 text-sm font-medium text-[#004481]">{{ $role }}</p>
@endif

@foreach ($intro as $paragraph)
    <p class="mt-4 text-base leading-relaxed text-gray-700">{{ $paragraph }}</p>
@endforeach

@include('sede.partials.procedure-groups', ['page' => $page])

@if (count($body))
    <div class="mt-8">
        <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('sede.page.body_heading') }}</h2>
        @foreach ($body as $paragraph)
            <p class="mt-3 text-base leading-relaxed text-gray-700">{{ $paragraph }}</p>
        @endforeach
    </div>
@endif

@if (count($requirements))
    <div class="mt-8">
        <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('sede.page.requirements') }}</h2>
        <ul class="mt-3 list-disc space-y-1.5 pl-5 text-gray-700">
            @foreach ($requirements as $req)
                <li>{{ $req }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (count($functions))
    <div class="mt-8">
        <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('sede.page.functions') }}</h2>
        <ul class="mt-3 list-disc space-y-1.5 pl-5 text-gray-700">
            @foreach ($functions as $fn)
                <li>{{ $fn }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (count($steps))
    <div class="mt-8">
        <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('sede.page.steps') }}</h2>
        <ol class="mt-3 list-decimal space-y-2 pl-5 text-gray-700">
            @foreach ($steps as $step)
                <li class="pl-1">{{ $step }}</li>
            @endforeach
        </ol>
    </div>
@endif

@if (! empty($page['children']))
    <div class="mt-10 border-t border-gray-100 pt-8">
        <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('sede.page.sections') }}</h2>
        <ul class="mt-4 grid gap-2 sm:grid-cols-2">
            @foreach ($page['children'] as $child)
                <li>
                    <a href="{{ site_href($child) }}" class="flex items-center justify-between rounded-lg border border-gray-100 bg-gray-50 px-4 py-3 text-sm font-semibold text-[#004481] transition hover:border-[#004481]/30 hover:bg-white">
                        <span>{{ sede_link_label($child) }}</span>
                        <span class="text-gray-400" aria-hidden="true">›</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
@endif

@if (! empty($page['related']))
    <div class="mt-8 border-t border-gray-100 pt-8">
        <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('sede.page.related') }}</h2>
        <ul class="mt-3 space-y-2">
            @foreach ($page['related'] as $link)
                <li>
                    <a href="{{ site_href($link) }}" class="font-medium text-[#004481] hover:underline">{{ sede_link_label($link) }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif

@php
    $normPath = sede_normalize_path($sedePath ?? '');
    $showInscriptionCta = ! str_contains($normPath, 'acceso/clave/registrarse')
        && ! str_contains($normPath, 'acceso/clave/conectar')
        && ! str_contains($normPath, 'acceso/clave/plataforma')
        && $normPath !== 'es/acceso'
        && $normPath !== 'midgt';
@endphp
@if ($showInscriptionCta)
    <div class="mt-10 border-t border-gray-100 pt-8">
        @include('sede.partials.cta-inscription-clave', ['variant' => 'default'])
    </div>
@endif

@include('sede.partials.page-actions', ['page' => $page, 'sedePath' => $sedePath])
