@extends('admin.layout')
@section('page_title', __('admin.nav.appointments'))
@section('content')
<div class="overflow-hidden rounded-xl border bg-white shadow-sm">
<table class="min-w-full text-sm">
<thead class="bg-slate-50 text-xs uppercase text-gray-500"><tr>
<th class="px-5 py-3">{{ __('admin.table.name') }}</th>
<th class="px-5 py-3">Bureau</th>
<th class="px-5 py-3">Date</th>
</tr></thead>
<tbody class="divide-y">
@foreach ($appointments as $a)
<tr>
<td class="px-5 py-3">{{ $a->user?->name }}</td>
<td class="px-5 py-3">{{ $a->office }}</td>
<td class="px-5 py-3">{{ $a->appointment_date?->format('d/m/Y') }} {{ $a->appointment_time }}</td>
</tr>
@endforeach
</tbody></table>
<div class="px-5 py-3">{{ $appointments->links() }}</div>
</div>
@endsection
