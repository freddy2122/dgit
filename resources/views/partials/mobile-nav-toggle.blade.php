@props(['id' => 'app-nav', 'label' => 'Menu'])
<button
    type="button"
    id="{{ $id }}-open"
    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white text-gray-700 shadow-sm hover:bg-gray-50 lg:hidden"
    aria-controls="{{ $id }}-drawer"
    aria-expanded="false"
    aria-label="{{ $label }}"
>
    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
</button>
