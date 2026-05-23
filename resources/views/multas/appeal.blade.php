@php $portalNavActive = 'fines'; @endphp
@extends('layouts.portal')

@section('title', __('site.multas.appeal_title'))

@section('page_heading')
    <h1 class="text-lg font-bold text-gray-900">{{ __('site.multas.appeal_title') }}</h1>
    <p class="text-sm text-gray-500">{{ __('site.multas.appeal_subtitle') }}</p>
@endsection

@section('content')
    <p class="mb-6 text-sm text-gray-600">{{ __('site.multas.appeal_intro') }}</p>

    <form method="post" action="{{ route('multas.appeal.store') }}" class="max-w-xl rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="reference" class="block text-sm font-medium text-gray-700">{{ __('site.multas.appeal_reference') }}</label>
                <input type="text" name="reference" id="reference" value="{{ old('reference') }}" required
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]" />
                @error('reference')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="reason" class="block text-sm font-medium text-gray-700">{{ __('site.multas.appeal_reason') }}</label>
                <textarea name="reason" id="reason" rows="5" required
                    class="mt-1 w-full rounded-lg border border-gray-300 px-3 py-2 text-sm focus:border-[#004481] focus:outline-none focus:ring-1 focus:ring-[#004481]">{{ old('reason') }}</textarea>
                @error('reason')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
        <div class="mt-6 flex flex-wrap gap-3">
            <button type="submit" class="rounded-lg bg-[#004481] px-6 py-3 text-sm font-semibold text-white hover:bg-[#003366]">
                {{ __('site.multas.appeal_submit') }}
            </button>
            <a href="{{ route('multas.index') }}" class="rounded-lg border border-gray-300 px-6 py-3 text-sm font-semibold text-gray-700 hover:bg-gray-50">
                {{ __('portal.cancel') }}
            </a>
        </div>
    </form>
@endsection
