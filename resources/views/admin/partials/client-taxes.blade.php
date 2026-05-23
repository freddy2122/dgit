@php
    $presets = $presets ?? config('dgt_taxes.presets', []);
    $payments = $user->portalPayments->sortByDesc('due_date');
    $pendingPayments = $payments->filter(fn ($p) => $p->isPending());
    $paidTotal = $payments->where('status', 'paid')->sum('amount');
    $pendingTotal = $pendingPayments->sum('amount');
@endphp

<div class="rounded-xl border bg-white p-6 shadow-sm">
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-gray-900">{{ __('admin.client_taxes') }}</h2>
            <p class="mt-1 text-sm text-gray-500">{{ __('admin.client_taxes_hint') }}</p>
        </div>
        <div class="text-right text-sm">
            <p class="text-gray-500">{{ __('admin.tax_pending_total') }}</p>
            <p class="text-xl font-bold text-amber-800">{{ number_format((float) $pendingTotal, 2, ',', ' ') }} €</p>
            @if ($paidTotal > 0)
            <p class="mt-1 text-xs text-emerald-700">{{ __('admin.tax_paid_total', ['amount' => number_format((float) $paidTotal, 2, ',', ' ')]) }}</p>
            @endif
        </div>
    </div>

    @if ($payments->isNotEmpty())
    <div class="mt-4 overflow-x-auto rounded-lg border border-gray-100">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-4 py-2 text-left">{{ __('admin.tax_label') }}</th>
                    <th class="px-4 py-2 text-left">{{ __('admin.table.reference') }}</th>
                    <th class="px-4 py-2 text-right">{{ __('admin.tax_amount') }}</th>
                    <th class="px-4 py-2 text-left">{{ __('admin.tax_due') }}</th>
                    <th class="px-4 py-2 text-left">{{ __('admin.table.status') }}</th>
                    <th class="px-4 py-2 text-right">{{ __('admin.table.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($payments as $payment)
                <tr>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $payment->label }}</td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-600">{{ $payment->reference }}</td>
                    <td class="px-4 py-3 text-right font-bold">{{ number_format((float) $payment->amount, 2, ',', ' ') }} €</td>
                    <td class="px-4 py-3 text-gray-600">{{ $payment->due_date->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">
                        <span class="rounded-full px-2 py-0.5 text-xs font-semibold {{ $payment->isPaid() ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-900' }}">
                            {{ payment_status_label($payment->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex flex-wrap justify-end gap-2">
                            @if ($payment->isPending())
                            <form method="post" action="{{ route('admin.payments.confirm', $payment) }}">@csrf
                                <button type="submit" class="text-xs font-semibold text-emerald-700 hover:underline">{{ __('admin.confirm_whatsapp_payment') }}</button>
                            </form>
                            <form method="post" action="{{ route('admin.payments.destroy', $payment) }}" onsubmit="return confirm(@json(__('admin.tax_delete_confirm')))">@csrf @method('DELETE')
                                <button type="submit" class="text-xs text-red-700 hover:underline">{{ __('admin.delete') }}</button>
                            </form>
                            @else
                            <span class="text-xs text-gray-400">—</span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="mt-4 text-sm text-gray-500">{{ __('admin.no_taxes') }}</p>
    @endif

    <form method="post" action="{{ route('admin.users.store_tax', $user) }}" class="mt-6 border-t border-gray-100 pt-6">
        @csrf
        <input type="hidden" name="user_id" value="{{ $user->id }}" />
        <p class="text-sm font-semibold text-gray-800">{{ __('admin.assign_tax') }}</p>
        <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="sm:col-span-2">
                <label class="text-xs font-semibold text-gray-500">{{ __('admin.tax_preset') }}</label>
                <select name="tax_preset" id="admin-tax-preset" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                    <option value="">{{ __('admin.tax_preset_choose') }}</option>
                    @foreach ($presets as $key => $preset)
                    <option value="{{ $key }}" data-amount="{{ $preset['amount'] }}">{{ $preset['label'] }} ({{ number_format($preset['amount'], 2, ',', ' ') }} €)</option>
                    @endforeach
                    <option value="custom">{{ __('admin.tax_preset_custom') }}</option>
                </select>
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500">{{ __('admin.tax_due') }}</label>
                <input type="date" name="due_date" value="{{ now()->addDays(14)->format('Y-m-d') }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-500">{{ __('admin.tax_amount') }} ({{ __('admin.tax_amount_override') }})</label>
                <input type="number" name="amount" id="admin-tax-amount" step="0.01" min="0.01" placeholder="—" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
            </div>
            <div id="admin-tax-custom-label" class="hidden sm:col-span-2">
                <label class="text-xs font-semibold text-gray-500">{{ __('admin.tax_label') }}</label>
                <input type="text" name="label" maxlength="255" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="{{ __('admin.tax_custom_placeholder') }}" />
            </div>
        </div>
        <button type="submit" class="mt-4 rounded-lg bg-[#004481] px-5 py-2 text-sm font-semibold text-white hover:bg-[#003366]">{{ __('admin.assign_tax_btn') }}</button>
    </form>
</div>

@push('scripts')
<script>
(function () {
    const preset = document.getElementById('admin-tax-preset');
    const amount = document.getElementById('admin-tax-amount');
    const customLabel = document.getElementById('admin-tax-custom-label');
    if (!preset) return;
    function sync() {
        const opt = preset.options[preset.selectedIndex];
        const isCustom = preset.value === 'custom';
        customLabel?.classList.toggle('hidden', !isCustom);
        if (!isCustom && opt?.dataset?.amount && amount) {
            amount.placeholder = opt.dataset.amount + ' €';
        }
    }
    preset.addEventListener('change', sync);
    sync();
})();
</script>
@endpush
