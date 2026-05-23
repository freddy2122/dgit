@extends('admin.layout')
@section('page_title', __('admin.nav.logs'))
@section('content')
<div class="overflow-hidden rounded-xl border bg-white shadow-sm">
<table class="min-w-full text-sm">
<thead class="bg-slate-50 text-xs uppercase text-gray-500"><tr>
<th class="px-5 py-3">Agent</th>
<th class="px-5 py-3">Action</th>
<th class="px-5 py-3">{{ __('admin.table.date') }}</th>
</tr></thead>
<tbody class="divide-y">
@foreach ($logs as $log)
<tr>
<td class="px-5 py-3">{{ $log->admin?->email }}</td>
<td class="px-5 py-3 font-mono text-xs">{{ $log->action }}</td>
<td class="px-5 py-3">{{ $log->created_at->format('d/m/Y H:i') }}</td>
</tr>
@endforeach
</tbody></table>
<div class="px-5 py-3">{{ $logs->links() }}</div>
</div>
@endsection
