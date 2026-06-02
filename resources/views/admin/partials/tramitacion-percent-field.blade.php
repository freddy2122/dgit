@php
    $app = $application;
    $suggested = $app->suggestedTramitacionPercent();
    $display = $app->clientTramitacionPercent();
@endphp
<form method="post" action="{{ route('admin.applications.update_tramitacion', $app) }}" class="flex flex-wrap items-center gap-2">
    @csrf
    @method('PATCH')
    <input
        type="number"
        name="tramitacion_percent"
        min="0"
        max="100"
        value="{{ $app->tramitacion_percent }}"
        placeholder="{{ $suggested }}"
        title="{{ __('admin.tramitacion_auto_hint', ['percent' => $suggested]) }}"
        class="w-16 rounded border border-gray-300 px-2 py-1 text-sm"
        aria-label="{{ __('admin.tramitacion_percent') }}"
    />
    <span class="text-xs text-gray-500">%</span>
    <button type="submit" class="rounded bg-[#004481] px-2 py-1 text-xs font-bold text-white" title="{{ __('admin.save_tramitacion') }}">OK</button>
</form>
@if ($app->tramitacion_percent === null)
    <p class="mt-1 text-xs text-gray-400">{{ __('admin.tramitacion_shown_auto', ['percent' => $display]) }}</p>
@endif
