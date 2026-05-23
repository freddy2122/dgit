<div id="qr-scanner-panel" class="mb-6 hidden rounded-xl border-2 border-[#004481]/30 bg-slate-900 p-4">
    <div id="qr-reader" class="mx-auto w-full max-w-md overflow-hidden rounded-lg bg-black"></div>
    <p id="qr-scanner-status" class="mt-3 text-center text-sm text-sky-100">{{ __('verify.scanner_starting') }}</p>
    <button type="button" id="qr-scanner-stop" class="mt-3 w-full rounded-lg border border-white/30 py-2 text-sm font-semibold text-white hover:bg-white/10">
        {{ __('verify.scanner_stop') }}
    </button>
</div>

@push('head')
<script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
@endpush

@push('scripts')
<script>
(function () {
    const panel = document.getElementById('qr-scanner-panel');
    const readerEl = document.getElementById('qr-reader');
    const statusEl = document.getElementById('qr-scanner-status');
    const stopBtn = document.getElementById('qr-scanner-stop');
    const startBtn = document.getElementById('qr-scanner-start');
    const manualWrap = document.getElementById('verify-manual-wrap');
    const qrInput = document.getElementById('verify-qr-input');
    const form = document.getElementById('verify-form');

    if (!panel || typeof Html5Qrcode === 'undefined') return;

    let scanner = null;
    let running = false;

    function onDecoded(text) {
        if (!text || running === false) return;
        const decoded = String(text).trim();
        if (qrInput) qrInput.value = decoded;
        stopScanner();
        if (form) form.requestSubmit();
    }

    async function startScanner() {
        if (running) return;
        panel.classList.remove('hidden');
        manualWrap?.classList.add('hidden');
        statusEl.textContent = '{{ __('verify.scanner_active') }}';

        scanner = new Html5Qrcode('qr-reader');
        running = true;

        try {
            await scanner.start(
                { facingMode: 'environment' },
                { fps: 10, qrbox: { width: 260, height: 260 }, aspectRatio: 1 },
                onDecoded,
                () => {}
            );
        } catch (err) {
            running = false;
            statusEl.textContent = '{{ __('verify.scanner_denied') }}';
            panel.classList.add('hidden');
            manualWrap?.classList.remove('hidden');
        }
    }

    async function stopScanner() {
        if (scanner && running) {
            try { await scanner.stop(); await scanner.clear(); } catch (e) {}
        }
        running = false;
        scanner = null;
        panel.classList.add('hidden');
        manualWrap?.classList.remove('hidden');
    }

    startBtn?.addEventListener('click', startScanner);
    stopBtn?.addEventListener('click', stopScanner);

    window.addEventListener('beforeunload', () => { if (running) stopScanner(); });
})();
</script>
@endpush
