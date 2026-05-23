@php $portalNavActive = 'fines'; @endphp
@extends('layouts.portal')

@section('title', __('site.multas.title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('site.multas.title') }}</h1>
    <p class="text-sm text-gray-500">{{ __('site.multas.subtitle') }}</p>
@endsection

@section('content')
    @if ($pending->isEmpty())
        <p class="rounded-xl border border-gray-200 bg-white p-8 text-center text-sm text-gray-600 shadow-sm">{{ __('site.multas.empty') }}</p>
    @else
        <form method="post" action="{{ route('multas.pay') }}">
            @csrf
            <ul class="divide-y divide-gray-100 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                @foreach ($fines as $fine)
                    <li class="flex flex-wrap items-center gap-4 px-5 py-4">
                        @if ($fine['status'] === 'pending')
                            <input type="checkbox" name="fine_ids[]" value="{{ $fine['id'] }}" checked class="h-4 w-4 rounded text-[#004481]">
                        @endif
                        <div class="min-w-0 flex-1">
                            <p class="font-medium text-gray-900">{{ $fine['label'] }}</p>
                            <p class="text-xs text-gray-500">{{ __('site.multas.reference') }}: {{ $fine['reference'] }}</p>
                        </div>
                        <p class="font-bold">{{ number_format($fine['amount'], 2, ',', '') }} €</p>
                        <span class="rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $fine['status'] === 'paid' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-900' }}">
                            {{ $fine['status'] === 'paid' ? __('site.multas.status_paid') : __('site.multas.status_pending') }}
                        </span>
                    </li>
                @endforeach
            </ul>
            @if ($pending->isNotEmpty())
                <button type="submit" class="mt-4 rounded-lg bg-[#004481] px-6 py-3 text-sm font-semibold text-white hover:bg-[#003366]">
                    {{ __('site.multas.pay') }}
                </button>
            @endif
        </form>
    @endif

    <a href="{{ route('multas.appeal') }}" class="mt-6 inline-flex text-sm font-semibold text-[#004481] hover:underline">
        {{ __('site.multas.appeal') }} →
    </a>
@endsection
