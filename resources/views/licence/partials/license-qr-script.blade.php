@once
@push('scripts')
<script>
(function () {
    function formatTime(sec) {
        const m = Math.floor(sec / 60);
        const s = sec % 60;
        return m + ':' + String(s).padStart(2, '0');
    }

    function initPanel(panel) {
        const generateUrl = panel.dataset.generateUrl ?? '';
        const ttlSeconds = parseInt(panel.dataset.ttlSeconds ?? '180', 10);
        const refreshBefore = parseInt(panel.dataset.refreshBefore ?? '15', 10);
        const errorMsg = panel.dataset.errorMsg ?? '';

        const loading = panel.querySelector('.license-qr-loading');
        const content = panel.querySelector('.license-qr-content');
        const errorBox = panel.querySelector('.license-qr-error');
        const svgWrap = panel.querySelector('.license-qr-svg-wrap');
        const timerBadge = panel.querySelector('.license-qr-timer-badge');
        const timerEl = panel.querySelector('.license-qr-timer');
        const plainEl = panel.querySelector('.license-qr-plain-token');
        const regenBtn = panel.querySelector('.license-qr-regenerate');
        const startBtn = panel.querySelector('.license-qr-start');

        let countdownInterval = null;
        let refreshTimeout = null;
        let expiresAtMs = 0;
        let active = false;

        function stopTimers() {
            if (countdownInterval) clearInterval(countdownInterval);
            if (refreshTimeout) clearTimeout(refreshTimeout);
            countdownInterval = null;
            refreshTimeout = null;
        }

        function startCountdown(expiresIn) {
            stopTimers();
            expiresAtMs = Date.now() + expiresIn * 1000;
            timerBadge?.classList.remove('hidden');
            timerBadge?.classList.add('inline-flex');

            function tick() {
                const left = Math.max(0, Math.ceil((expiresAtMs - Date.now()) / 1000));
                if (timerEl) timerEl.textContent = formatTime(left);
                if (left <= 0 && countdownInterval) clearInterval(countdownInterval);
            }
            tick();
            countdownInterval = setInterval(tick, 1000);

            const refreshIn = Math.max(5, expiresIn - refreshBefore);
            refreshTimeout = setTimeout(generateQr, refreshIn * 1000);
        }

        async function generateQr() {
            if (!active && panel.dataset.autoStart !== '1') return;
            loading?.classList.remove('hidden');
            content?.classList.add('hidden');
            errorBox?.classList.add('hidden');
            startBtn?.classList.add('hidden');

            try {
                const res = await fetch(generateUrl, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                const data = await res.json();
                loading?.classList.add('hidden');

                if (!res.ok) {
                    errorBox?.classList.remove('hidden');
                    if (errorBox) errorBox.textContent = data.error || errorMsg;
                    startBtn?.classList.remove('hidden');
                    return;
                }

                if (svgWrap) svgWrap.innerHTML = data.qr_svg ?? '';
                if (plainEl) plainEl.textContent = data.plain_token ?? '';
                content?.classList.remove('hidden');
                startCountdown(data.expires_in ?? ttlSeconds);
            } catch {
                loading?.classList.add('hidden');
                errorBox?.classList.remove('hidden');
                if (errorBox) errorBox.textContent = errorMsg;
                startBtn?.classList.remove('hidden');
            }
        }

        function activate() {
            active = true;
            generateQr();
        }

        startBtn?.addEventListener('click', activate);
        regenBtn?.addEventListener('click', generateQr);

        if (panel.dataset.autoStart === '1') {
            active = true;
            generateQr();
        }

        return { activate, generateQr, stopTimers: stopTimers };
    }

    const panels = new Map();
    document.querySelectorAll('[data-license-qr-panel]').forEach((panel) => {
        panels.set(panel.id, initPanel(panel));
    });

    const modal = document.getElementById('license-qr-modal');
    const openBtn = document.getElementById('license-qr-open');
    const closeBtn = document.getElementById('license-qr-modal-close');

    function setModalOpen(open) {
        if (!modal) return;
        modal.hidden = !open;
        modal.classList.toggle('hidden', !open);
        modal.classList.toggle('flex', open);
        document.body.classList.toggle('overflow-hidden', open);
        if (!open) {
            const modalPanel = document.getElementById('license-qr-modal-panel');
            if (modalPanel) panels.get(modalPanel.id)?.stopTimers?.();
        }
    }

    openBtn?.addEventListener('click', function () {
        setModalOpen(true);
        const modalPanel = document.getElementById('license-qr-modal-panel');
        if (modalPanel) {
            const api = panels.get(modalPanel.id);
            if (api) api.activate();
            else initPanel(modalPanel).activate();
        }
    });
    closeBtn?.addEventListener('click', function () { setModalOpen(false); });
    modal?.addEventListener('click', function (e) {
        if (e.target === modal) setModalOpen(false);
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal && !modal.hidden) setModalOpen(false);
    });
})();
</script>
@endpush
@endonce
