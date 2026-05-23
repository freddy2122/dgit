@extends('admin.layout')
@section('page_title', __('admin.nav.settings'))
@section('content')
    @if (session('admin_success'))
        <p class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">{{ session('admin_success') }}</p>
    @endif

    <form method="post" action="{{ route('admin.settings.update') }}" class="max-w-xl space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        <div>
            <h2 class="text-sm font-bold uppercase tracking-wide text-gray-800">{{ __('admin.settings_whatsapp_title') }}</h2>
            <p class="mt-1 text-sm text-gray-600">{{ __('admin.settings_whatsapp_hint') }}</p>
            <label for="gestoria_whatsapp" class="mt-4 block text-sm font-semibold text-gray-700">{{ __('admin.settings_whatsapp_label') }}</label>
            <input
                id="gestoria_whatsapp"
                name="gestoria_whatsapp"
                type="text"
                inputmode="tel"
                value="{{ old('gestoria_whatsapp', $whatsappNumber) }}"
                placeholder="34612345678"
                class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 font-mono text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]"
                required
            />
            <p class="mt-2 text-xs text-gray-500">{{ __('admin.settings_whatsapp_format') }}</p>
            @if ($envWhatsapp && $envWhatsapp !== $whatsappNumber)
                <p class="mt-2 text-xs text-amber-700">{{ __('admin.settings_whatsapp_env_fallback', ['env' => $envWhatsapp]) }}</p>
            @endif
            @error('gestoria_whatsapp')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>
        <button type="submit" class="rounded-lg bg-[#004481] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">
            {{ __('admin.settings_save') }}
        </button>
    </form>

    <p class="mt-6 max-w-xl text-sm text-gray-600">{{ __('admin.settings_info') }}</p>
@endsection
