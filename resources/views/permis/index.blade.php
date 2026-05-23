@extends('layouts.app')

@section('title', __('sede.permis_index.title'))

@section('content')
    <div class="border-b border-gray-200 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-600" aria-label="{{ __('sede.layout.breadcrumb') }}">
                <a href="{{ route('home') }}" class="font-medium text-[#004481] hover:underline">{{ __('sede.layout.home') }}</a>
                <span class="mx-2 text-gray-400" aria-hidden="true">/</span>
                <span class="text-gray-900">{{ __('sede.permis_index.breadcrumb') }}</span>
            </nav>
            <h1 class="mt-3 text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ __('sede.permis_index.heading') }}</h1>
            <p class="mt-2 max-w-3xl text-base text-gray-600">{{ __('sede.permis_index.intro') }}</p>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[minmax(0,15rem)_1fr]">
            <div class="lg:sticky lg:top-28 lg:self-start">
                @include('layouts.partials.sede-nav', ['path' => 'es/permisos-de-conducir'])
            </div>
            <div class="min-w-0">
                @php $hub = sede_resolve_page('es/permisos-de-conducir'); @endphp
                @if ($hub)
                    <article class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                        @include('permis._sede-page-content', ['page' => $hub])
                    </article>
                @endif
            </div>
        </div>
    </div>
@endsection
