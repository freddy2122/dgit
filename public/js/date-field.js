/**
 * Champs date : saisie libre (JJ/MM/AAAA) + sélecteur calendrier natif.
 */
(function () {
    function pad2(n) {
        return String(n).padStart(2, '0');
    }

    function isoToDisplay(iso) {
        if (!iso || !/^\d{4}-\d{2}-\d{2}$/.test(iso)) {
            return '';
        }
        var p = iso.split('-');
        return pad2(p[2]) + '/' + pad2(p[1]) + '/' + p[0];
    }

    function displayToIso(text) {
        if (!text) {
            return '';
        }
        var t = String(text).trim();
        var m;
        if (/^\d{4}-\d{2}-\d{2}$/.test(t)) {
            return t;
        }
        m = t.match(/^(\d{1,2})[\/\-.](\d{1,2})[\/\-.](\d{4})$/);
        if (m) {
            return m[3] + '-' + pad2(m[2]) + '-' + pad2(m[1]);
        }
        m = t.match(/^(\d{1,2})[\/\-.](\d{1,2})[\/\-.](\d{2})$/);
        if (m) {
            var y = parseInt(m[3], 10);
            y += y < 50 ? 2000 : 1900;
            return y + '-' + pad2(m[2]) + '-' + pad2(m[1]);
        }
        return '';
    }

    function isValidIso(iso) {
        if (!/^\d{4}-\d{2}-\d{2}$/.test(iso)) {
            return false;
        }
        var d = new Date(iso + 'T12:00:00');
        return !Number.isNaN(d.getTime());
    }

    function syncFromIso(wrap, iso) {
        var text = wrap.querySelector('[data-date-text]');
        var native = wrap.querySelector('[data-date-native]');
        var hidden = wrap.querySelector('[data-date-value]');
        if (hidden) {
            hidden.value = iso || '';
        }
        if (text) {
            text.value = isoToDisplay(iso);
            text.setAttribute('aria-invalid', iso && !isValidIso(iso) ? 'true' : 'false');
        }
        if (native) {
            native.value = iso || '';
        }
    }

    function initField(wrap) {
        var text = wrap.querySelector('[data-date-text]');
        var native = wrap.querySelector('[data-date-native]');
        var hidden = wrap.querySelector('[data-date-value]');
        var btn = wrap.querySelector('[data-date-picker-btn]');
        if (!text || !hidden) {
            return;
        }

        var initial = hidden.value || (native ? native.value : '') || text.getAttribute('data-initial-iso') || '';
        if (initial) {
            syncFromIso(wrap, initial);
        }

        text.addEventListener('input', function () {
            var iso = displayToIso(text.value);
            if (iso && isValidIso(iso)) {
                syncFromIso(wrap, iso);
            } else if (!text.value.trim()) {
                syncFromIso(wrap, '');
            } else {
                hidden.value = '';
                if (native) {
                    native.value = '';
                }
            }
        });

        text.addEventListener('blur', function () {
            var iso = displayToIso(text.value);
            if (iso && isValidIso(iso)) {
                syncFromIso(wrap, iso);
            }
        });

        if (native) {
            native.addEventListener('change', function () {
                syncFromIso(wrap, native.value || '');
            });
        }

        if (btn && native) {
            btn.addEventListener('click', function () {
                if (typeof native.showPicker === 'function') {
                    native.showPicker();
                } else {
                    native.focus();
                    native.click();
                }
            });
        }
    }

    function initAll() {
        document.querySelectorAll('[data-date-field]').forEach(initField);
        document.querySelectorAll('form').forEach(function (form) {
            form.addEventListener('submit', function () {
                form.querySelectorAll('[data-date-field]').forEach(function (wrap) {
                    var text = wrap.querySelector('[data-date-text]');
                    if (text) {
                        var iso = displayToIso(text.value);
                        if (iso && isValidIso(iso)) {
                            syncFromIso(wrap, iso);
                        }
                    }
                });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initAll);
    } else {
        initAll();
    }
})();
