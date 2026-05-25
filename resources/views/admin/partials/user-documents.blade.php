@php
    $docStatus = app(\App\Services\UserDocumentService::class)->status($user);
@endphp

<section class="rounded-xl border bg-white p-6 shadow-sm">
    <div class="flex flex-wrap items-start justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-gray-900">{{ __('admin.documents') }}</h2>
            <p class="mt-1 text-sm text-gray-500">{{ __('admin.documents_manage_hint') }}</p>
            @if ($user->updated_at)
                <p class="mt-1 text-xs text-gray-400">{{ __('admin.documents_updated', ['date' => $user->updated_at->format('d/m/Y H:i')]) }}</p>
            @endif
        </div>
        <div class="flex flex-wrap gap-2 text-xs">
            <span class="rounded-full px-2 py-1 {{ $docStatus['license_photo'] ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">{{ __('admin.license_photo') }} {{ $docStatus['license_photo'] ? '✓' : '—' }}</span>
            <span class="rounded-full px-2 py-1 {{ $docStatus['recto'] ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">{{ __('admin.dni_recto') }} {{ $docStatus['recto'] ? '✓' : '—' }}</span>
            <span class="rounded-full px-2 py-1 {{ $docStatus['verso'] ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">{{ __('admin.dni_verso') }} {{ $docStatus['verso'] ? '✓' : '—' }}</span>
            <span class="rounded-full px-2 py-1 {{ $docStatus['signature'] ? 'bg-emerald-100 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">{{ __('admin.signature') }} {{ $docStatus['signature'] ? '✓' : '—' }}</span>
        </div>
    </div>

    <form method="post" action="{{ route('admin.users.upload_documents', $user) }}" enctype="multipart/form-data" class="mt-6 space-y-5 border-t border-gray-100 pt-5">
        @csrf
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['type' => 'license_photo', 'label' => __('admin.license_photo'), 'field' => 'license_photo', 'accept' => '.jpg,.jpeg,.png,.webp', 'highlight' => true],
                ['type' => 'recto', 'label' => __('admin.dni_recto'), 'field' => 'dni_recto', 'accept' => '.jpg,.jpeg,.png,.pdf', 'highlight' => false],
                ['type' => 'verso', 'label' => __('admin.dni_verso'), 'field' => 'dni_verso', 'accept' => '.jpg,.jpeg,.png,.pdf', 'highlight' => false],
                ['type' => 'signature', 'label' => __('admin.signature'), 'field' => 'signature', 'accept' => '.jpg,.jpeg,.png', 'highlight' => false],
            ] as $doc)
                @php
                    $pathKey = match ($doc['type']) {
                        'license_photo' => 'license_photo_path',
                        'recto' => 'dni_recto_path',
                        'verso' => 'dni_verso_path',
                        default => 'signature_path',
                    };
                @endphp
                <div class="rounded-lg border {{ ($doc['highlight'] ?? false) ? 'border-sky-200 bg-sky-50/40' : 'border-gray-200 bg-slate-50/50' }} p-4">
                    <p class="text-sm font-semibold text-gray-800">{{ $doc['label'] }}</p>
                    @if (($doc['type'] ?? '') === 'license_photo')
                        <p class="mt-1 text-xs text-gray-500">{{ __('admin.license_photo_hint', [
                            'min_width' => config('license_photo.min_width'),
                            'min_height' => config('license_photo.min_height'),
                            'width_mm' => config('license_photo.width_mm'),
                            'height_mm' => config('license_photo.height_mm'),
                        ]) }}</p>
                    @endif
                    @if ($docStatus[$doc['type']])
                        <div class="mt-3 overflow-hidden rounded-lg border border-gray-200 bg-white">
                            @if (app(\App\Services\UserDocumentService::class)->isImage($user->{$pathKey}))
                                <img
                                    src="{{ route('admin.users.document', [$user, $doc['type']]) }}"
                                    alt="{{ $doc['label'] }}"
                                    class="{{ $doc['type'] === 'license_photo' ? 'h-[12rem] w-full min-h-[12rem] aspect-[26/32] object-cover object-top' : 'max-h-36 w-full object-contain' }} {{ $doc['type'] === 'recto' ? 'object-cover' : '' }}"
                                />
                            @else
                                <a href="{{ route('admin.users.document', [$user, $doc['type']]) }}" target="_blank" class="block p-4 text-center text-sm font-semibold text-[#004481] hover:underline">PDF — {{ __('admin.view_document') }}</a>
                            @endif
                        </div>
                    @else
                        <p class="mt-3 text-xs text-gray-500">{{ __('admin.no_document') }}</p>
                    @endif
                    <label class="mt-3 block">
                        <span class="text-xs text-gray-600">{{ $docStatus[$doc['type']] ? __('admin.replace_document') : __('admin.upload_document') }}</span>
                        <input type="file" name="{{ $doc['field'] }}" accept="{{ $doc['accept'] }}" class="mt-1 w-full text-xs text-gray-600" />
                    </label>
                </div>
            @endforeach
        </div>
        <div>
            <button type="submit" class="rounded-lg bg-[#004481] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[#003366]">
                {{ __('admin.save_documents') }}
            </button>
        </div>
    </form>
</section>
