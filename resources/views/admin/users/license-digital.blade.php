@extends('admin.layout')

@section('page_title', __('admin.view_license_digital'))

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.users.show', $user) }}" class="text-sm font-semibold text-[#004481] hover:underline">← {{ $user->name }}</a>
        <h1 class="mt-2 text-xl font-bold text-gray-900">{{ __('admin.view_license_digital') }}</h1>
        <p class="text-sm text-gray-500">{{ $user->email }} · <span class="font-mono">{{ $user->nie }}</span></p>
    </div>

    <section class="mx-auto max-w-2xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        @include('admin.partials.license-card-preview', ['user' => $user, 'license' => $license])
        <p class="mt-6 text-center text-xs text-gray-500">{{ __('portal.license.demo_note') }}</p>
    </section>
@endsection
