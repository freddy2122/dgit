@props(['id' => 'app-nav'])
<script>
document.addEventListener('DOMContentLoaded', function () {
    const drawerId = @json($id.'-drawer');
    const openId = @json($id.'-open');
    const drawer = document.getElementById(drawerId);
    const openBtn = document.getElementById(openId);
    if (!drawer || !openBtn) {
        return;
    }

    const closeEls = drawer.querySelectorAll('[data-mobile-nav-close]');

    const setOpen = function (open) {
        if (open) {
            drawer.classList.remove('hidden');
        } else {
            drawer.classList.add('hidden');
        }
        drawer.setAttribute('aria-hidden', open ? 'false' : 'true');
        openBtn.setAttribute('aria-expanded', open ? 'true' : 'false');
        document.body.classList.toggle('overflow-hidden', open);
    };

    openBtn.addEventListener('click', function (e) {
        e.preventDefault();
        setOpen(true);
    });

    closeEls.forEach(function (el) {
        el.addEventListener('click', function () {
            setOpen(false);
        });
    });

    drawer.querySelectorAll('a').forEach(function (link) {
        link.addEventListener('click', function () {
            setOpen(false);
        });
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !drawer.classList.contains('hidden')) {
            setOpen(false);
        }
    });
});
</script>
