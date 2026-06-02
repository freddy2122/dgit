@extends('admin.layout')

@section('page_title', $application->reference_code)

@section('content')
    <div class="grid gap-6 lg:grid-cols-2">
        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="font-bold text-gray-900">{{ $typeLabel }}</h2>
            <dl class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between"><dt class="text-gray-500">Client</dt><dd>{{ $application->user?->name }} ({{ $application->nie }})</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">{{ __('admin.table.status') }}</dt><dd class="font-bold">{{ permit_status_label($application->status) }}</dd></div>
                <div class="flex justify-between"><dt class="text-gray-500">{{ __('tramite.reference') }}</dt><dd class="font-mono">{{ $application->reference_code }}</dd></div>
            </dl>

            @if (count($nextStatuses) > 0)
                <form method="post" action="{{ route('admin.applications.advance', $application) }}" class="mt-6 flex flex-wrap gap-2">
                    @csrf
                    <select name="status" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
                        @foreach ($nextStatuses as $st)
                            <option value="{{ $st }}">{{ permit_status_label($st) }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="rounded-lg bg-[#004481] px-4 py-2 text-sm font-bold text-white">{{ __('admin.advance_status') }}</button>
                </form>
            @endif

            <div class="mt-4 flex flex-wrap gap-2">
                <form method="post" action="{{ route('admin.applications.validate', $application) }}">@csrf
                    <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-bold text-white">{{ __('admin.table.validate') }}</button>
                </form>
                <form method="post" action="{{ route('admin.applications.reject', $application) }}" class="flex gap-2">@csrf
                    <input type="text" name="reason" placeholder="{{ __('admin.reject_placeholder') }}" class="rounded-lg border px-3 py-2 text-sm" />
                    <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-sm font-bold text-white">{{ __('admin.table.reject') }}</button>
                </form>
            </div>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="font-bold text-gray-900">{{ __('admin.tramitacion_block') }}</h2>
            <p class="mt-1 text-sm text-gray-600">{{ __('admin.tramitacion_block_hint', ['percent' => $clientTramitacionPercent]) }}</p>
            <form method="post" action="{{ route('admin.applications.update_tramitacion', $application) }}" class="mt-4 flex flex-wrap items-end gap-3">
                @csrf
                @method('PATCH')
                <div>
                    <label class="text-xs font-semibold text-gray-600">{{ __('admin.tramitacion_percent') }}</label>
                    <input
                        type="number"
                        name="tramitacion_percent"
                        min="0"
                        max="100"
                        value="{{ old('tramitacion_percent', $application->tramitacion_percent) }}"
                        placeholder="{{ $suggestedTramitacionPercent }}"
                        class="mt-1 w-24 rounded-lg border border-gray-300 px-3 py-2 text-sm"
                    />
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-600">{{ __('admin.requested_category') }}</label>
                    <select name="requested_category" class="mt-1 rounded-lg border border-gray-300 px-3 py-2 text-sm font-mono">
                        <option value="">—</option>
                        @foreach ($categoryCodes as $code)
                            <option value="{{ $code }}" @selected(strtoupper((string) old('requested_category', $application->requested_category)) === $code)>{{ $code }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="rounded-lg bg-[#004481] px-4 py-2 text-sm font-bold text-white">{{ __('admin.save_tramitacion') }}</button>
            </form>
            <form method="post" action="{{ route('admin.applications.update_tramitacion', $application) }}" class="mt-2">
                @csrf
                @method('PATCH')
                <button type="submit" class="text-sm font-semibold text-[#004481] hover:underline">{{ __('admin.tramitacion_auto') }}</button>
            </form>
            <p class="mt-2 text-xs text-gray-500">{{ __('admin.tramitacion_auto_hint', ['percent' => $suggestedTramitacionPercent]) }}</p>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="font-bold text-gray-900">{{ __('admin.exam_block') }}</h2>
            <form method="post" action="{{ route('admin.applications.update_exam', $application) }}" class="mt-4 space-y-4">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label class="text-xs font-semibold text-gray-600">{{ __('admin.exam_score') }}</label>
                        <input type="number" name="exam_score" min="0" max="100" value="{{ old('exam_score', $application->exam_score) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="—" />
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600">{{ __('admin.exam_errors') }}</label>
                        <input type="number" name="exam_errors" min="0" max="30" value="{{ old('exam_errors', $application->exam_errors) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="3" />
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-gray-600">{{ __('admin.tramitacion_percent') }}</label>
                        <input type="number" name="tramitacion_percent" min="0" max="100" value="{{ old('tramitacion_percent', $application->tramitacion_percent) }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="{{ $suggestedTramitacionPercent }}" />
                    </div>
                </div>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="score_improvement_paid" value="1" @checked(old('score_improvement_paid', $application->score_improvement_paid)) class="rounded border-gray-300" />
                    {{ __('admin.exam_score_validated') }}
                </label>
                <p class="text-xs text-gray-500">{{ __('admin.exam_block_hint') }}</p>
                <button type="submit" class="rounded-lg bg-[#004481] px-4 py-2 text-sm font-bold text-white">{{ __('admin.save_exam') }}</button>
            </form>
        </section>

        <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <h2 class="font-bold text-gray-900">{{ __('tramite.payments_block') }}</h2>
            <ul class="mt-4 space-y-3">
                @foreach ($application->payments as $payment)
                    <li class="flex flex-wrap items-center justify-between gap-2 rounded-lg border border-gray-100 p-3 text-sm">
                        <div>
                            <p class="font-semibold">{{ $payment->label }}</p>
                            <p>{{ $payment->reference }} — {{ number_format($payment->amount, 2) }} € — <span class="font-medium">{{ $payment->status }}</span></p>
                        </div>
                        @if (in_array($payment->status, ['awaiting_whatsapp', 'pending'], true))
                            <form method="post" action="{{ route('admin.applications.confirm_payment', [$application, $payment]) }}">@csrf
                                <button type="submit" class="rounded-lg bg-[#25D366] px-3 py-1.5 text-xs font-bold text-white">{{ __('admin.confirm_whatsapp_payment') }}</button>
                            </form>
                        @endif
                    </li>
                @endforeach
            </ul>
        </section>
    </div>

    <section class="mt-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <h2 class="font-bold text-gray-900">{{ __('admin.documents') }}</h2>
        <ul class="mt-3 space-y-2 text-sm">
            <li>{{ __('admin.dni_recto') }}: {{ $application->user->dni_recto_path ? '✓' : '—' }}</li>
            <li>{{ __('tramite.medical_block') }}: {{ $application->medical_certificate_path ? '✓' : '—' }}</li>
        </ul>
    </section>
@endsection
