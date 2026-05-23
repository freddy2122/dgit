@extends('admin.layout')
@section('page_title', __('admin.nav.vehicles'))
@section('content')
<div class="overflow-hidden rounded-xl border bg-white shadow-sm">
<table class="min-w-full text-sm">
<thead class="bg-slate-50 text-xs uppercase text-gray-500"><tr>
<th class="px-5 py-3">Plaque</th>
<th class="px-5 py-3">{{ __('admin.table.name') }}</th>
<th class="px-5 py-3">ITV</th>
</tr></thead>
<tbody class="divide-y">
@foreach ($vehicles as $v)
<tr>
<td class="px-5 py-3 font-mono font-bold">{{ $v->plate }}</td>
<td class="px-5 py-3">{{ $v->user?->name }}</td>
<td class="px-5 py-3">{{ $v->itv_valid_until?->format('d/m/Y') }}</td>
</tr>
@endforeach
</tbody></table>
<div class="px-5 py-3">{{ $vehicles->links() }}</div>
</div>
@endsection
