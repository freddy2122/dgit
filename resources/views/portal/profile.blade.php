@php $portalNavActive = 'profile'; @endphp
@extends('layouts.portal')

@section('title', __('portal.profile.title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('portal.profile.title') }}</h1>
    <p class="text-sm text-gray-500">{{ __('portal.profile.subtitle') }}</p>
@endsection

@section('content')
    @if (session('portal_success'))
        <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-900">{{ session('portal_success') }}</div>
    @endif

    @if ($user->verification_code)
        <section class="mb-6 overflow-hidden rounded-xl border border-[#004481]/25 bg-sky-50 shadow-sm">
            <div class="border-b border-sky-100 px-5 py-4">
                <h2 class="font-bold text-gray-900">{{ __('portal.verification.title') }}</h2>
                <p class="mt-1 text-sm text-gray-600">{{ __('portal.verification.subtitle') }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-4 px-5 py-4">
                <code id="profile-verification-code" class="rounded-lg bg-white px-4 py-2 font-mono text-lg font-bold text-[#004481] shadow-sm">{{ $user->verification_code }}</code>
                <button type="button" data-copy-target="profile-verification-code" data-copied="{{ e(__('portal.verification.copied')) }}" class="rounded-lg border border-[#004481] px-4 py-2 text-sm font-semibold text-[#004481] hover:bg-white">
                    {{ __('portal.verification.copy') }}
                </button>
                <a href="{{ portal_licence_status_href() }}" class="text-sm font-semibold text-[#004481] hover:underline">{{ __('portal.verification.check_status') }} →</a>
                <a href="{{ route('documents.verify') }}" class="text-sm font-semibold text-[#004481] hover:underline">{{ __('portal.verification.verify_doc') }} →</a>
            </div>
        </section>
    @endif

    <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <dl class="grid gap-0 sm:grid-cols-2">
            @foreach ([
                ['label' => __('portal.profile.name'), 'value' => trim(collect([$user->first_name, $user->last_name])->filter()->join(' ')) ?: $user->name],
                ['label' => __('portal.license.nie'), 'value' => $user->nie ?? '—', 'mono' => true],
                ['label' => __('portal.profile.email'), 'value' => $user->email],
                ['label' => __('portal.profile.phone'), 'value' => $user->phone ?? '—'],
                ['label' => __('portal.profile.birth_date'), 'value' => $user->birth_date?->format('d/m/Y') ?? '—'],
                ['label' => __('portal.profile.file_number'), 'value' => $user->dossier_number ?? '—', 'mono' => true],
                ['label' => __('portal.profile.address'), 'value' => $user->address ?? '—', 'span' => 2],
            ] as $field)
                <div class="border-b border-gray-50 px-5 py-4 {{ ($field['span'] ?? 0) === 2 ? 'sm:col-span-2' : '' }}">
                    <dt class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ $field['label'] }}</dt>
                    <dd class="mt-1 text-sm font-semibold text-gray-900 {{ ! empty($field['mono']) ? 'font-mono' : '' }}">{{ $field['value'] }}</dd>
                </div>
            @endforeach
        </dl>
        <p class="border-t border-gray-100 bg-slate-50/80 px-5 py-3 text-xs text-gray-500">{{ __('portal.profile.edit_hint') }}</p>
    </section>

    <section class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-100 px-5 py-4">
            <h2 class="font-bold text-gray-900">{{ __('portal.profile.password_title') }}</h2>
            <p class="mt-1 text-sm text-gray-600">{{ __('portal.profile.password_subtitle') }}</p>
        </div>
        <form method="post" action="{{ portal_route('portal.profile.password') }}" class="space-y-4 px-5 py-5">
            @csrf
            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700">{{ __('portal.profile.current_password') }}</label>
                <input id="current_password" type="password" name="current_password" required autocomplete="current-password" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                @error('current_password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div class="grid gap-4 sm:grid-cols-2">
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('portal.profile.new_password') }}</label>
                    <input id="password" type="password" name="password" required minlength="8" autocomplete="new-password" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">{{ __('portal.profile.new_password_confirmation') }}</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required minlength="8" autocomplete="new-password" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                </div>
            </div>
            <button type="submit" class="rounded-lg bg-[#004481] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">
                {{ __('portal.profile.password_submit') }}
            </button>
        </form>
    </section>

    @include('portal.partials.profile-documents', ['user' => $user])
@endsection

@push('scripts')
<script>
document.querySelectorAll('[data-copy-target]').forEach((btn) => {
    btn.addEventListener('click', () => {
        const el = document.getElementById(btn.dataset.copyTarget);
        if (!el) return;
        navigator.clipboard.writeText(el.textContent.trim());
        const prev = btn.textContent;
        const copiedLabel = btn.dataset.copied ?? '';
        btn.textContent = copiedLabel;
        setTimeout(() => { btn.textContent = prev; }, 2000);
    });
});
</script>
@endpush
