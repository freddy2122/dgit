@extends('admin.layout')
@section('page_title', __('admin.create_user'))
@section('content')
<form method="post" action="{{ route('admin.users.store') }}" class="max-w-xl space-y-4 rounded-xl border bg-white p-6 shadow-sm">
    @csrf
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="text-xs font-semibold text-gray-500">{{ __('admin.first_name') }}</label>
            <input type="text" name="first_name" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
        </div>
        <div>
            <label class="text-xs font-semibold text-gray-500">{{ __('admin.last_name') }}</label>
            <input type="text" name="last_name" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
        </div>
    </div>
    <div>
        <label class="text-xs font-semibold text-gray-500">{{ __('admin.table.email') }}</label>
        <input type="email" name="email" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label class="text-xs font-semibold text-gray-500">{{ __('admin.table.nie') }}</label>
            <input type="text" name="nie" required class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 font-mono text-sm" />
        </div>
        <div>
            @include('partials.form-date', [
                'name' => 'birth_date',
                'required' => true,
                'label' => __('admin.birth_date'),
                'class' => 'mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm',
            ])
        </div>
    </div>
    <div>
        <label class="text-xs font-semibold text-gray-500">{{ __('admin.phone') }}</label>
        <input type="text" name="phone" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" />
    </div>
    <div>
        <label class="text-xs font-semibold text-gray-500">{{ __('admin.temp_password') }}</label>
        <input type="password" name="password" class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm" placeholder="changeme123" />
    </div>
    <p class="text-xs text-gray-500">{{ __('admin.create_user_hint') }}</p>
    <button type="submit" class="rounded-lg bg-[#004481] px-6 py-2.5 text-sm font-semibold text-white">{{ __('admin.create_user_btn') }}</button>
</form>
@endsection
