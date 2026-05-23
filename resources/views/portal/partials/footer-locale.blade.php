<footer class="mt-auto border-t border-gray-200 bg-white px-4 py-4 sm:px-6 lg:px-8">
    <div class="mx-auto flex max-w-7xl flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-xs text-gray-500">{{ __('portal.footer.demo') }}</p>
        <div class="flex flex-wrap items-center gap-4">
            <p class="text-xs text-gray-400">{{ __('portal.footer.copyright', ['year' => date('Y')]) }}</p>
            @include('portal.partials.locale-switcher', ['variant' => 'light'])
        </div>
    </div>
</footer>
