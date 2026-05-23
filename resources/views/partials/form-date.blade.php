@props([
    'name',
    'id' => null,
    'value' => '',
    'required' => false,
    'min' => null,
    'max' => null,
    'class' => 'mt-1 w-full min-w-0 rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]',
    'label' => null,
])

@php
    $fieldId = $id ?? $name;
    $iso = old($name, $value);
    if ($iso instanceof \DateTimeInterface) {
        $iso = $iso->format('Y-m-d');
    }
    $iso = is_string($iso) ? trim($iso) : '';
    if ($iso !== '' && ! preg_match('/^\d{4}-\d{2}-\d{2}$/', $iso)) {
        try {
            $iso = \Illuminate\Support\Carbon::parse($iso)->format('Y-m-d');
        } catch (\Throwable) {
            $iso = '';
        }
    }
    $display = $iso !== '' ? \Illuminate\Support\Carbon::createFromFormat('Y-m-d', $iso)->format('d/m/Y') : '';
@endphp

<div data-date-field class="date-field">
    @if ($label)
        <label for="{{ $fieldId }}_text" class="block text-xs font-semibold text-gray-500 sm:text-sm sm:font-medium">{{ $label }}</label>
    @endif
    <div class="flex items-stretch gap-2 {{ $label ? 'mt-1' : '' }}">
        <input
            type="text"
            id="{{ $fieldId }}_text"
            data-date-text
            value="{{ $display }}"
            placeholder="{{ __('site.form.date_placeholder') }}"
            inputmode="numeric"
            autocomplete="off"
            @if($required) required aria-required="true" @endif
            @class([$class, 'flex-1'])
        />
        <input
            type="date"
            id="{{ $fieldId }}_picker"
            data-date-native
            class="sr-only"
            tabindex="-1"
            aria-hidden="true"
            @if($min) min="{{ $min }}" @endif
            @if($max) max="{{ $max }}" @endif
        />
        <button
            type="button"
            data-date-picker-btn
            class="inline-flex shrink-0 items-center justify-center rounded-lg border border-gray-300 bg-white px-3 text-gray-600 hover:bg-gray-50 focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]"
            aria-label="{{ __('site.form.date_calendar') }}"
        >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
        </button>
    </div>
    <input type="hidden" name="{{ $name }}" id="{{ $fieldId }}" data-date-value value="{{ $iso }}" data-initial-iso="{{ $iso }}" />
</div>
