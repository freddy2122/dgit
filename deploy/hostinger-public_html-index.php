<?php

/**
 * À placer dans public_html du sous-domaine UNIQUEMENT si vous ne pouvez pas
 * définir la racine web sur le dossier /public dans hPanel.
 *
 * Structure Hostinger :
 *   /domains/votre-sous-domaine.com/     ← racine du dépôt FTP (FTP_REMOTE_DIR)
 *       app/, bootstrap/, vendor/, …
 *       public_html/                     ← copier le contenu de /public ici
 *           index.php                    ← ce fichier (renommé depuis ce modèle)
 *           .htaccess
 *           build/
 */

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../vendor/autoload.php';

$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
