@props(['id' => 'app-nav'])
<script>
(() => {
    const drawer = document.getElementById(@json($id.'-drawer'));
    const openBtn = document.getElementById(@json($id.'-open'));
    if (!drawer || !openBtn) return;

    const panel = drawer.querySelector('[data-mobile-nav-panel]');
    const closeEls = drawer.querySelectorAll('[data-mobile-nav-close]');

    const setOpen = (open) => {
        drawer.classList.toggle('hidden', !open);
        drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
        openBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.classList.toggle('overflow-hidden', open);
    };

    openBtn.addEventListener('click', () => setOpen(true));
    closeEls.forEach((el) => el.addEventListener('click', () => setOpen(false)));
    drawer.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setOpen(false)));

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !drawer.classList.contains('hidden')) setOpen(false);
    });
})();
</script>
