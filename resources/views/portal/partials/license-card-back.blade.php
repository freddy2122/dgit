@php
    use App\Models\LicenseSummary;
    use App\Support\LicenseCardLayout;

    $user = $user ?? auth()->user();
    $license = $license ?? $user?->licenseSummary;
    $size = $size ?? 'display';

    $rowsByCode = ($license?->categoryRows() ?? collect())->keyBy(fn ($r) => strtoupper((string) ($r['code'] ?? '')));
    $tableRows = collect(LicenseSummary::categoryCodes())->map(function (string $code) use ($rowsByCode) {
        $row = $rowsByCode->get(strtoupper($code));

        return [
            'code' => $code,
            'active' => (bool) ($row['active'] ?? false),
            'valid_from' => $row['valid_from'] ?? null,
            'valid_until' => $row['valid_until'] ?? null,
            'codes' => $row['codes'] ?? null,
        ];
    });

    $euBadgeSm = 'h-[1.1rem] w-[1.75rem]';
    $watermarkUrl = asset('images/license-card-watermark.png');
    $licenseCardLayout = LicenseCardLayout::classes($size);
    $licenseCardScale = $licenseCardLayout['scale'];
    $licenseCardWrap = $licenseCardLayout['wrap'];
    $licenseCardBox = $licenseCardLayout['box'];
@endphp

@include('portal.partials.license-card-fonts')

<div class="{{ $licenseCardWrap }} flex justify-center {{ $class ?? '' }}">
    <div
        class="{{ $licenseCardScale }} {{ $licenseCardBox }}"
        aria-label="{{ __('portal.license.card_aria') }} — {{ __('portal.license.back') }}"
    >
        <div class="absolute inset-0 opacity-60" style="background: radial-gradient(circle at 20% 30%, rgba(255,255,255,.8), transparent 18%), radial-gradient(circle at 80% 20%, rgba(255,255,255,.6), transparent 20%), linear-gradient(135deg, #fde2ea, #fff7f9 45%, #f8cfdc);"></div>

        @if (file_exists(public_path('images/license-card-watermark.png')))
            <img
                src="{{ $watermarkUrl }}"
                alt=""
                class="pointer-events-none absolute inset-0 z-[1] h-full w-full object-cover object-center opacity-[0.35] mix-blend-multiply"
                aria-hidden="true"
            />
        @endif

        <div class="absolute inset-0 z-[1] opacity-20 pointer-events-none" aria-hidden="true">
            <div class="absolute -right-20 -top-16 h-72 w-72 rounded-full border-[28px] border-pink-300"></div>
            <div class="absolute right-16 bottom-6 h-40 w-40 rounded-full border-[18px] border-pink-300"></div>
        </div>

        <div class="relative z-10 flex h-full flex-col p-4 sm:p-5">
            <div class="flex min-h-0 flex-1 gap-2 sm:gap-3">
                <aside class="flex h-full w-[26%] shrink-0 flex-col border-r border-[#003399]/15 pr-2 text-[6px] leading-[1.3] text-[#003399] sm:text-[6.5px]">
                    <div class="shrink-0">
                        <p class="mb-1.5 font-bold">13.</p>
                        <p class="mb-1.5 font-bold">14.</p>
                    </div>
                    <div class="mt-auto pb-0.5">
                        <ul class="space-y-[2px] font-semibold">
                            @foreach (__('portal.license.back_legend') as $line)
                                <li>{{ $line }}</li>
                            @endforeach
                        </ul>
                        <p class="mt-2 text-[5.5px] font-medium text-gray-600">{{ __('portal.license.back_copyright') }}</p>
                    </div>
                </aside>

                <div class="min-h-0 min-w-0 flex-1 overflow-hidden border-r-2 border-[#003399]/75 pr-1">
                    <table class="w-full border-collapse text-[7.5px] text-[#003399] sm:text-[8px]">
                        <thead>
                            <tr class="border-b border-[#003399]/70">
                                <th class="pb-0.5 pr-1 text-left font-bold" colspan="2">9.</th>
                                <th class="w-[16%] pb-0.5 pr-1 text-left font-bold">10.</th>
                                <th class="w-[16%] pb-0.5 pr-1 text-left font-bold">11.</th>
                                <th class="w-[13%] pb-0.5 text-left font-bold">12.</th>
                            </tr>
                            <tr class="border-b border-[#003399]/45 text-[6.5px] font-semibold sm:text-[7px]">
                                <th class="pb-0.5 pr-1 text-left" colspan="2">{{ __('portal.license.col_category') }}</th>
                                <th class="pb-0.5 pr-0.5 text-left">{{ __('portal.license.col_valid_from') }}</th>
                                <th class="pb-0.5 pr-0.5 text-left">{{ __('portal.license.col_valid_until') }}</th>
                                <th class="pb-0.5 text-left">{{ __('portal.license.col_codes') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tableRows as $row)
                                <tr class="border-b border-dashed border-[#003399]/40 {{ $row['active'] ? 'bg-white/20 font-bold' : 'font-semibold text-[#003399]/55' }}">
                                    <td class="w-[8%] py-[2px] pl-0.5 align-middle text-[8px] font-bold tracking-tight sm:text-[8.5px]">{{ $row['code'] }}</td>
                                    <td class="w-[50%] py-[2px] pr-1 text-left align-middle">
                                        @include('portal.partials.license-category-icon', [
                                            'code' => $row['code'],
                                            'color' => $row['active'] ? '#003399' : '#00339966',
                                        ])
                                    </td>
                                    <td class="license-ocr py-[2px] pr-0.5 align-middle text-[7px] leading-tight">{{ $row['active'] ? ($row['valid_from'] ?? '') : '' }}</td>
                                    <td class="license-ocr py-[2px] pr-0.5 align-middle text-[7px] leading-tight">{{ $row['active'] ? ($row['valid_until'] ?? '') : '' }}</td>
                                    <td class="license-ocr py-[2px] align-middle text-[7px] leading-tight">{{ $row['active'] ? ($row['codes'] ?? '') : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-1 flex shrink-0 items-end justify-end gap-1.5 pr-0.5">
                <span class="text-[8px] font-black leading-none tracking-wide text-[#003399] sm:text-[9px]">{{ __('portal.license.back_country_mark') }}</span>
                @include('portal.partials.license-eu-spain', ['class' => $euBadgeSm])
            </div>
        </div>
    </div>
</div>
