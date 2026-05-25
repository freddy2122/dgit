@extends('admin.layout')
@section('page_title', $user->name)
@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <p class="text-sm text-gray-500">{{ $user->email }} · <span class="font-mono">{{ $user->nie }}</span></p>
        <p class="mt-1 text-xs text-gray-500">{{ __('admin.dossier') }}: {{ $user->dossier_number ?? '—' }}</p>
    </div>
    <div class="flex flex-wrap gap-2">
        <a href="{{ route('admin.applications.create', ['user_id' => $user->id]) }}" class="rounded-lg bg-[#004481] px-4 py-2 text-sm font-semibold text-white hover:bg-[#003366]">{{ __('admin.create_application') }}</a>
        <form method="post" action="{{ route('admin.users.regenerate_code', $user) }}">@csrf
            <button type="submit" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-800 hover:bg-gray-50">{{ __('admin.regenerate_code') }}</button>
        </form>
    </div>
</div>

<div class="grid gap-6 xl:grid-cols-3">
    <section class="xl:col-span-2 space-y-6">
        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900">{{ __('admin.client_permit') }}</h2>
            @php
                $lic = $user->licenseSummary;
                $activeCategories = collect($lic?->categories_data ?? [])
                    ->filter(fn ($row) => $row['active'] ?? false)
                    ->pluck('code')
                    ->all();
                $allCategoryCodes = \App\Models\LicenseSummary::categoryCodes();
            @endphp
            <form method="post" action="{{ route('admin.users.update_license', $user) }}" class="mt-4 grid gap-4 sm:grid-cols-2">
                @csrf
                <div>
                    <label class="text-xs font-semibold text-gray-500">{{ __('admin.points') }}</label>
                    <input type="number" name="points" min="0" max="12" value="{{ $lic?->points ?? 0 }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500">{{ __('admin.category') }}</label>
                    <input type="text" name="category" value="{{ $lic?->category }}" placeholder="B" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                </div>
                <div>
                    @include('partials.form-date', [
                        'name' => 'issued_at',
                        'value' => $lic?->issued_at?->format('Y-m-d'),
                        'label' => __('admin.issued_at'),
                        'class' => 'mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm',
                    ])
                </div>
                <div>
                    @include('partials.form-date', [
                        'name' => 'valid_until',
                        'value' => $lic?->valid_until?->format('Y-m-d'),
                        'label' => __('admin.valid_until'),
                        'class' => 'mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm',
                    ])
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500">{{ __('admin.authority_code') }}</label>
                    <input type="text" name="authority_code" value="{{ $lic?->authority_code ?: '28-00' }}" maxlength="8" placeholder="28-00" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm font-mono" />
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-500">{{ __('admin.table.status') }}</label>
                    <select name="application_status" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @foreach (['en_attente','en_attente_paiement_whatsapp','en_tramitacion','permiso_provisional','en_fabricacion','expedido','valide','refuse'] as $st)
                        <option value="{{ $st }}" @selected(($lic?->application_status ?? 'en_attente') === $st)>{{ permit_status_label($st) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="sm:col-span-2">
                    <label class="text-xs font-semibold text-gray-500">{{ __('admin.license_categories') }}</label>
                    <p class="mt-1 text-xs text-gray-500">{{ __('admin.license_categories_hint') }}</p>
                    @if ($activeCategories !== [])
                    <p class="mt-2 rounded-lg border border-sky-100 bg-sky-50 px-3 py-2 font-mono text-sm font-bold text-[#004481]">
                        {{ __('admin.license_categories_preview') }} : {{ implode('  ', $activeCategories) }}
                    </p>
                    @else
                    <p class="mt-2 text-xs text-amber-700">{{ __('admin.license_categories_empty') }}</p>
                    @endif
                    <div class="mt-3 flex flex-wrap gap-2">
                        @foreach ($allCategoryCodes as $code)
                        <label class="inline-flex cursor-pointer items-center gap-1.5 rounded-lg border border-gray-200 bg-slate-50 px-2.5 py-1.5 text-sm font-bold font-mono transition hover:border-[#004481]/40 has-[:checked]:border-[#004481] has-[:checked]:bg-sky-50 has-[:checked]:text-[#004481]">
                            <input type="checkbox" name="categories[]" value="{{ $code }}" @checked(in_array($code, $activeCategories, true)) class="h-3.5 w-3.5 rounded text-[#004481]" />
                            {{ $code }}
                        </label>
                        @endforeach
                    </div>
                </div>
                <div class="sm:col-span-2">
                    <button type="submit" class="rounded-lg bg-[#004481] px-5 py-2 text-sm font-semibold text-white">{{ __('admin.save_license') }}</button>
                </div>
            </form>
            <form method="post" action="{{ route('admin.users.adjust_points', $user) }}" class="mt-6 flex flex-wrap items-end gap-3 border-t border-gray-100 pt-4">
                @csrf
                <div>
                    <label class="text-xs font-semibold text-gray-500">{{ __('admin.points_delta') }}</label>
                    <input type="number" name="delta" min="-12" max="12" class="mt-1 w-24 rounded-lg border border-gray-300 px-3 py-2 text-sm" required />
                </div>
                <div class="min-w-[200px] flex-1">
                    <label class="text-xs font-semibold text-gray-500">{{ __('admin.points_reason') }}</label>
                    <input type="text" name="reason" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                </div>
                <div class="flex flex-wrap items-center gap-2">
                    <button type="submit" class="rounded-lg border border-[#004481] px-4 py-2 text-sm font-semibold text-[#004481]">{{ __('admin.apply_points') }}</button>
                </div>
            </form>
        </div>

        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900">{{ __('admin.nav.vehicles') }}</h2>
            @if ($user->vehicles->isEmpty())
                <p class="mt-3 text-sm text-gray-500">—</p>
            @else
            <ul class="mt-3 divide-y text-sm">
                @foreach ($user->vehicles as $v)
                <li class="flex items-center justify-between py-3">
                    <span class="font-mono font-bold">{{ $v->plate }}</span>
                    <span class="text-gray-600">{{ $v->vehicle_type }} · ITV {{ $v->itv_valid_until?->format('d/m/Y') ?? '—' }}</span>
                    <form method="post" action="{{ route('admin.users.destroy_vehicle', [$user, $v]) }}">@csrf @method('DELETE')
                        <button type="submit" class="text-xs text-red-700 hover:underline">{{ __('admin.delete') }}</button>
                    </form>
                </li>
                @endforeach
            </ul>
            @endif
            <form method="post" action="{{ route('admin.users.store_vehicle', $user) }}" class="mt-4 grid gap-3 sm:grid-cols-2 border-t border-gray-100 pt-4">
                @csrf
                <input type="text" name="plate" placeholder="{{ __('admin.plate') }}" required class="rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                <input type="text" name="vehicle_type" placeholder="{{ __('admin.vehicle_type') }}" required class="rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                @include('partials.form-date', [
                    'name' => 'itv_valid_until',
                    'label' => 'ITV',
                    'class' => 'w-full rounded-lg border border-gray-300 px-3 py-2 text-sm',
                ])
                <select name="status" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    <option value="valid">{{ __('portal.valid') }}</option>
                    <option value="pending">{{ __('portal.pending') }}</option>
                </select>
                <label class="flex items-center gap-2 text-sm sm:col-span-2"><input type="checkbox" name="is_motorcycle" value="1" /> {{ __('admin.motorcycle') }}</label>
                <div class="sm:col-span-2">
                    <button type="submit" class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white">{{ __('admin.add_vehicle') }}</button>
                </div>
            </form>
        </div>

        @include('admin.partials.user-documents', ['user' => $user])

        @include('admin.partials.client-taxes', ['user' => $user])

        <div class="rounded-xl border bg-white p-6 shadow-sm">
            <h2 class="text-lg font-bold text-gray-900">{{ __('admin.nav.applications') }}</h2>
            @forelse ($user->permitApplications as $app)
            <div class="mt-3 flex items-center justify-between rounded-lg border border-gray-100 p-4">
                <div>
                    <p class="font-mono text-sm font-bold">{{ $app->reference_code }}</p>
                    <p class="text-xs text-gray-500">{{ permit_status_label($app->status) }}</p>
                </div>
                <a href="{{ route('admin.applications.show', $app) }}" class="text-sm font-semibold text-[#004481]">{{ __('admin.table.view') }}</a>
            </div>
            @empty
            <p class="mt-3 text-sm text-gray-500">{{ __('admin.no_application') }}</p>
            @endforelse
        </div>
    </section>

    <aside class="space-y-6">
        <div class="rounded-xl border border-[#004481]/20 bg-sky-50 p-5 shadow-sm">
            <p class="text-xs font-semibold uppercase text-[#004481]">{{ __('admin.verification_code') }}</p>
            <code class="mt-2 block font-mono text-2xl font-bold text-gray-900">{{ $user->verification_code ?? '—' }}</code>
            <p class="mt-2 text-xs text-gray-600">{{ __('admin.verification_code_hint') }}</p>
        </div>

        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <h3 class="font-bold text-gray-900">{{ __('admin.change_password_title') }}</h3>
            <p class="mt-1 text-sm text-gray-500">{{ __('admin.change_password_hint') }}</p>
            <form method="post" action="{{ route('admin.users.update_password', $user) }}" class="mt-4 space-y-4">
                @csrf
                <div>
                    <label for="admin-password" class="text-xs font-semibold text-gray-500">{{ __('admin.new_password') }}</label>
                    <input id="admin-password" type="password" name="password" required minlength="8" autocomplete="new-password" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                    @error('password')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label for="admin-password-confirmation" class="text-xs font-semibold text-gray-500">{{ __('admin.new_password_confirmation') }}</label>
                    <input id="admin-password-confirmation" type="password" name="password_confirmation" required minlength="8" autocomplete="new-password" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
                </div>
                <button type="submit" class="w-full rounded-lg bg-[#004481] px-4 py-2 text-sm font-semibold text-white hover:bg-[#003366]">{{ __('admin.change_password_submit') }}</button>
            </form>
        </div>

        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <h3 class="font-bold text-gray-900">{{ __('admin.recent_notifications') }}</h3>
            <ul class="mt-3 space-y-2 text-sm">
                @forelse ($user->portalNotifications as $n)
                <li class="border-b border-gray-50 pb-2">
                    <p class="font-medium text-gray-800">{{ $n->display_title }}</p>
                    <p class="text-xs text-gray-500">{{ $n->notified_at->format('d/m/Y H:i') }}</p>
                </li>
                @empty
                <li class="text-gray-500">—</li>
                @endforelse
            </ul>
        </div>

        @if ($user->licensePointEvents->isNotEmpty())
        <div class="rounded-xl border bg-white p-5 shadow-sm">
            <h3 class="font-bold text-gray-900">{{ __('admin.points_history') }}</h3>
            <ul class="mt-3 space-y-2 text-xs">
                @foreach ($user->licensePointEvents as $e)
                <li>{{ $e->occurred_at->format('d/m/Y') }}: {{ $e->delta >= 0 ? '+' : '' }}{{ $e->delta }} → {{ $e->balance_after }} — {{ $e->reason }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </aside>
</div>
@endsection
