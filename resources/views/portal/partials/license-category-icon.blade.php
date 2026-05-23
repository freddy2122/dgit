@php
    $code = strtoupper((string) ($code ?? 'B'));
    $class = $class ?? 'license-cat-picto block h-[11px] w-auto max-w-[9.5rem] object-contain object-left sm:h-[12px]';
    $color = $color ?? '#003399';
    $inactive = str_contains((string) $color, '66') || str_contains((string) $color, '80');
    $opacityClass = $inactive ? 'opacity-40' : 'opacity-100';

    $file = config('license_category_icons.files')[$code]
        ?? config('license_category_icons.files.B');
    $path = public_path('images/license-categories/'.$file);
@endphp

@if (is_file($path))
    <img
        src="{{ asset('images/license-categories/'.$file) }}"
        alt=""
        class="{{ $class }} {{ $opacityClass }}"
        aria-hidden="true"
    />
@endif
