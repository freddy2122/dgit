{{-- Identifiant UE Espagne (E blanc, étoiles jaunes, fond bleu) --}}
@php($euClass = $class ?? 'h-20 w-[7.25rem]')
<div class="{{ $euClass }} relative shrink-0 overflow-hidden rounded-[3px] shadow-md" aria-hidden="true">
    <svg class="h-full w-full" viewBox="0 0 52 34" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="España">
        <rect width="52" height="34" fill="#003399"/>
        <g fill="#FFCC00">
            <circle cx="26" cy="8.5" r="1.15"/><circle cx="29.8" cy="9.6" r="1.15"/><circle cx="32.9" cy="12.2" r="1.15"/>
            <circle cx="34.5" cy="15.8" r="1.15"/><circle cx="34.5" cy="19.8" r="1.15"/><circle cx="32.9" cy="23.4" r="1.15"/>
            <circle cx="29.8" cy="26" r="1.15"/><circle cx="26" cy="27.1" r="1.15"/><circle cx="22.2" cy="26" r="1.15"/>
            <circle cx="19.1" cy="23.4" r="1.15"/><circle cx="17.5" cy="19.8" r="1.15"/><circle cx="17.5" cy="15.8" r="1.15"/>
            <circle cx="19.1" cy="12.2" r="1.15"/><circle cx="22.2" cy="9.6" r="1.15"/>
        </g>
        <text x="26" y="22" text-anchor="middle" fill="#FFFFFF" font-size="15" font-weight="700" font-family="Arial,Helvetica,sans-serif">E</text>
    </svg>
</div>
