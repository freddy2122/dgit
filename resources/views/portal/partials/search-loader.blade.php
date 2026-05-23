<div id="portal-search-loader" class="fixed inset-0 z-50 hidden items-center justify-center bg-[#004481]/40 backdrop-blur-sm" aria-live="polite" aria-busy="true">
    <div class="mx-4 w-full max-w-sm rounded-2xl bg-white p-8 text-center shadow-2xl">
        <div class="portal-spinner mx-auto h-14 w-14 rounded-full border-4 border-sky-100 border-t-[#004481]" role="status"></div>
        <p class="mt-5 text-base font-bold text-gray-900">{{ $title ?? __('status.loading_title') }}</p>
        <p class="mt-2 text-sm text-gray-500">{{ $subtitle ?? __('status.loading_sub') }}</p>
    </div>
</div>
