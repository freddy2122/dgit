@php
    $active = $active ?? 'index';
@endphp
<nav class="rounded-lg border border-gray-200 bg-white p-3 shadow-sm" aria-label="Parcours permis de conduire">
    <p class="mb-2 text-xs font-semibold uppercase tracking-wide text-gray-500">Parcours maquette</p>
    <ul class="space-y-1 text-sm">
        @foreach ($navItems as $item)
            @php
                $href = $item['slug'] === null ? route('permis.index') : route('permis.page', ['slug' => $item['slug']]);
                $isActive = ($active === 'index' && $item['slug'] === null) || ($item['slug'] !== null && $item['slug'] === $active);
            @endphp
            <li>
                <a
                    href="{{ $href }}"
                    @class([
                        'block rounded-md px-2 py-2 font-medium transition',
                        'bg-sky-50 text-[#004481]' => $isActive,
                        'text-gray-700 hover:bg-gray-50 hover:text-[#004481]' => ! $isActive,
                    ])
                >{{ $item['label'] }}</a>
            </li>
        @endforeach
    </ul>
</nav>
