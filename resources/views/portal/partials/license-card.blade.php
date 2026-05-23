@include('portal.partials.license-card-styles')

@php
    $user = $user ?? auth()->user();
    $license = $license ?? $user?->licenseSummary;
    $size = $size ?? 'lg';

    $surname = strtoupper(trim((string) ($user->last_name ?? '')));
    $given = strtoupper(trim((string) ($user->first_name ?? '')));
    if ($surname === '' && $given === '') {
        $parts = preg_split('/\s+/', trim((string) ($user->name ?? __('portal.user_default'))), 2);
        $surname = strtoupper($parts[0] ?? 'TITULAIRE');
        $given = strtoupper($parts[1] ?? '');
    }
    if ($given === '' && $surname !== '') {
        $given = '—';
    }

    $nie = strtoupper(preg_replace('/\s+/', '', (string) ($user->nie ?? '00000000X')));
    $licNum = strlen($nie) >= 9 ? substr($nie, 0, 8).'-'.substr($nie, -1) : $nie;

    $birth = $user?->birth_date;
    $birthLabel = $birth ? $birth->format('d-m-Y').' '.__('portal.license.birth_place') : '—';

    $validUntil = $license?->valid_until;
    $issued = $license?->issued_at ?? ($validUntil ? $validUntil->copy()->subYears(10) : now()->subYears(6));
    $expiry = $validUntil ?? now()->addYears(4);
    $authority = $license?->authority_code ?? '28-00';

    $catRows = $license ? $license->categoryRows() : collect();
    if ($catRows->isEmpty()) {
        $mainCat = strtoupper((string) ($license?->category ?? 'B'));
        $catRows = collect(['AM', 'A1', 'A2', 'A', 'B'])->map(fn ($c) => [
            'code' => $c,
            'active' => $c === $mainCat || ($mainCat === 'B' && in_array($c, ['AM', 'A1', 'A2', 'A', 'B'], true)),
        ]);
    }
    $catDisplay = $catRows
        ->map(fn ($row) => ($row['active'] ?? false)
            ? "<strong class=\"text-gray-900\">{$row['code']}</strong>"
            : "<span class=\"text-gray-600/70\">{$row['code']}</span>")
        ->implode(' ');

    $maxW = match ($size) {
        'display' => 'w-full max-w-[42rem]',
        'hero' => 'w-full max-w-3xl',
        'thumb' => 'w-[12.5rem] max-w-none',
        'xl' => 'max-w-3xl w-full',
        'lg' => 'max-w-2xl w-full',
        default => 'max-w-xl w-full',
    };
    $photoWrap = match ($size) {
        'display' => 'h-[11.5rem] w-auto aspect-[26/32] sm:h-[12.5rem]',
        'hero' => 'h-[10rem] w-auto aspect-[26/32] sm:h-[11rem]',
        'thumb' => 'h-[4.25rem] w-auto aspect-[26/32]',
        'xl' => 'h-36 w-auto aspect-[26/32] sm:h-40',
        default => 'h-28 w-auto aspect-[26/32] sm:h-32',
    };
    $euSize = match ($size) {
        'display' => 'h-11 w-[3.25rem]',
        'hero' => 'h-10 w-[3rem]',
        'thumb' => 'h-6 w-[1.85rem]',
        default => 'h-9 w-[2.75rem]',
    };
    $titleClass = match ($size) {
        'display' => 'text-[0.72rem] sm:text-[0.8rem]',
        'hero' => 'text-[0.65rem] sm:text-xs',
        'thumb' => 'text-[6px] leading-tight',
        default => 'text-[9px] sm:text-[10px]',
    };
    $nameClass = match ($size) {
        'display' => 'text-base sm:text-lg',
        'hero' => 'text-sm sm:text-base',
        'thumb' => 'text-[8px] leading-tight',
        default => 'text-xs sm:text-sm',
    };
    $metaClass = match ($size) {
        'display' => 'text-sm sm:text-[0.95rem]',
        'hero' => 'text-xs sm:text-sm',
        'thumb' => 'text-[7px]',
        default => 'text-xs',
    };
    $padClass = match ($size) {
        'display' => 'px-5 py-5 sm:px-7 sm:py-6',
        'hero' => 'px-5 py-5 sm:px-6 sm:py-6',
        'thumb' => 'px-2 py-2',
        default => 'px-4 py-3 sm:px-5 sm:py-4',
    };
    $isThumb = $size === 'thumb';
    $sigClass = match ($size) {
        'display' => 'text-xl sm:text-2xl',
        'hero' => 'text-lg sm:text-xl',
        default => 'text-sm sm:text-base',
    };
    $catRowClass = match ($size) {
        'display' => 'text-[0.7rem] sm:text-xs',
        default => 'text-[9px] sm:text-[10px]',
    };

@endphp

<article
    class="{{ $maxW }} license-card-surface relative mx-auto overflow-hidden {{ $isThumb ? 'rounded-md shadow-lg' : 'rounded-xl shadow-2xl' }} {{ $class ?? '' }}"
    aria-label="{{ __('portal.license.card_aria') }}"
>
    <div class="license-card-pattern pointer-events-none absolute inset-0 opacity-[0.35]" aria-hidden="true"></div>
    <div class="pointer-events-none absolute -right-6 bottom-0 h-28 w-28 opacity-[0.08]" aria-hidden="true">
        <svg viewBox="0 0 100 100" class="h-full w-full text-[#b91c4a]" fill="currentColor"><circle cx="50" cy="50" r="42"/><text x="50" y="58" text-anchor="middle" font-size="28" fill="#fff">E</text></svg>
    </div>

    <div class="relative {{ $padClass }}">
        <div class="flex {{ $isThumb ? 'items-start gap-2' : 'flex-col gap-4 sm:flex-row sm:items-start sm:gap-5' }}">
            <div class="flex shrink-0 flex-col {{ $isThumb ? 'gap-1' : 'gap-2.5' }}">
                <div class="{{ $euSize }} relative overflow-hidden rounded-[2px] shadow-md" aria-hidden="true">
                    <svg class="h-full w-full" viewBox="0 0 52 34" xmlns="http://www.w3.org/2000/svg">
                        <rect width="52" height="34" fill="#003399"/>
                        <g fill="#FFCC00">
                            <circle cx="26" cy="8.5" r="1"/><circle cx="29.8" cy="9.6" r="1"/><circle cx="32.9" cy="12.2" r="1"/>
                            <circle cx="34.5" cy="15.8" r="1"/><circle cx="34.5" cy="19.8" r="1"/><circle cx="32.9" cy="23.4" r="1"/>
                            <circle cx="29.8" cy="26" r="1"/><circle cx="26" cy="27.1" r="1"/><circle cx="22.2" cy="26" r="1"/>
                            <circle cx="19.1" cy="23.4" r="1"/><circle cx="17.5" cy="19.8" r="1"/><circle cx="17.5" cy="15.8" r="1"/>
                            <circle cx="19.1" cy="12.2" r="1"/><circle cx="22.2" cy="9.6" r="1"/>
                        </g>
                        <text x="26" y="27" text-anchor="middle" fill="#FFCC00" font-size="14" font-weight="700" font-family="Arial,sans-serif">E</text>
                    </svg>
                </div>
                <div
                    class="{{ $photoWrap }} overflow-hidden bg-zinc-200 shadow-inner"
                    style="border: 3px solid rgba(255,255,255,0.92);"
                    role="img"
                    aria-label="{{ __('portal.license.photo_aria') }}"
                >
                    @include('portal.partials.license-photo', ['user' => $user, 'photoClass' => 'h-full w-full min-h-full min-w-full object-cover object-center'])
                </div>
            </div>

            <div class="min-w-0 flex-1">
                <p class="{{ $titleClass }} flex flex-nowrap items-baseline gap-x-1.5 font-bold uppercase leading-tight tracking-[0.06em] text-[#003d82]">
                    <span class="shrink-0">{{ __('portal.license.card_title') }}</span>
                    <span class="shrink-0">{{ __('portal.license.card_country') }}</span>
                </p>

                <dl class="{{ $isThumb ? 'mt-1 space-y-0.5' : 'mt-3 space-y-1 sm:mt-3.5 sm:space-y-1.5' }}">
                    <div class="flex {{ $isThumb ? 'gap-1' : 'gap-2' }}">
                        <dt class="{{ $isThumb ? 'w-3 text-[7px]' : 'w-5 text-sm' }} shrink-0 font-bold text-[#003d82]">1.</dt>
                        <dd class="{{ $nameClass }} font-bold uppercase tracking-wide text-gray-900">{{ $surname }}</dd>
                    </div>
                    <div class="flex {{ $isThumb ? 'gap-1' : 'gap-2' }}">
                        <dt class="{{ $isThumb ? 'w-3 text-[7px]' : 'w-5 text-sm' }} shrink-0 font-bold text-[#003d82]">2.</dt>
                        <dd class="{{ $nameClass }} font-bold uppercase text-gray-900">{{ $given }}</dd>
                    </div>
                    @unless ($isThumb)
                    <div class="flex gap-2">
                        <dt class="w-5 shrink-0 text-sm font-bold text-[#003d82]">3.</dt>
                        <dd class="{{ $metaClass }} font-semibold text-gray-900">{{ $birthLabel }}</dd>
                    </div>
                    <div class="flex flex-wrap gap-x-4 gap-y-0.5 {{ $metaClass }} font-semibold text-gray-900">
                        <div><span class="font-bold text-[#003d82]">4a.</span> {{ $issued->format('d-m-Y') }}</div>
                        <div><span class="font-bold text-[#003d82]">4b.</span> {{ $expiry->format('d-m-Y') }}</div>
                        <div><span class="font-bold text-[#003d82]">4c.</span> {{ $authority }}</div>
                    </div>
                    @endunless
                    <div class="flex {{ $isThumb ? 'gap-1' : 'gap-2' }}">
                        <dt class="{{ $isThumb ? 'w-3 text-[7px]' : 'w-5 text-sm' }} shrink-0 font-bold text-[#003d82]">5.</dt>
                        <dd class="{{ $metaClass }} font-mono font-bold tracking-wider text-gray-900">{{ $licNum }}</dd>
                    </div>
                </dl>

                @unless ($isThumb)
                @php
                    $sigGiven = $given !== '—' ? ucfirst(strtolower($given)) : '';
                    $sigSurname = ucfirst(strtolower($surname));
                    $signature = trim($sigGiven.' '.$sigSurname) ?: ($user->name ?? '');
                @endphp
                @if ($signature !== '')
                    <p class="{{ $sigClass }} mt-3 font-serif italic text-gray-800/90 sm:mt-4" aria-hidden="true">{{ $signature }}</p>
                @endif
                @endunless
            </div>
        </div>

        @unless ($isThumb)
        <p class="relative mt-4 border-t border-[#c97a8a]/35 pt-2.5 {{ $catRowClass }} font-semibold uppercase tracking-wide text-[#003d82] sm:mt-4">
            <span class="mr-1.5 font-bold text-gray-700">9.</span>{!! $catDisplay !!}
        </p>
        @endunless
    </div>
</article>
