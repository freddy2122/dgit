@php
    $current = $current ?? 1;
    $steps = [
        1 => __('site.registration.step_method'),
        2 => __('site.registration.step_identity'),
        3 => __('site.registration.step_code'),
        4 => __('site.registration.step_password'),
    ];
@endphp
<nav class="mb-6" aria-label="{{ __('site.registration.platform_title') }}">
    <ol class="flex flex-wrap gap-2 text-xs sm:gap-3 sm:text-sm">
        @foreach ($steps as $n => $label)
            <li class="flex items-center gap-2">
                <span
                    class="inline-flex h-7 min-w-[1.75rem] items-center justify-center rounded-full px-1.5 font-bold {{ $n === $current ? 'bg-[#004481] text-white' : ($n < $current ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-200 text-gray-600') }}"
                >
                    {{ $n }}
                </span>
                <span class="{{ $n === $current ? 'font-semibold text-gray-900' : 'text-gray-600' }}">{{ $label }}</span>
                @if (! $loop->last)
                    <span class="hidden text-gray-300 sm:inline" aria-hidden="true">→</span>
                @endif
            </li>
        @endforeach
    </ol>
    @if ($current < 4)
        <p class="mt-2 text-xs text-gray-500">{!! __('site.registration.step_hint') !!}</p>
    @endif
</nav>
