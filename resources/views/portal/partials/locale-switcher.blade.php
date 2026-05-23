@php
    $current = portal_locale();
    $locales = [
        'es' => ['label' => __('portal.lang_es'), 'flag' => '🇪🇸'],
        'fr' => ['label' => __('portal.lang_fr'), 'flag' => '🇫🇷'],
    ];
    $variant = $variant ?? 'light';
    $labelClass = $variant === 'dark' ? 'text-white/90' : 'text-gray-600';
    $selectClass = $variant === 'dark'
        ? 'rounded-lg border border-white/30 bg-[#003366] px-3 py-2 text-sm text-white shadow-sm focus:border-white focus:outline-none focus:ring-1 focus:ring-white'
        : 'rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm text-gray-800 shadow-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]';
@endphp
<form method="post" action="{{ route('portal.locale', ['locale' => $current]) }}" class="flex items-center gap-2">
    @csrf
    <input type="hidden" name="_return" value="{{ request()->getRequestUri() }}">
    <label for="portal-locale-switcher" class="text-xs font-medium {{ $labelClass }}">{{ __('portal.language') }}</label>
    <select
        id="portal-locale-switcher"
        name="locale"
        class="{{ $selectClass }}"
        onchange="this.form.submit()"
        aria-label="{{ __('portal.language') }}"
    >
        @foreach ($locales as $code => $meta)
            <option value="{{ $code }}" @selected($current === $code)>{{ $meta['flag'] }} {{ $meta['label'] }}</option>
        @endforeach
    </select>
</form>
