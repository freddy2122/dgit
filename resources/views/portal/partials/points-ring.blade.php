@php
    $pts = (int) ($pts ?? 0);
    $max = max(1, (int) ($max ?? 12));
    $radius = 42;
    $circumference = round(2 * M_PI * $radius, 2);
    $filled = round(($pts / $max) * $circumference, 2);
    $ringClass = $ringClass ?? 'h-28 w-28 sm:h-32 sm:w-32';
@endphp

<div class="{{ $ringClass }} relative shrink-0" role="img" aria-label="{{ $pts }} {{ __('portal.license.points_label') }} {{ __('portal.valid') }} {{ $max }}">
    <svg class="h-full w-full -rotate-90" viewBox="0 0 100 100" aria-hidden="true">
        <circle cx="50" cy="50" r="{{ $radius }}" fill="none" stroke="#e5e7eb" stroke-width="9"/>
        <circle
            cx="50"
            cy="50"
            r="{{ $radius }}"
            fill="none"
            stroke="#059669"
            stroke-width="9"
            stroke-linecap="round"
            stroke-dasharray="{{ $filled }} {{ $circumference }}"
        />
    </svg>
    <div class="absolute inset-0 flex flex-col items-center justify-center">
        <span class="text-2xl font-bold leading-none text-emerald-600 sm:text-3xl">{{ $pts }}</span>
        <span class="mt-0.5 text-xs font-medium text-gray-500">{{ __('portal.license.points_label') }}</span>
    </div>
</div>
