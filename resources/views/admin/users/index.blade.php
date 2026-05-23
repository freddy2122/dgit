@extends('admin.layout')
@section('page_title', __('admin.nav.users'))
@section('content')
<div class="mb-4 flex justify-end">
    <a href="{{ route('admin.users.create') }}" class="rounded-lg bg-[#004481] px-4 py-2 text-sm font-semibold text-white hover:bg-[#003366]">{{ __('admin.create_user') }}</a>
</div>
<div class="overflow-hidden rounded-xl border bg-white shadow-sm">
<table class="min-w-full text-sm">
<thead class="bg-slate-50 text-xs uppercase text-gray-500"><tr>
<th class="px-5 py-3">{{ __('admin.table.name') }}</th>
<th class="px-5 py-3">{{ __('admin.table.email') }}</th>
<th class="px-5 py-3">{{ __('admin.table.nie') }}</th>
<th class="px-5 py-3">{{ __('admin.verification_code') }}</th>
<th class="px-5 py-3">Pts</th>
<th class="px-5 py-3">{{ __('admin.table.actions') }}</th>
</tr></thead>
<tbody class="divide-y">
@foreach ($users as $u)
<tr>
<td class="px-5 py-3">{{ $u->name }}</td>
<td class="px-5 py-3">{{ $u->email }}</td>
<td class="px-5 py-3 font-mono">{{ $u->nie }}</td>
<td class="px-5 py-3 font-mono text-xs">{{ $u->verification_code ?? '—' }}</td>
<td class="px-5 py-3">{{ $u->licenseSummary?->points ?? 0 }}</td>
<td class="px-5 py-3 space-x-3">
    <a href="{{ route('admin.users.show', $u) }}" class="font-semibold text-[#004481]">{{ __('admin.table.view') }}</a>
    <a href="{{ route('admin.payments.index', ['user' => $u->id]) }}" class="text-gray-600 hover:text-[#004481]">{{ __('admin.nav.payments') }}</a>
</td>
</tr>
@endforeach
</tbody></table>
<div class="px-5 py-3">{{ $users->links() }}</div>
</div>
@endsection
