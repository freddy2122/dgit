@php
    $docService = app(\App\Services\UserDocumentService::class);
    $docStatus = $docService->status($user);
    $hasCardPhoto = $docService->hasCardPhoto($user);
    $redirectTo = $redirectTo ?? null;
    $photoMin = [
        'min_width' => config('license_photo.min_width'),
        'min_height' => config('license_photo.min_height'),
        'width_mm' => config('license_photo.width_mm'),
        'height_mm' => config('license_photo.height_mm'),
    ];
@endphp

<section class="rounded-xl border border-sky-100 bg-gradient-to-br from-sky-50/80 to-white p-5 shadow-sm">
    <h2 class="text-sm font-bold text-gray-900">{{ __('portal.license.photo_section_title') }}</h2>
    <p class="mt-1 text-sm text-gray-600">{{ __('portal.license.photo_section_hint', $photoMin) }}</p>
    <ul class="mt-2 list-inside list-disc space-y-0.5 text-xs text-gray-600">
        <li>{{ __('portal.license.photo_req_background') }}</li>
        <li>{{ __('portal.license.photo_req_face') }}</li>
        <li>{{ __('portal.license.photo_req_expression') }}</li>
    </ul>

    <div class="mt-4 flex flex-wrap items-start gap-5">
        <div class="h-[10rem] w-[8.125rem] shrink-0 overflow-hidden rounded-md border border-slate-300 bg-slate-200 shadow-md">
            @include('portal.partials.license-photo', ['user' => $user, 'photoClass' => 'h-full w-full min-h-full min-w-full object-cover object-top grayscale'])
        </div>
        <div class="min-w-0 flex-1">
            @if ($docStatus['license_photo'])
                <p class="text-xs font-semibold text-emerald-700">✓ {{ __('portal.license.photo_on_file') }}</p>
            @elseif ($hasCardPhoto)
                <p class="text-xs text-gray-600">{{ __('portal.license.photo_fallback_recto') }}</p>
            @else
                <p class="text-xs text-amber-700">{{ __('portal.license.photo_missing') }}</p>
            @endif

            <form method="post" action="{{ portal_route('portal.profile.documents') }}" enctype="multipart/form-data" class="mt-4">
                @csrf
                @if ($redirectTo)
                    <input type="hidden" name="redirect_to" value="{{ $redirectTo }}" />
                @endif
                <label class="block">
                    <span class="text-xs font-medium text-gray-700">{{ __('portal.license.photo_upload_label') }}</span>
                    <input
                        type="file"
                        name="license_photo"
                        accept=".jpg,.jpeg,.png,.webp"
                        class="mt-1 w-full max-w-md text-xs text-gray-600"
                    />
                </label>
                <p class="mt-1 text-xs text-gray-500">{{ __('portal.license.photo_upload_formats', $photoMin) }}</p>
                @error('license_photo')
                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <button type="submit" class="mt-3 rounded-lg bg-[#004481] px-4 py-2 text-sm font-semibold text-white hover:bg-[#003366]">
                    {{ __('portal.license.photo_save_btn') }}
                </button>
            </form>
            <a href="{{ portal_route('portal.profile') }}" class="mt-2 inline-block text-xs font-semibold text-[#004481] hover:underline">
                {{ __('portal.license.photo_all_documents') }} →
            </a>
        </div>
    </div>
</section>
