@php
    $sedePath = $sedePath ?? ($page['path'] ?? '');
    $tramite = sede_tramite_action($sedePath);
    $service = $tramite ? null : sede_local_service($sedePath);
@endphp

<div class="mt-10 flex flex-col gap-3 border-t border-gray-100 pt-8 sm:flex-row sm:flex-wrap sm:items-center">
    @if ($tramite)
        @if (! empty($tramite['external']))
            <a
                href="{{ $tramite['href'] }}"
                target="_blank"
                rel="noopener noreferrer"
                class="inline-flex min-h-[48px] items-center justify-center gap-2 rounded-lg bg-[#25D366] px-6 py-3 text-sm font-bold text-white shadow transition hover:bg-[#1da851] focus:outline-none focus:ring-2 focus:ring-[#25D366] focus:ring-offset-2"
            >
                {{ $tramite['label'] }}
            </a>
            <p class="mt-2 text-xs text-gray-600">{{ __('tramite.gestoria_sede_hint') }}</p>
        @else
        <form method="{{ $tramite['method'] }}" action="{{ $tramite['href'] }}" class="inline">
            @if ($tramite['method'] === 'post')
                @csrf
                @foreach ($tramite['hidden'] ?? [] as $name => $value)
                    <input type="hidden" name="{{ $name }}" value="{{ $value }}" />
                @endforeach
            @endif
            <button
                type="submit"
                class="inline-flex min-h-[48px] items-center justify-center rounded-lg bg-[#004481] px-6 py-3 text-sm font-bold text-white shadow transition hover:bg-[#003366] focus:outline-none focus:ring-2 focus:ring-[#004481] focus:ring-offset-2"
            >
                {{ $tramite['label'] }}
            </button>
        </form>
        @endif
    @elseif ($service)
        <a
            href="{{ $service['href'] }}"
            class="inline-flex min-h-[48px] items-center justify-center rounded-lg bg-[#004481] px-6 py-3 text-sm font-bold text-white shadow transition hover:bg-[#003366] focus:outline-none focus:ring-2 focus:ring-[#004481] focus:ring-offset-2"
        >
            {{ $service['label'] }}
        </a>
    @endif
</div>
