<?php

use Illuminate\Support\Str;

if (! function_exists('portal_default_locale')) {
    function portal_default_locale(): string
    {
        $locale = config('portal.default_locale', 'fr');

        return in_array($locale, ['es', 'fr'], true) ? $locale : 'fr';
    }
}

if (! function_exists('portal_locale')) {
    function portal_locale(): string
    {
        $locale = app()->getLocale();

        return in_array($locale, ['es', 'fr'], true) ? $locale : portal_default_locale();
    }
}

if (! function_exists('portal_route_locale')) {
    function portal_route_locale(): string
    {
        $locale = request()->route('locale') ?? request()->segment(1);

        if (in_array($locale, ['es', 'fr'], true)) {
            return $locale;
        }

        return portal_locale();
    }
}

if (! function_exists('portal_route')) {
    /**
     * Génère une route préfixée /es ou /fr (évite les URLs cassées sans paramètre locale).
     */
    function portal_route(string $name, array $parameters = [], bool $absolute = true): string
    {
        if (! array_key_exists('locale', $parameters)) {
            $parameters['locale'] = portal_route_locale();
        }

        return route($name, $parameters, $absolute);
    }
}

if (! function_exists('locale_path_segments')) {
    /**
     * Segments de chemin utiles pour la redirection après changement de langue.
     *
     * @return list<string>
     */
    function locale_path_segments(): array
    {
        $return = request()->input('_return');
        if (is_string($return) && str_starts_with($return, '/')) {
            $path = parse_url($return, PHP_URL_PATH) ?? $return;
        } else {
            $referer = request()->headers->get('referer');
            $path = $referer ? (parse_url($referer, PHP_URL_PATH) ?? '/') : '/'.request()->path();
        }
        $segments = array_values(array_filter(explode('/', trim((string) $path, '/'))));

        // POST /es/locale ou /fr/locale : ne pas garder le segment « locale »
        if (($segments[1] ?? null) === 'locale' && in_array($segments[0] ?? '', ['es', 'fr'], true)) {
            $segments = [$segments[0]];
        }

        return $segments;
    }
}

if (! function_exists('locale_switch_url')) {
    function locale_switch_url(string $targetLocale): string
    {
        if (! in_array($targetLocale, ['es', 'fr'], true)) {
            $targetLocale = 'es';
        }

        $segments = locale_path_segments();

        if (in_array($segments[0] ?? '', ['es', 'fr'], true)) {
            $segments[0] = $targetLocale;
        } else {
            array_unshift($segments, $targetLocale);
        }

        if ($segments === [$targetLocale]) {
            return '/'.$targetLocale;
        }

        $url = '/'.implode('/', $segments);

        $return = request()->input('_return');
        if (is_string($return) && str_contains($return, '?')) {
            $url .= '?'.(parse_url($return, PHP_URL_QUERY) ?? '');
        } elseif (($referer = request()->headers->get('referer')) && ($query = parse_url($referer, PHP_URL_QUERY))) {
            $url .= '?'.$query;
        }

        return $url;
    }
}

if (! function_exists('dgt_is_external')) {
    function dgt_is_external(?string $raw): bool
    {
        return (bool) ($raw && preg_match('#\Ahttps?://#i', $raw));
    }
}

if (! function_exists('dgt_href_is_internal')) {
    /** Chemins gérés sur ce portail (Sede / MiDGT), pas sur www.dgt.es. */
    function dgt_href_is_internal(?string $url): bool
    {
        if ($url === null || $url === '' || $url === '#') {
            return false;
        }
        if (dgt_is_external($url)) {
            return false;
        }

        $path = trim($url, '/');

        return $path === 'midgt'
            || str_starts_with($path, 'midgt/')
            || $path === 'es'
            || str_starts_with($path, 'es/');
    }
}

if (! function_exists('dgt_href')) {
    /**
     * Lien Sede/MiDGT en local ; chemins dgt.es → site officiel (pas de miroir local).
     */
    function dgt_href(?string $url): string
    {
        if ($url === null || $url === '' || $url === '#') {
            return '#';
        }
        if (dgt_is_external($url)) {
            return $url;
        }

        $path = trim($url, '/');

        if ($path === 'midgt' || str_starts_with($path, 'midgt/')) {
            return portal_route('midgt.index');
        }

        if ($path === 'es' || str_starts_with($path, 'es/')) {
            return sede_href($path);
        }

        return $path === '' ? portal_route('home') : sede_href($path);
    }
}

if (! function_exists('site_href')) {
    /**
     * Lien interne Sede, DGT ou MiDGT selon le chemin ou le flag dgt.
     *
     * @param  array{path?: string, dgt?: bool, route?: string}|string  $target
     */
    function site_href(array|string $target): string
    {
        if (is_string($target)) {
            return dgt_href($target);
        }

        if (! empty($target['route'])) {
            return portal_route($target['route']);
        }

        $path = $target['path'] ?? '#';

        if (! empty($target['dgt'])) {
            return dgt_href($path);
        }

        if ($path === 'midgt') {
            return portal_route('midgt.index');
        }

        return sede_href($path);
    }
}

if (! function_exists('dgt_official_url')) {
    /**
     * URL canonique sur www.dgt.es (mismo path que en local).
     */
    function dgt_official_url(string $path = ''): string
    {
        $path = ltrim($path, '/');

        return $path === '' ? portal_route('home') : sede_href($path);
    }
}

if (! function_exists('dgt_menu_label')) {
    /**
     * Libellé affiché (FR si fourni, sinon ES).
     *
     * @param  array<string, mixed>  $item
     */
    function dgt_menu_label(array $item): string
    {
        return portal_locale() === 'es'
            ? (string) ($item['label'] ?? $item['label_fr'] ?? '')
            : (string) ($item['label_fr'] ?? $item['label'] ?? '');
    }
}

if (! function_exists('sede_normalize_path')) {
    function sede_normalize_path(string $path): string
    {
        $path = trim($path, '/');
        $path = preg_replace('#/index\.html$#i', '', $path) ?? $path;

        return $path === '' ? '' : trim($path, '/');
    }
}

if (! function_exists('sede_official_url')) {
    function sede_official_url(string $path = ''): string
    {
        return sede_href($path);
    }
}

if (! function_exists('portal_local_route_for_sede_path')) {
    /**
     * Route Laravel locale pour un chemin Sede (ex. suivi permis → licence.status).
     */
    function portal_local_route_for_sede_path(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        $normalized = sede_normalize_path($path);
        $map = config('dgt_portal_local', []);

        return is_string($map[$normalized] ?? null) ? $map[$normalized] : null;
    }
}

if (! function_exists('sede_href')) {
    /**
     * Lien vers le service portail local si mappé, sinon /sede/… (miroir interne).
     */
    function sede_href(?string $path): string
    {
        if ($path === null || $path === '' || $path === '#') {
            return '#';
        }
        if (dgt_is_external($path)) {
            return portal_route('home');
        }

        $path = trim($path, '/');

        $localRoute = portal_local_route_for_sede_path($path);
        if ($localRoute) {
            return portal_route($localRoute);
        }

        return $path === '' ? portal_route('sede.page', ['path' => 'es']) : portal_route('sede.page', ['path' => $path]);
    }
}

if (! function_exists('clave_plataforma_href')) {
    /** Inscription Cl@ve — accès direct (sans hub plataforma). */
    function clave_plataforma_href(): string
    {
        return portal_route('clave.inscripcion');
    }
}

if (! function_exists('clave_registro_href')) {
    function clave_registro_href(): string
    {
        return portal_route('clave.inscripcion');
    }
}

if (! function_exists('clave_conectar_href')) {
    function clave_conectar_href(array $query = []): string
    {
        return portal_route('clave.conectar', $query);
    }
}

if (! function_exists('sede_identificacion_href')) {
    /** Identification Sede DGT (capture 2). */
    function sede_identificacion_href(): string
    {
        return sede_href((string) config('dgt_acceso.sede_identificacion', 'es/acceso'));
    }
}

if (! function_exists('midgt_acceso_href')) {
    /** Page login (invité) ou tableau de bord (connecté). */
    function midgt_acceso_href(): string
    {
        if (auth()->check()) {
            return portal_route('dashboard');
        }

        return portal_route('login');
    }
}

if (! function_exists('sede_locale')) {
    function sede_locale(): string
    {
        $locale = app()->getLocale();

        return in_array($locale, ['es', 'fr'], true) ? $locale : 'es';
    }
}

if (! function_exists('sede_path_key')) {
    function sede_path_key(?string $path): string
    {
        return str_replace('/', '_', sede_normalize_path($path ?? ''));
    }
}

if (! function_exists('sede_nav_label')) {
    function sede_nav_label(array $item): string
    {
        $key = 'sede.nav.'.sede_path_key($item['path'] ?? '');
        $translated = __($key);

        if ($translated !== $key) {
            return $translated;
        }

        return sede_locale() === 'es'
            ? (string) ($item['label_es'] ?? $item['label_fr'] ?? $item['label'] ?? '')
            : (string) ($item['label_fr'] ?? $item['label'] ?? '');
    }
}

if (! function_exists('sede_link_label')) {
    function sede_link_label(array $link): string
    {
        $key = 'sede.nav.'.sede_path_key($link['path'] ?? '');
        $translated = __($key);

        if ($translated !== $key) {
            return $translated;
        }

        return sede_locale() === 'es'
            ? (string) ($link['label_es'] ?? $link['label'] ?? $link['label_fr'] ?? '')
            : (string) ($link['label_fr'] ?? $link['label'] ?? '');
    }
}

if (! function_exists('sede_page_title_localized')) {
    function sede_page_title_localized(array $page): string
    {
        return sede_locale() === 'es'
            ? (string) ($page['title'] ?? $page['title_fr'] ?? '')
            : (string) ($page['title_fr'] ?? $page['title'] ?? '');
    }
}

if (! function_exists('sede_page_field')) {
    /**
     * @return string|list<string>|null
     */
    function sede_page_field(array $page, string $field): string|array|null
    {
        $pathKey = sede_path_key($page['path'] ?? '');
        $langKey = "sede.content.{$pathKey}.{$field}";
        $fromLang = trans($langKey);

        if ($fromLang !== $langKey) {
            return $fromLang;
        }

        $localizedKey = $field.'_'.sede_locale();
        if (array_key_exists($localizedKey, $page)) {
            return $page[$localizedKey];
        }

        if (array_key_exists($field, $page)) {
            return $page[$field];
        }

        return null;
    }
}

if (! function_exists('sede_page_list_field')) {
    /**
     * @return list<string>
     */
    function sede_page_list_field(array $page, string $field): array
    {
        $value = sede_page_field($page, $field);

        if (is_array($value)) {
            return array_values(array_filter(array_map('strval', $value)));
        }

        return $value ? [(string) $value] : [];
    }
}

if (! function_exists('sede_tramite_action')) {
    /**
     * Démarrage d’un trámite DGT en base (note dynamique + paiements).
     *
     * @return array{method: string, href: string, label: string, hidden?: array<string, string>}|null
     */
    function sede_tramite_action(?string $path): ?array
    {
        if ($path === null || $path === '') {
            return null;
        }

        $service = app(\App\Services\PermitTramiteService::class);
        $type = $service->typeForPath($path);

        if ($type === null) {
            return null;
        }

        if (! config('gestoria.client_can_start_tramite', false)) {
            return [
                'method' => 'get',
                'href' => gestoria_whatsapp_url(__('tramite.whatsapp_sede_message', ['type' => $service->typeLabel($type)])),
                'label' => __('tramite.btn_contact_gestoria'),
                'external' => true,
            ];
        }

        $label = __('tramite.btn_start', ['type' => $service->typeLabel($type)]);

        if (! auth()->check()) {
            return [
                'method' => 'get',
                'href' => portal_route('login'),
                'label' => __('tramite.btn_start_guest'),
            ];
        }

        return [
            'method' => 'post',
            'href' => portal_route('portal.tramite.start'),
            'label' => $label,
            'hidden' => ['sede_path' => sede_normalize_path($path)],
        ];
    }
}

if (! function_exists('gestoria_whatsapp_number')) {
    function gestoria_whatsapp_number(): string
    {
        return app(\App\Services\PortalSettingsService::class)->whatsappNumber();
    }
}

if (! function_exists('gestoria_whatsapp_url')) {
    function gestoria_whatsapp_url(?string $message = null): string
    {
        $number = gestoria_whatsapp_number();
        $base = 'https://wa.me/'.$number;

        if ($message === null || $message === '') {
            return $base;
        }

        return $base.'?text='.rawurlencode($message);
    }
}

if (! function_exists('gestoria_whatsapp_payment_message')) {
    function gestoria_whatsapp_payment_message(\App\Models\PortalPayment $payment): string
    {
        return __('tramite.whatsapp_payment_message', [
            'ref' => $payment->reference,
            'amount' => number_format((float) $payment->amount, 2, ',', ' '),
            'label' => $payment->label,
            'dossier' => $payment->user?->dossier_number ?? '—',
        ]);
    }
}

if (! function_exists('sede_local_service')) {
    /**
     * Bouton d’accès au trámite simulé sur ce portail (si configuré).
     *
     * @return array{href: string, label: string}|null
     */
    function sede_local_service(?string $path): ?array
    {
        if ($path === null || $path === '') {
            return null;
        }

        $key = 'sede.services.'.sede_path_key($path);
        $cfg = trans($key);

        if (! is_array($cfg) || empty($cfg['route'])) {
            return null;
        }

        $needsAuth = (bool) ($cfg['auth'] ?? false);

        if ($needsAuth && ! auth()->check()) {
            $routeName = $cfg['route_guest'] ?? 'login';
            $label = (string) ($cfg['btn_guest'] ?? __('sede.page.login_to_continue'));

            return ['href' => portal_route($routeName), 'label' => $label];
        }

        return [
            'href' => portal_route($cfg['route']),
            'label' => (string) ($cfg['btn'] ?? __('sede.page.start_tramite')),
        ];
    }
}

if (! function_exists('sede_procedure_groups')) {
    /**
     * @return list<array{group: string, items: list<array<string, string>>}>
     */
    function sede_procedure_groups(array $page): array
    {
        $key = 'sede.procedures.'.sede_path_key($page['path'] ?? '');
        $groups = trans($key);

        return is_array($groups) ? $groups : [];
    }
}

if (! function_exists('sede_procedure_href')) {
    function sede_procedure_href(array $item): string
    {
        if (! empty($item['path'])) {
            return sede_href($item['path']);
        }

        if (! empty($item['official'])) {
            return sede_href($item['official']);
        }

        return '#';
    }
}

if (! function_exists('sede_procedure_is_official')) {
    function sede_procedure_is_official(array $item): bool
    {
        return empty($item['path']) && ! empty($item['official']);
    }
}

if (! function_exists('sede_page_title')) {
    function sede_page_title(string $path): string
    {
        $resolved = sede_resolve_page($path);
        if ($resolved) {
            return sede_page_title_localized($resolved);
        }

        $slug = basename(str_replace('\\', '/', sede_normalize_path($path))) ?: $path;

        return Str::headline(str_replace(['-', '_'], ' ', $slug));
    }
}

if (! function_exists('sede_pages_registry')) {
    /**
     * @return array<string, array<string, mixed>>
     */
    function sede_pages_registry(): array
    {
        static $registry = null;

        if ($registry !== null) {
            return $registry;
        }

        $registry = [];
        foreach (config('dgt_sede_pages', []) as $key => $page) {
            $norm = is_string($key) ? sede_normalize_path($key) : sede_normalize_path($page['path'] ?? '');
            if ($norm !== '') {
                $registry[$norm] = $page;
            }
        }

        return $registry;
    }
}

if (! function_exists('sede_resolve_page')) {
    /**
     * @return array<string, mixed>|null
     */
    function sede_resolve_page(string $path): ?array
    {
        $normalized = sede_normalize_path($path);

        if ($normalized === 'midgt') {
            return sede_pages_registry()['midgt'] ?? null;
        }

        return sede_pages_registry()[$normalized] ?? null;
    }
}

if (! function_exists('sede_nav_tree_with_hrefs')) {
    /**
     * @param  array<int, array<string, mixed>>  $items
     * @return array<int, array<string, mixed>>
     */
    function sede_nav_tree_with_hrefs(array $items): array
    {
        $map = function (array $node) use (&$map): array {
            $out = [
                'label_fr' => sede_nav_label($node),
                'href' => site_href($node),
                'external' => false,
            ];
            if (! empty($node['children'])) {
                $out['children'] = array_map($map, $node['children']);
            }

            return $out;
        };

        return array_map($map, $items);
    }
}

if (! function_exists('dgt_nav_tree_with_hrefs')) {
    /**
     * Arbre menu avec href résolus (pour le méga-menu JS).
     *
     * @param  array<int, array<string, mixed>>  $items
     * @return array<int, array<string, mixed>>
     */
    function dgt_nav_tree_with_hrefs(array $items): array
    {
        $map = function (array $node) use (&$map): array {
            $u = $node['url'] ?? '#';
            $out = [
                'label' => $node['label'] ?? '',
                'label_fr' => $node['label_fr'] ?? null,
                'label_display' => dgt_menu_label($node),
                'href' => dgt_href($u),
                'external' => ! dgt_href_is_internal($u),
            ];
            if (! empty($node['children'])) {
                $out['children'] = array_map($map, $node['children']);
            }

            return $out;
        };

        return array_map($map, $items);
    }
}

if (! function_exists('permit_status_label')) {
    function permit_status_label(?string $status): string
    {
        if (! $status) {
            return '—';
        }

        $key = 'status.labels.'.$status;

        return __($key) !== $key ? __($key) : (string) $status;
    }
}

if (! function_exists('permit_status_fr')) {
    /** @deprecated Utiliser permit_status_label() */
    function permit_status_fr(?string $status): string
    {
        return permit_status_label($status);
    }
}

if (! function_exists('payment_status_label')) {
    function payment_status_label(?string $status): string
    {
        if (! $status) {
            return '—';
        }

        $key = 'admin.payment_status.'.$status;

        return __($key) !== $key ? __($key) : (string) $status;
    }
}
