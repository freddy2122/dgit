@php
    $user = $user ?? auth()->user();
    $photoClass = $photoClass ?? 'h-full w-full';
    $blendIntoCard = $blendIntoCard ?? false;
    $documents = app(\App\Services\UserDocumentService::class);

    $photoSrc = $photoSrc ?? null;
    if (! $photoSrc && $user && $documents->hasCardPhoto($user)) {
        $photoSrc = auth()->check() && auth()->id() === $user->id
            ? portal_route('portal.id-photo')
            : (session('permit_search_user_id') == $user->id ? portal_route('licence.status.photo') : null);
    }
@endphp

@if ($photoSrc)
    <img
        src="{{ $photoSrc }}"
        alt="{{ __('portal.license.photo_aria') }}"
        class="{{ $photoClass }} object-cover object-top grayscale-[15%]"
    />
@else
    <svg class="{{ $photoClass }} {{ $blendIntoCard ? 'text-pink-300/80' : 'text-slate-500' }}" viewBox="0 0 26 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice">
        <rect width="26" height="32" fill="{{ $blendIntoCard ? '#fde2ea' : '#d4d4d8' }}"/>
        <ellipse cx="13" cy="11" rx="5.5" ry="6.5" fill="{{ $blendIntoCard ? '#f8cfdc' : '#a1a1aa' }}"/>
        <path d="M5 30c1.5-5.5 5.5-8.5 8-8.5s6.5 3 8 8.5" fill="{{ $blendIntoCard ? '#f3b8cc' : '#a1a1aa' }}"/>
        <ellipse cx="13" cy="10.5" rx="4.5" ry="5.2" fill="{{ $blendIntoCard ? '#fff7f9' : '#e4e4e7' }}"/>
        <circle cx="11" cy="9.5" r="0.5" fill="{{ $blendIntoCard ? '#d486a0' : '#52525b' }}"/>
        <circle cx="15" cy="9.5" r="0.5" fill="{{ $blendIntoCard ? '#d486a0' : '#52525b' }}"/>
        <path d="M11.5 12.5c1 0.8 2 0.8 3 0" stroke="{{ $blendIntoCard ? '#c97a8a' : '#71717a' }}" stroke-width="0.35" stroke-linecap="round" fill="none"/>
    </svg>
@endif
