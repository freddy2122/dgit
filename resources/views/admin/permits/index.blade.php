@extends('admin.layout')
@section('page_title', __('admin.nav.permits'))
@section('content')
<div class="overflow-hidden rounded-xl border bg-white shadow-sm">
<table class="min-w-full text-sm">
<thead class="bg-slate-50 text-xs uppercase text-gray-500"><tr>
<th class="px-5 py-3">{{ __('admin.table.name') }}</th>
<th class="px-5 py-3">Cat.</th>
<th class="px-5 py-3">Validité</th>
<th class="px-5 py-3">Points</th>
<th class="px-5 py-3">{{ __('admin.table.status') }}</th>
<th class="px-5 py-3">{{ __('admin.table.actions') }}</th>
</tr></thead>
<tbody class="divide-y">
@foreach ($licenses as $lic)
<tr>
<td class="px-5 py-3">{{ $lic->user?->name }}</td>
<td class="px-5 py-3">{{ $lic->category ?? '—' }}</td>
<td class="px-5 py-3">{{ $lic->valid_until?->format('d/m/Y') ?? '—' }}</td>
<td class="px-5 py-3">{{ $lic->points }}</td>
<td class="px-5 py-3 text-xs">{{ permit_status_label($lic->application_status) }}</td>
<td class="px-5 py-3">
    @if ($lic->user)
    <a href="{{ route('admin.users.show', $lic->user) }}" class="font-semibold text-[#004481]">{{ __('admin.manage_client') }}</a>
    @endif
</td>
</tr>
@endforeach
</tbody></table>
<div class="px-5 py-3">{{ $licenses->links() }}</div>
</div>
@endsection
