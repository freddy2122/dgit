@extends('admin.layout')

@section('page_title', __('admin.create_application'))

@section('content')
    <form method="post" action="{{ route('admin.applications.store') }}" enctype="multipart/form-data" class="max-w-xl space-y-6 rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('admin.table.name') }} / client</label>
            <select name="user_id" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                <option value="">—</option>
                @foreach ($users as $u)
                    <option value="{{ $u->id }}" @selected(old('user_id', $selectedUserId ?? null) == $u->id)>{{ $u->name }} — {{ $u->nie }} ({{ $u->email }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('admin.table.type') }}</label>
            <select name="tramite_type" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm">
                @foreach ($types as $key => $cfg)
                    <option value="{{ $key }}" @selected(old('tramite_type') === $key)>{{ $cfg['label_fr'] ?? $key }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('admin.requested_category') }}</label>
            <p class="text-xs text-gray-500">{{ __('admin.requested_category_hint') }}</p>
            <select name="requested_category" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm font-mono">
                <option value="">—</option>
                @foreach ($categoryCodes as $code)
                    <option value="{{ $code }}" @selected(old('requested_category') === $code)>{{ $code }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">{{ __('tramite.medical_block') }}</label>
            <p class="text-xs text-gray-500">{{ __('admin.medical_upload_hint') }}</p>
            <input type="file" name="medical_certificate" accept=".jpg,.jpeg,.png,.pdf" class="mt-2 w-full text-sm" />
        </div>
        <p class="text-xs text-gray-500">{{ __('admin.create_application_hint') }}</p>
        <button type="submit" class="rounded-lg bg-[#003366] px-6 py-2.5 text-sm font-bold text-white hover:bg-[#002244]">
            {{ __('admin.create_application_btn') }}
        </button>
    </form>
@endsection
