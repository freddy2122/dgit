@php
    $sedeNav = $sedeNav ?? config('dgt_sede_nav', []);
    $activePath = isset($path) ? sede_normalize_path($path) : null;
@endphp
<nav class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm" aria-label="{{ __('sede.layout.nav_title') }}">
    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">{{ __('sede.layout.nav_title') }}</p>
    <ul class="space-y-3 text-sm">
        @foreach ($sedeNav as $section)
            <li>
                <a
                    href="{{ site_href($section) }}"
                    class="block font-bold text-[#004481] hover:underline"
                >{{ sede_nav_label($section) }}</a>
                @if (! empty($section['children']))
                    <ul class="mt-1 space-y-0.5 border-l-2 border-gray-100 pl-3">
                        @foreach ($section['children'] as $child)
                            @php
                                $childNorm = sede_normalize_path($child['path'] ?? '');
                                $isActive = $activePath && $childNorm === $activePath;
                            @endphp
                            <li>
                                <a
                                    href="{{ site_href($child) }}"
                                    @class([
                                        'block rounded py-1.5 pl-1 transition',
                                        'bg-sky-50 font-semibold text-[#004481]' => $isActive,
                                        'text-gray-700 hover:text-[#004481]' => ! $isActive,
                                    ])
                                >{{ sede_nav_label($child) }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</nav>
