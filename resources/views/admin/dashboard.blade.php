@extends('admin.layout')

@section('page_title', __('admin.nav.dashboard'))

@section('content')
    <section class="mb-6 flex flex-wrap gap-3">
        <a href="{{ route('admin.users.create') }}" class="rounded-lg bg-[#004481] px-4 py-2 text-sm font-semibold text-white">{{ __('admin.create_user') }}</a>
        <a href="{{ route('admin.applications.create') }}" class="rounded-lg border border-[#004481] px-4 py-2 text-sm font-semibold text-[#004481]">{{ __('admin.create_application') }}</a>
        <a href="{{ route('admin.permits.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-800">{{ __('admin.nav.permits') }}</a>
    </section>
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ([
            ['label' => __('admin.stats.applications_today'), 'value' => $stats['applications_today']],
            ['label' => __('admin.stats.permits_validated'), 'value' => $stats['permits_validated']],
            ['label' => __('admin.stats.payments_received'), 'value' => $stats['payments_received']],
            ['label' => __('admin.stats.pending_files'), 'value' => $stats['pending_files']],
        ] as $stat)
            <div class="rounded-xl border border-gray-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-gray-500">{{ $stat['label'] }}</p>
                <p class="mt-2 text-3xl font-bold text-[#003366]">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <section class="mt-8 rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="border-b border-gray-100 px-5 py-4">
            <h2 class="font-bold text-gray-900">{{ __('admin.recent_applications') }}</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-left text-xs uppercase text-gray-500">
                    <tr>
                        <th class="px-5 py-3">{{ __('admin.table.name') }}</th>
                        <th class="px-5 py-3">{{ __('admin.table.nie') }}</th>
                        <th class="px-5 py-3">{{ __('admin.table.status') }}</th>
                        <th class="px-5 py-3">{{ __('admin.table.date') }}</th>
                        <th class="px-5 py-3">{{ __('admin.table.actions') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($recentApplications as $app)
                        <tr>
                            <td class="px-5 py-3 font-medium">{{ $app->user?->name ?? '—' }}</td>
                            <td class="px-5 py-3 font-mono">{{ $app->nie }}</td>
                            <td class="px-5 py-3">{{ permit_status_label($app->status) }}</td>
                            <td class="px-5 py-3">{{ $app->updated_at?->format('d/m/Y') }}</td>
                            <td class="px-5 py-3">
                                <a href="{{ route('admin.applications.show', $app) }}" class="font-semibold text-[#004481] hover:underline">{{ __('admin.table.view') }}</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-5 py-8 text-center text-gray-500">—</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
