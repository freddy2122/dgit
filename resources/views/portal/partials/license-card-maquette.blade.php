@php
    use App\Support\LicenseCardLayout;

    $user = $user ?? auth()->user();
    $license = $license ?? $user?->licenseSummary;
    $size = $size ?? 'display';

    $surname = strtoupper(trim((string) ($user->last_name ?? '')));
    $given = strtoupper(trim((string) ($user->first_name ?? '')));
    if ($surname === '' && $given === '') {
        $parts = preg_split('/\s+/', trim((string) ($user->name ?? 'TITULAIRE')), 2);
        $surname = strtoupper($parts[0] ?? 'TITULAIRE');
        $given = strtoupper($parts[1] ?? '');
    }

    $nie = strtoupper(preg_replace('/\s+/', '', (string) ($user->nie ?? '00000000X')));
    $licNum = strlen($nie) >= 9 ? substr($nie, 0, 8).'-'.substr($nie, -1) : $nie;
    $birth = $user?->birth_date;
    $birthLabel = $birth ? $birth->format('d-m-Y').' FRA' : '—';
    $published = $license?->isPublishedForClient() ?? false;
    $issued = $license?->issued_at;
    $expiry = $license?->valid_until;
    $issuedLabel = $issued ? $issued->format('d-m-Y') : '—';
    $expiryLabel = $expiry ? $expiry->format('d-m-Y') : '—';
    $authority = $published ? ($license?->authority_code ?? '—') : '—';

    $catDisplay = '—';
    if ($published && $license) {
        $catDisplay = $license->displayCategoryLabel() ?: '—';
    }

    $signature = trim(collect([
        $user->first_name ? ucfirst(mb_strtolower((string) $user->first_name)) : null,
        $user->last_name ? ucfirst(mb_strtolower((string) $user->last_name)) : null,
    ])->filter()->join(' ')) ?: trim((string) ($user->name ?? ''));

    $euBadgeClass = 'h-[4.5rem] w-[7.25rem]';
    $photoBoxClass = 'h-[10rem] w-[8.125rem] shrink-0';

    $licenseCardLayout = LicenseCardLayout::classes($size);
    $licenseCardScale = $licenseCardLayout['scale'];
    $licenseCardWrap = $licenseCardLayout['wrap'];
    $licenseCardBox = $licenseCardLayout['box'];
@endphp

@once
    @push('head')
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=seaweed-script:400" rel="stylesheet">
    @endpush
@endonce

<div class="{{ $licenseCardWrap }} flex justify-center {{ $class ?? '' }}">
    <div class="{{ $licenseCardScale }} {{ $licenseCardBox }}">

        <div class="absolute inset-0 opacity-60" style="background: radial-gradient(circle at 20% 30%, rgba(255,255,255,.8), transparent 18%), radial-gradient(circle at 80% 20%, rgba(255,255,255,.6), transparent 20%), linear-gradient(135deg, #fde2ea, #fff7f9 45%, #f8cfdc);"></div>

        <div class="absolute inset-0 opacity-20 pointer-events-none" aria-hidden="true">
            <div class="absolute -right-20 -top-16 w-72 h-72 rounded-full border-[28px] border-pink-300"></div>
            <div class="absolute right-20 bottom-4 w-44 h-44 rounded-full border-[20px] border-pink-300"></div>
            <div class="absolute left-12 bottom-10 w-32 h-32 rounded-full border-[14px] border-pink-300"></div>
        </div>

        <div class="relative z-10 flex h-full flex-col p-8">
            {{-- Haut : badge UE + photo (6) à gauche | titre + champs 1–5 et 9 à droite --}}
            <div class="flex items-start gap-6">
                <div class="flex shrink-0 flex-col gap-3">
                    @include('portal.partials.license-eu-spain', ['class' => $euBadgeClass])
                    <div class="">
                        <span class="relative z-[3] inline-block shrink-0 pt-1 font-mono text-[17px] font-bold not-italic leading-none text-slate-900">6.</span>
                        <div class="relative z-[2] {{ $photoBoxClass }} overflow-hidden bg-transparent">
                            @include('portal.partials.license-photo', [
                                'user' => $user,
                                'photoClass' => 'block h-full w-full min-h-full min-w-full object-cover object-top opacity-[0.88] grayscale-[18%] saturate-[0.92]',
                                'blendIntoCard' => true,
                            ])
                            <div
                                class="pointer-events-none absolute inset-0"
                                aria-hidden="true"
                                style="background: linear-gradient(165deg, rgba(253,242,248,.5) 0%, transparent 40%, transparent 60%, rgba(248,207,220,.4) 100%), radial-gradient(ellipse 90% 75% at 50% 50%, transparent 35%, rgba(253,226,234,.3) 100%);"
                            ></div>
                        </div>
                    </div>
                </div>

                <div class="min-w-0 flex-1 pt-1">
                    <p class="mb-3 flex flex-nowrap items-baseline gap-x-2 text-[13px] font-black uppercase italic leading-tight tracking-wide text-blue-900 sm:text-[15px]">
                        <span class="shrink-0">{{ __('portal.license.card_title') }}</span>
                        <span class="shrink-0 font-bold text-blue-800">{{ __('portal.license.card_country') }}</span>
                    </p>

                    <div class="font-mono text-[17px] italic leading-[1.45] text-slate-900 pt-6">
                        <div class="grid grid-cols-[36px_1fr] gap-x-2 gap-y-0.5">
                            <span class="font-bold">1.</span>
                            <span class="truncate font-bold uppercase">{{ $surname }}</span>
                            <span class="font-bold">2.</span>
                            <span class="truncate font-bold uppercase">{{ $given }}</span>
                            <span class="font-bold">3.</span>
                            <span>{{ $birthLabel }}</span>
                            <span class="font-bold">4a.</span>
                            <span>{{ $issuedLabel }}&nbsp;&nbsp;&nbsp; 4c. {{ $authority }}</span>
                            <span class="font-bold">4b.</span>
                            <span>{{ $expiryLabel }}</span>
                            <span class="font-bold">5.</span>
                            <span>{{ $licNum }}</span>
                            <span class="font-bold">7.</span>
                            <span>
                            @if ($user->signature_path)
                                <img
                                    src="{{ portal_route('portal.signature') }}"
                                    alt="{{ __('portal.license.signature_aria', ['name' => $signature]) }}"
                                    class="max-h-[4rem] w-full max-w-[14rem] object-contain object-left-bottom"
                                />
                            @elseif ($published && $signature !== '')
                                <span
                                    class="block text-[2.65rem] leading-none text-[#1a2744] sm:text-[2.85rem]"
                                    style="font-family: 'Seaweed Script', 'Brush Script MT', cursive;"
                                    aria-label="{{ __('portal.license.signature_aria', ['name' => $signature]) }}"
                                >{{ $signature }}</span>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1" aria-hidden="true"></div>

            {{-- Bas : 9. catégorie (coin gauche) --}}
            <div class="relative min-h-[4rem] shrink-0" style="margin-top: -25px;">
                <div class="absolute bottom-0 left-0 z-20 flex max-w-[48%] flex-wrap items-baseline gap-x-2 font-mono not-italic leading-tight text-slate-900">
                    <span class="text-[15px] font-bold">9.</span>
                    <span class="text-[10px] font-semibold uppercase tracking-[0.12em] text-slate-800"></span>
                    @if ($catDisplay !== '—')
                        <span class="text-[17px] font-bold italic">{{ $catDisplay }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
