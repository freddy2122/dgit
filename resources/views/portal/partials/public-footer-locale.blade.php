<footer class="border-t border-gray-300 bg-white/90 px-4 py-4">
    <div class="mx-auto flex max-w-5xl flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <p class="text-xs text-gray-500">{{ __('portal.footer.demo') }}</p>
        @include('portal.partials.locale-switcher', ['variant' => 'light'])
    </div>
</footer>
