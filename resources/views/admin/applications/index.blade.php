@extends('admin.layout')

@section('page_title', __('admin.nav.applications'))

@section('content')
    <p class="mb-4">
        <a href="{{ route('admin.applications.create') }}" class="inline-flex rounded-lg bg-[#003366] px-5 py-2.5 text-sm font-bold text-white hover:bg-[#002244]">
            + {{ __('admin.create_application') }}
        </a>
    </p>
    <form method="get" class="mb-4 flex flex-wrap gap-2">
        <input type="search" name="q" value="{{ request('q') }}" placeholder="NIE, référence…" class="rounded-lg border border-gray-300 px-3 py-2 text-sm" />
        <select name="status" class="rounded-lg border border-gray-300 px-3 py-2 text-sm">
            <option value="">{{ __('admin.table.status') }}</option>
            @foreach (['en_attente_paiement_whatsapp', 'en_tramitacion', 'permiso_provisional', 'en_fabricacion', 'expedido', 'valide', 'refuse'] as $st)
                <option value="{{ $st }}" @selected(request('status') === $st)>{{ permit_status_label($st) }}</option>
            @endforeach
        </select>
        <button type="submit" class="rounded-lg bg-[#003366] px-4 py-2 text-sm font-semibold text-white">OK</button>
    </form>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs uppercase text-gray-500">
                <tr>
                    <th class="px-5 py-3">{{ __('admin.table.name') }}</th>
                    <th class="px-5 py-3">{{ __('admin.table.nie') }}</th>
                    <th class="px-5 py-3">{{ __('admin.table.type') }}</th>
                    <th class="px-5 py-3">{{ __('admin.table.status') }}</th>
                    <th class="px-5 py-3">{{ __('admin.tramitacion_percent') }}</th>
                    <th class="px-5 py-3">{{ __('admin.table.date') }}</th>
                    <th class="px-5 py-3">{{ __('admin.table.actions') }}</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($applications as $app)
                    <tr>
                        <td class="px-5 py-3">{{ trim(collect([$app->user?->first_name, $app->user?->last_name])->filter()->join(' ')) ?: $app->user?->name }}</td>
                        <td class="px-5 py-3 font-mono">{{ $app->nie }}</td>
                        <td class="px-5 py-3">{{ $app->tramite_type }}</td>
                        <td class="px-5 py-3">{{ permit_status_label($app->status) }}</td>
                        <td class="px-5 py-3">
                            @include('admin.partials.tramitacion-percent-field', ['application' => $app])
                        </td>
                        <td class="px-5 py-3">{{ $app->submitted_at?->format('d/m/Y') ?? '—' }}</td>
                        <td class="px-5 py-3">
                            <a href="{{ route('admin.applications.show', $app) }}" class="font-semibold text-[#004481] hover:underline">{{ __('admin.table.view') }}</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="border-t border-gray-100 px-5 py-3">{{ $applications->links() }}</div>
    </div>
@endsection
