@extends('admin.layout')
@section('page_title', __('admin.nav.payments'))
@section('content')

<div class="mb-6 rounded-xl border bg-white p-6 shadow-sm">
    <h2 class="text-lg font-bold text-gray-900">{{ __('admin.assign_tax') }}</h2>
    <p class="mt-1 text-sm text-gray-500">{{ __('admin.payments_page_hint') }}</p>
    <form method="post" action="{{ route('admin.payments.store') }}" class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
        @csrf
        <input type="hidden" name="redirect" value="payments" />
        <div class="lg:col-span-2">
            <label class="text-xs font-semibold text-gray-500">{{ __('admin.table.name') }}</label>
            <select name="user_id" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                <option value="">{{ __('admin.tax_client_choose') }}</option>
                @foreach ($clients as $c)
                <option value="{{ $c->id }}" @selected(($filterUser?->id ?? null) == $c->id)>{{ $c->name }} — {{ $c->nie ?? $c->email }}</option>
                @endforeach
            </select>
        </div>
        <div class="lg:col-span-2">
            <label class="text-xs font-semibold text-gray-500">{{ __('admin.tax_preset') }}</label>
            <select name="tax_preset" id="payments-tax-preset" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                <option value="">{{ __('admin.tax_preset_choose') }}</option>
                @foreach ($presets as $key => $preset)
                <option value="{{ $key }}">{{ $preset['label'] }} ({{ number_format($preset['amount'], 2, ',', ' ') }} €)</option>
                @endforeach
                <option value="custom">{{ __('admin.tax_preset_custom') }}</option>
            </select>
        </div>
        <div>
            <label class="text-xs font-semibold text-gray-500">{{ __('admin.tax_due') }}</label>
            <input type="date" name="due_date" value="{{ now()->addDays(14)->format('Y-m-d') }}" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
        </div>
        <div>
            <label class="text-xs font-semibold text-gray-500">{{ __('admin.tax_amount') }}</label>
            <input type="number" name="amount" step="0.01" min="0.01" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
        </div>
        <div id="payments-tax-custom-label" class="hidden lg:col-span-2">
            <label class="text-xs font-semibold text-gray-500">{{ __('admin.tax_label') }}</label>
            <input type="text" name="label" maxlength="255" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
        </div>
        <div class="flex items-end lg:col-span-1">
            <button type="submit" class="w-full rounded-lg bg-[#004481] px-4 py-2 text-sm font-semibold text-white hover:bg-[#003366]">{{ __('admin.assign_tax_btn') }}</button>
        </div>
    </form>
</div>

<div class="mb-4 flex flex-wrap gap-2 text-sm">
    <a href="{{ route('admin.payments.index') }}" class="rounded-lg px-3 py-1.5 {{ ! request('status') ? 'bg-[#004481] text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }}">{{ __('admin.tax_filter_all') }}</a>
    <a href="{{ route('admin.payments.index', ['status' => 'awaiting_whatsapp']) }}" class="rounded-lg px-3 py-1.5 {{ request('status') === 'awaiting_whatsapp' ? 'bg-[#004481] text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }}">{{ __('admin.tax_filter_pending') }}</a>
    <a href="{{ route('admin.payments.index', ['status' => 'paid']) }}" class="rounded-lg px-3 py-1.5 {{ request('status') === 'paid' ? 'bg-[#004481] text-white' : 'border border-gray-300 text-gray-700 hover:bg-gray-50' }}">{{ __('admin.tax_filter_paid') }}</a>
</div>

@if ($filterUser)
<p class="mb-4 text-sm text-gray-600">
    {{ __('admin.tax_filtered_client') }}:
    <a href="{{ route('admin.users.show', $filterUser) }}" class="font-semibold text-[#004481] hover:underline">{{ $filterUser->name }}</a>
    <a href="{{ route('admin.payments.index') }}" class="ml-2 text-gray-500 hover:underline">{{ __('admin.tax_clear_filter') }}</a>
</p>
@endif

<div class="overflow-hidden rounded-xl border bg-white shadow-sm">
<table class="min-w-full text-sm">
<thead class="bg-slate-50 text-xs uppercase text-gray-500"><tr>
<th class="px-5 py-3">{{ __('admin.table.name') }}</th>
<th class="px-5 py-3">{{ __('admin.tax_label') }}</th>
<th class="px-5 py-3">{{ __('admin.table.reference') }}</th>
<th class="px-5 py-3">{{ __('admin.tax_amount') }}</th>
<th class="px-5 py-3">{{ __('admin.tax_due') }}</th>
<th class="px-5 py-3">{{ __('admin.table.status') }}</th>
<th class="px-5 py-3 text-right">{{ __('admin.table.actions') }}</th>
</tr></thead>
<tbody class="divide-y">
@forelse ($payments as $p)
<tr>
<td class="px-5 py-3">
    <a href="{{ route('admin.users.show', $p->user_id) }}" class="font-medium text-[#004481] hover:underline">{{ $p->user?->name }}</a>
    <p class="font-mono text-xs text-gray-500">{{ $p->user?->nie }}</p>
</td>
<td class="px-5 py-3">{{ $p->label }}</td>
<td class="px-5 py-3 font-mono text-xs">{{ $p->reference }}</td>
<td class="px-5 py-3 font-bold">{{ number_format((float) $p->amount, 2, ',', ' ') }} €</td>
<td class="px-5 py-3">{{ $p->due_date->format('d/m/Y') }}</td>
<td class="px-5 py-3">{{ payment_status_label($p->status) }}</td>
<td class="px-5 py-3 text-right">
    @if ($p->isPending())
    <form class="inline" method="post" action="{{ route('admin.payments.confirm', $p) }}">@csrf
        <button type="submit" class="text-xs font-semibold text-emerald-700 hover:underline">{{ __('admin.confirm_whatsapp_payment') }}</button>
    </form>
    <form class="inline ml-2" method="post" action="{{ route('admin.payments.destroy', $p) }}" onsubmit="return confirm(@json(__('admin.tax_delete_confirm')))">@csrf @method('DELETE')
        <button type="submit" class="text-xs text-red-700 hover:underline">{{ __('admin.delete') }}</button>
    </form>
    @endif
</td>
</tr>
@empty
<tr><td colspan="7" class="px-5 py-8 text-center text-gray-500">{{ __('admin.no_taxes') }}</td></tr>
@endforelse
</tbody></table>
<div class="px-5 py-3">{{ $payments->links() }}</div>
</div>

@push('scripts')
<script>
(function () {
    const preset = document.getElementById('payments-tax-preset');
    const custom = document.getElementById('payments-tax-custom-label');
    if (!preset || !custom) return;
    preset.addEventListener('change', () => custom.classList.toggle('hidden', preset.value !== 'custom'));
})();
</script>
@endpush
@endsection
