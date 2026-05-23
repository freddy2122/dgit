@php
    $docService = app(\App\Services\UserDocumentService::class);
    $docStatus = $docService->status($user);
@endphp

<section class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
    <div class="border-b border-gray-100 bg-slate-50/80 px-5 py-4">
        <h2 class="font-bold text-gray-900">{{ __('portal.profile.documents_title') }}</h2>
        <p class="mt-1 text-sm text-gray-600">{{ __('portal.profile.documents_subtitle') }}</p>
    </div>

    <div class="grid gap-6 p-5 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            ['type' => 'license_photo', 'label' => __('portal.license.photo_upload_label'), 'field' => 'license_photo', 'accept' => '.jpg,.jpeg,.png,.webp'],
            ['type' => 'recto', 'label' => __('site.registration.dni_recto'), 'field' => 'dni_recto', 'accept' => '.jpg,.jpeg,.png,.pdf'],
            ['type' => 'verso', 'label' => __('site.registration.dni_verso'), 'field' => 'dni_verso', 'accept' => '.jpg,.jpeg,.png,.pdf'],
            ['type' => 'signature', 'label' => __('site.registration.signature'), 'field' => 'signature', 'accept' => '.jpg,.jpeg,.png'],
        ] as $doc)
            <div class="rounded-lg border border-gray-100 bg-slate-50/50 p-4">
                <p class="text-sm font-semibold text-gray-800">{{ $doc['label'] }}</p>
                @if ($docStatus[$doc['type']])
                    <div class="mt-3 overflow-hidden rounded-lg border border-gray-200 bg-white">
                        @php
                            $pathKey = match ($doc['type']) {
                                'license_photo' => 'license_photo_path',
                                'recto' => 'dni_recto_path',
                                'verso' => 'dni_verso_path',
                                default => 'signature_path',
                            };
                        @endphp
                        @if ($docService->isImage($user->{$pathKey}))
                            <img
                                src="{{ portal_route('portal.document', ['type' => $doc['type']]) }}"
                                alt="{{ $doc['label'] }}"
                                class="mx-auto max-h-32 w-full object-contain"
                            />
                        @else
                            <a href="{{ portal_route('portal.document', ['type' => $doc['type']]) }}" class="block p-3 text-center text-sm font-semibold text-[#004481]">{{ __('portal.profile.view_pdf') }}</a>
                        @endif
                    </div>
                    <p class="mt-2 text-xs text-emerald-700">✓ {{ __('portal.profile.document_on_file') }}</p>
                @else
                    <p class="mt-3 text-xs text-gray-500">{{ __('portal.profile.document_missing') }}</p>
                @endif
            </div>
        @endforeach
    </div>

    <form method="post" action="{{ portal_route('portal.profile.documents') }}" enctype="multipart/form-data" class="border-t border-gray-100 px-5 py-5">
        @csrf
        <p class="text-sm font-medium text-gray-800">{{ __('portal.profile.upload_title') }}</p>
        <p class="mt-1 text-xs text-gray-500">{{ __('portal.profile.upload_hint') }}</p>
        <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="sm:col-span-2 lg:col-span-4">
                <label class="text-xs font-medium text-gray-600">{{ __('portal.license.photo_upload_label') }}</label>
                <p class="mt-0.5 text-[11px] text-gray-500">{{ __('portal.license.photo_upload_formats', [
                    'width_mm' => config('license_photo.width_mm'),
                    'height_mm' => config('license_photo.height_mm'),
                    'min_width' => config('license_photo.min_width'),
                    'min_height' => config('license_photo.min_height'),
                ]) }}</p>
                <input type="file" name="license_photo" accept=".jpg,.jpeg,.png,.webp" class="mt-1 w-full text-xs" />
            </div>
            <div>
                <label class="text-xs font-medium text-gray-600">{{ __('site.registration.dni_recto') }}</label>
                <input type="file" name="dni_recto" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 w-full text-xs" />
            </div>
            <div>
                <label class="text-xs font-medium text-gray-600">{{ __('site.registration.dni_verso') }}</label>
                <input type="file" name="dni_verso" accept=".jpg,.jpeg,.png,.pdf" class="mt-1 w-full text-xs" />
            </div>
            <div>
                <label class="text-xs font-medium text-gray-600">{{ __('site.registration.signature') }}</label>
                <input type="file" name="signature" accept=".jpg,.jpeg,.png" class="mt-1 w-full text-xs" />
            </div>
        </div>
        @error('license_photo')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        @error('dni_recto')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        @error('dni_verso')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        @error('signature')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
        @error('documents')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
        <button type="submit" class="mt-4 rounded-lg bg-[#004481] px-5 py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">
            {{ __('portal.profile.save_documents') }}
        </button>
    </form>
</section>
