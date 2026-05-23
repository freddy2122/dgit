@php $portalNavActive = 'notifications'; @endphp
@extends('layouts.portal')

@section('title', __('portal.notifications_page.title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('portal.notifications_page.title') }}</h1>
    <p class="text-sm text-gray-500">{{ __('portal.notifications_page.subtitle') }}</p>
@endsection

@section('content')
    <section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        @if ($notifications->isEmpty())
            <p class="p-8 text-center text-sm text-gray-600">{{ __('portal.notifications_page.empty') }}</p>
        @else
            <ul class="divide-y divide-gray-100">
                @foreach ($notifications as $notification)
                    <li class="px-5 py-4 {{ $notification->is_read ? 'bg-white' : 'bg-sky-50/50' }}">
                        <div class="flex flex-wrap items-start justify-between gap-3">
                            <div class="min-w-0 flex-1">
                                <p class="font-semibold text-gray-900">{{ $notification->display_title }}</p>
                                @if ($notification->display_body)
                                    <p class="mt-1 text-sm text-gray-600">{{ $notification->display_body }}</p>
                                @endif
                                <p class="mt-2 text-xs text-gray-500">{{ $notification->notified_at->format('d/m/Y H:i') }}</p>
                            </div>
                            <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $notification->is_read ? 'bg-gray-100 text-gray-600' : 'bg-[#004481] text-white' }}">
                                {{ $notification->is_read ? __('portal.read') : __('portal.unread') }}
                            </span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </section>
@endsection
