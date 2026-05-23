@extends('admin.layout')
@section('page_title', __('admin.nav.documents'))
@section('content')
<div class="overflow-hidden rounded-xl border bg-white shadow-sm">
<table class="min-w-full text-sm">
<thead class="bg-slate-50 text-xs uppercase text-gray-500"><tr>
<th class="px-5 py-3">{{ __('admin.table.name') }}</th>
<th class="px-5 py-3">{{ __('admin.license_photo') }}</th>
<th class="px-5 py-3">{{ __('admin.dni_recto') }}</th>
<th class="px-5 py-3">{{ __('admin.dni_verso') }}</th>
<th class="px-5 py-3">{{ __('admin.signature') }}</th>
<th class="px-5 py-3">{{ __('admin.table.date') }}</th>
<th class="px-5 py-3">{{ __('admin.table.actions') }}</th>
</tr></thead>
<tbody class="divide-y">
@forelse ($users as $u)
@php($st = app(\App\Services\UserDocumentService::class)->status($u))
<tr>
<td class="px-5 py-3 font-medium">{{ $u->name }}</td>
<td class="px-5 py-3">{{ $st['license_photo'] ? '✓' : '—' }}</td>
<td class="px-5 py-3">{{ $st['recto'] ? '✓' : '—' }}</td>
<td class="px-5 py-3">{{ $st['verso'] ? '✓' : '—' }}</td>
<td class="px-5 py-3">{{ $st['signature'] ? '✓' : '—' }}</td>
<td class="px-5 py-3">{{ $u->updated_at?->format('d/m/Y') }}</td>
<td class="px-5 py-3">
<a href="{{ route('admin.users.show', $u) }}" class="font-semibold text-[#004481] hover:underline">{{ __('admin.manage_client') }}</a>
</td>
</tr>
@empty
<tr><td colspan="7" class="px-5 py-8 text-center text-gray-500">{{ __('admin.no_documents_list') }}</td></tr>
@endforelse
</tbody></table>
<div class="px-5 py-3">{{ $users->links() }}</div>
</div>
@endsection
