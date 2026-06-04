@include('licence.partials.status-result-vars')

<div class="status-result-responsive">
    <div class="status-result-responsive__mobile lg:hidden">
        @include('licence.partials.status-result-midgt-mobile')
    </div>

    <div class="status-result-responsive__desktop hidden lg:block">
        @include('licence.partials.status-result-midgt-desktop')
    </div>
</div>

@once
    @push('head')
        <link rel="stylesheet" href="{{ asset('css/status-midgt-pixel.css') }}?v=5" />
    @endpush
    @push('scripts')
        <script>
            document.querySelectorAll('.midgt-validation__bar[data-pct]').forEach((bar) => {
                const pct = Math.min(100, Math.max(0, Number(bar.dataset.pct) || 0));
                const fill = bar.querySelector('.midgt-validation__fill');
                if (fill) {
                    fill.style.width = pct + '%';
                }
            });

            document.querySelectorAll('[data-midgt-tab]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.midgtTab;
                    const root = btn.closest('.midgt-app');
                    if (!root) {
                        return;
                    }
                    root.querySelectorAll('[data-midgt-tab]').forEach((b) => {
                        const on = b.dataset.midgtTab === id;
                        b.classList.toggle('is-active', on);
                        b.setAttribute('aria-selected', on ? 'true' : 'false');
                    });
                    root.querySelectorAll('[data-midgt-panel]').forEach((panel) => {
                        const on = panel.dataset.midgtPanel === id;
                        panel.classList.toggle('is-active', on);
                        panel.hidden = !on;
                    });
                });
            });
        </script>
    @endpush
@endonce
