<span
    id="status-search-i18n"
    class="hidden"
    data-copied="{{ e(__('status.copied')) }}"
    data-copy-code="{{ e(__('status.copy_code')) }}"
    data-active-tab="{{ $activeTab ?? 'search' }}"
    data-searched="{{ ($searched ?? false) ? '1' : '0' }}"
    aria-hidden="true"
></span>
<script>
(function () {
    const i18n = document.getElementById('status-search-i18n');
    const copiedLabel = i18n?.dataset.copied ?? '';
    const copyCodeLabel = i18n?.dataset.copyCode ?? '';
    const form = document.getElementById('status-search-form');
    const loader = document.getElementById('portal-search-loader');
    const tabSearch = document.getElementById('tab-search');
    const tabResult = document.getElementById('tab-result');
    const panelSearch = document.getElementById('panel-search');
    const panelResult = document.getElementById('panel-result');
    const canShowResult = i18n?.dataset.searched === '1';

    const activeClass = 'border-b-2 border-[#004481] bg-white px-4 py-2 text-[#004481]';
    const idleClass = 'bg-gray-200/80 px-4 py-2 text-gray-500';
    const idleHoverClass = idleClass + ' hover:text-[#004481]';

    function hideLoader() {
        if (!loader) return;
        loader.classList.add('hidden');
        loader.classList.remove('flex');
    }

    function setTab(tab) {
        const showResult = tab === 'result' && canShowResult;
        if (tabSearch) {
            tabSearch.className = showResult ? idleHoverClass : activeClass;
            tabSearch.setAttribute('aria-selected', showResult ? 'false' : 'true');
        }
        if (tabResult) {
            tabResult.className = showResult ? activeClass : (canShowResult ? idleHoverClass : idleClass + ' cursor-not-allowed opacity-60');
            tabResult.setAttribute('aria-selected', showResult ? 'true' : 'false');
        }
        if (panelSearch) panelSearch.classList.toggle('hidden', showResult);
        if (panelResult) panelResult.classList.toggle('hidden', !showResult);
        if (showResult && panelResult) {
            panelResult.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }

    hideLoader();

    if (form && loader) {
        form.addEventListener('submit', function () {
            loader.classList.remove('hidden');
            loader.classList.add('flex');
        });
    }

    document.querySelectorAll('[data-status-tab]').forEach((el) => {
        el.addEventListener('click', function (e) {
            const tab = el.dataset.statusTab;
            if (tab === 'result' && !canShowResult) {
                e.preventDefault();
                return;
            }
            if (tab === 'search' || tab === 'result') {
                e.preventDefault();
                setTab(tab);
            }
        });
    });

    document.querySelectorAll('[data-copy-target]').forEach((btn) => {
        btn.addEventListener('click', () => {
            const el = document.getElementById(btn.dataset.copyTarget);
            if (!el) return;
            navigator.clipboard.writeText(el.textContent.trim());
            btn.textContent = copiedLabel;
            setTimeout(() => { btn.textContent = copyCodeLabel; }, 2000);
        });
    });

    const initialTab = i18n?.dataset.activeTab === 'result' && canShowResult ? 'result' : 'search';
    setTab(initialTab);
})();
</script>
