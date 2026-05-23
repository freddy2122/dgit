@extends('layouts.app')

@section('title', $title.' — '.__('sede.mirror.title_suffix'))

@section('content')
    <div class="border-b border-gray-200 bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <nav class="text-sm text-gray-600" aria-label="{{ __('sede.layout.breadcrumb') }}">
                <a href="{{ route('home') }}" class="font-medium text-[#004481] hover:underline">{{ __('sede.layout.home') }}</a>
                <span class="mx-2 text-gray-400" aria-hidden="true">/</span>
                <a href="{{ sede_href('es') }}" class="font-medium text-[#004481] hover:underline">{{ __('sede.layout.sede') }}</a>
                <span class="mx-2 text-gray-400" aria-hidden="true">/</span>
                <span class="text-gray-900">{{ $title }}</span>
            </nav>
        </div>
    </div>

    <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
        <div class="grid gap-10 lg:grid-cols-[minmax(0,15rem)_1fr]">
            <div class="lg:sticky lg:top-28 lg:self-start">
                @include('layouts.partials.sede-nav', ['path' => $path, 'sedeNav' => $sedeNav])
            </div>
            <article class="min-w-0 rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
                @if ($page)
                    @include('permis._sede-page-content', ['page' => $page])
                @else
                    <h1 class="text-2xl font-bold text-gray-900 sm:text-3xl">{{ $title }}</h1>
                    <p class="mt-4 text-gray-600">{{ __('sede.mirror.draft') }}</p>
                    <p class="mt-2 font-mono text-sm text-gray-500">/{{ $path }}</p>
                    <div class="mt-8">
                        @include('sede.partials.page-actions', ['page' => ['path' => $path], 'sedePath' => $path])
                    </div>
                @endif
            </article>
        </div>
    </div>
@endsection
