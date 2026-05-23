<div class="border-b border-gray-200 bg-gray-50">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <nav class="text-sm text-gray-600" aria-label="{{ __('sede.layout.breadcrumb') }}">
            <a href="{{ route('home') }}" class="font-medium text-[#004481] hover:underline">{{ __('sede.layout.home') }}</a>
            <span class="mx-2 text-gray-400" aria-hidden="true">/</span>
            <a href="{{ sede_href('es') }}" class="font-medium text-[#004481] hover:underline">{{ __('sede.layout.sede') }}</a>
            @foreach ($breadcrumbs ?? [] as $crumb)
                <span class="mx-2 text-gray-400" aria-hidden="true">/</span>
                @if (! empty($crumb['path']))
                    <a href="{{ sede_href($crumb['path']) }}" class="font-medium text-[#004481] hover:underline">{{ $crumb['label'] }}</a>
                @else
                    <span class="text-gray-900">{{ $crumb['label'] }}</span>
                @endif
            @endforeach
        </nav>
    </div>
</div>

<div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
    <div class="grid gap-10 lg:grid-cols-[minmax(0,15rem)_1fr]">
        <div class="lg:sticky lg:top-28 lg:self-start">
            @include('layouts.partials.sede-nav', ['path' => $navPath ?? 'es/acceso'])
        </div>
        <div class="min-w-0">
