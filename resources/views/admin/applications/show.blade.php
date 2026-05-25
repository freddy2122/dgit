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
