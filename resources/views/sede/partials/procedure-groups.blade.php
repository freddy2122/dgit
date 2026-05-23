@php
    $groups = sede_procedure_groups($page ?? []);
@endphp

@if (count($groups))
    <div class="mt-10 border-t border-gray-100 pt-8">
        <h2 class="text-sm font-bold uppercase tracking-wide text-gray-500">{{ __('sede.page.procedure_groups') }}</h2>
        @foreach ($groups as $group)
            <div class="mt-6">
                <h3 class="text-base font-bold text-gray-900">{{ $group['group'] ?? '' }}</h3>
                <ul class="mt-3 divide-y divide-gray-100 rounded-lg border border-gray-200 bg-gray-50/80">
                    @foreach ($group['items'] ?? [] as $item)
                        <li>
                            <a
                                href="{{ sede_procedure_href($item) }}"
                                @if (sede_procedure_is_official($item)) target="_blank" rel="noopener noreferrer" @endif
                                class="flex flex-wrap items-center justify-between gap-2 px-4 py-3 text-sm font-semibold text-[#004481] transition hover:bg-white"
                            >
                                <span>{{ $item['title'] ?? '' }}</span>
                                @if (sede_procedure_is_official($item))
                                    <span class="rounded bg-gray-200 px-2 py-0.5 text-[0.65rem] font-bold uppercase tracking-wide text-gray-600">{{ __('sede.page.procedure_official_badge') }}</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>
@endif
