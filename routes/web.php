<?php

use App\Http\Controllers\ClaveAuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentVerifyController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LicenceDigitalController;
use App\Http\Controllers\LicenceQrController;
use App\Http\Controllers\LicencePointsController;
use App\Http\Controllers\LicenceStatusController;
use App\Http\Controllers\MidgtController;
use App\Http\Controllers\MidgtDashboardController;
use App\Http\Controllers\MultasController;
use App\Http\Controllers\PermisGuideController;
use App\Http\Controllers\PortalDemarchesController;
use App\Http\Controllers\PortalLocaleController;
use App\Http\Controllers\PortalPageController;
use App\Http\Controllers\PortalPhotoController;
use App\Http\Controllers\PortalRegistrationController;
use App\Http\Controllers\PortalTramiteController;
use App\Http\Controllers\SedeHubController;
use App\Http\Controllers\SedeMirrorController;
use App\Http\Controllers\SessionLoginController;
use App\Http\Controllers\TaxesController;
use App\Http\Controllers\VehicleReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;

/*
|--------------------------------------------------------------------------
| Web Routes — préfixe locale /es ou /fr
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->middleware('web')
    ->name('admin.')
    ->group(base_path('routes/admin.php'));

Route::get('/', function (Request $request) {
    $locale = $request->session()->get('portal_locale', portal_default_locale());
    if (! in_array($locale, ['es', 'fr'], true)) {
        $locale = portal_default_locale();
    }
    $request->session()->put('portal_locale', $locale);

    if (auth()->check()) {
        return redirect()->route('dashboard', ['locale' => $locale]);
    }

    return redirect()->route('home', ['locale' => $locale]);
});

Route::prefix('{locale}')
    ->where(['locale' => 'es|fr'])
    ->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');

        Route::get('/locale', fn (string $locale) => redirect("/{$locale}"));
        Route::post('/locale', [PortalLocaleController::class, 'update'])->name('portal.locale');

        Route::get('/sede', [SedeHubController::class, 'index'])->name('sede.hub');

        Route::get('/permis', [PermisGuideController::class, 'index'])->name('permis.index');
        Route::get('/permis/status', fn () => redirect()->route('licence.status'))->name('permis.status');
        Route::get('/permis/points', fn () => redirect()->route('licence.points'))->name('permis.points');
        Route::get('/permis/{slug}', [PermisGuideController::class, 'page'])
            ->where('slug', 'nouveau|renouvellement|canje|changement-adresse|duplicata|suivi|international')
            ->name('permis.page');

        Route::get('/vehicules', fn () => redirect()->route('vehicles.report'));
        Route::get('/vehicules/report', fn () => redirect()->route('vehicles.report'));
        Route::get('/vehicules/details', fn () => redirect()->route('vehicles.details'));
        Route::get('/rendez-vous', function () {
            return auth()->check()
                ? redirect()->route('portal.appointments')
                : redirect()->route('midgt.index');
        })->name('rendez-vous');
        Route::get('/clave', [ClaveAuthController::class, 'redirectRoot']);
        Route::get('/clave/conectar', [ClaveAuthController::class, 'showConnect'])->name('clave.conectar');
        Route::post('/clave/conectar', [ClaveAuthController::class, 'connect'])
            ->middleware('throttle:login')
            ->name('clave.conectar.submit');
        Route::get('/clave/inscripcion', [ClaveAuthController::class, 'showInscripcion'])->name('clave.inscripcion');
        Route::post('/clave/inscripcion', [ClaveAuthController::class, 'submitInscripcion'])->name('clave.inscripcion.submit');

        Route::get('/midgt', [MidgtController::class, 'index'])->name('midgt.index');
        Route::get('/midgt/mon-espace', [MidgtDashboardController::class, 'index'])
            ->middleware('auth')
            ->name('midgt.espace');

        Route::middleware('auth')->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
            Route::get('/licence/points', [LicencePointsController::class, 'show'])->name('licence.points');
            Route::get('/licence/digital', [LicenceDigitalController::class, 'show'])->name('licence.digital');
            Route::get('/licence/qr', [LicenceQrController::class, 'show'])->name('licence.qr');
            Route::post('/licence/qr/generate', [LicenceQrController::class, 'generate'])->name('licence.qr.generate');
            Route::get('/dashboard/demarches', [PortalDemarchesController::class, 'index'])->name('portal.demarches');
            Route::get('/dashboard/paiements', [PortalPageController::class, 'payments'])->name('portal.payments');
            Route::post('/dashboard/paiements/payer', [PortalPageController::class, 'pay'])->name('portal.payments.pay');
            Route::get('/dashboard/rendez-vous', [PortalPageController::class, 'appointments'])->name('portal.appointments');
            Route::post('/dashboard/rendez-vous', [PortalPageController::class, 'storeAppointment'])->name('portal.appointments.store');
            Route::get('/dashboard/notificaciones', [PortalPageController::class, 'notifications'])->name('portal.notifications');
            Route::get('/dashboard/profil', [PortalPageController::class, 'profile'])->name('portal.profile');
            Route::post('/dashboard/profil/documents', [PortalPageController::class, 'storeDocuments'])->name('portal.profile.documents');
            Route::post('/dashboard/profil/password', [PortalPageController::class, 'updatePassword'])->name('portal.profile.password');
            Route::get('/portal/id-photo', [PortalPhotoController::class, 'show'])->name('portal.id-photo');
            Route::get('/portal/signature', [PortalPhotoController::class, 'signature'])->name('portal.signature');
            Route::get('/portal/document/{type}', [PortalPhotoController::class, 'document'])
                ->where('type', 'license_photo|recto|verso|signature')
                ->name('portal.document');
            Route::get('/vehicles/report', [VehicleReportController::class, 'index'])->name('vehicles.report');
            Route::get('/vehicles/details/{vehicle?}', [VehicleReportController::class, 'show'])->name('vehicles.details');
            Route::get('/multas', [MultasController::class, 'index'])->name('multas.index');
            Route::post('/multas/payer', [MultasController::class, 'pay'])->name('multas.pay');
            Route::get('/multas/paiement', fn () => redirect()->route('multas.index'));
            Route::get('/multas/recours', [MultasController::class, 'appeal'])->name('multas.appeal');
            Route::post('/multas/recours', [MultasController::class, 'storeAppeal'])->name('multas.appeal.store');
            Route::get('/taxes', [TaxesController::class, 'index'])->name('taxes.index');
            Route::get('/taxes/pay', [TaxesController::class, 'pay'])->name('taxes.pay');
            Route::post('/taxes/pay', [TaxesController::class, 'processPay'])->name('taxes.pay.submit');
            Route::get('/taxes/receipt', [TaxesController::class, 'receipt'])->name('taxes.receipt');

            Route::post('/tramites/demarrer', [PortalTramiteController::class, 'start'])->name('portal.tramite.start');
            Route::get('/tramites/dossier/{application}', [PortalTramiteController::class, 'show'])->name('portal.tramite.show');
            Route::post('/tramites/dossier/{application}/ameliorer-note', [PortalTramiteController::class, 'payScore'])->name('portal.tramite.pay_score');
            Route::post('/tramites/dossier/{application}/payer-tasa', [PortalTramiteController::class, 'payFee'])->name('portal.tramite.pay_fee');
        });

        Route::get('/licence/status', [LicenceStatusController::class, 'create'])->name('licence.status');
        Route::post('/licence/status', [LicenceStatusController::class, 'store'])
            ->middleware('throttle:licence-status')
            ->name('licence.status.search');
        Route::get('/licence/status/photo', [LicenceStatusController::class, 'photo'])->name('licence.status.photo');

        Route::get('/documents/verify', [DocumentVerifyController::class, 'show'])->name('documents.verify');
        Route::get('/documents/verify/photo', [DocumentVerifyController::class, 'photo'])->name('documents.verify.photo');
        Route::post('/documents/verify', [DocumentVerifyController::class, 'verify'])
            ->middleware('throttle:verify')
            ->name('documents.verify.submit');

        Route::middleware('guest')->group(function () {
            Route::get('/login', [SessionLoginController::class, 'create'])->name('login');
            Route::post('/login', [SessionLoginController::class, 'store'])->middleware('throttle:login');
            Route::get('/password/forgot', [ForgotPasswordController::class, 'create'])->name('password.forgot');
            Route::post('/password/forgot', [ForgotPasswordController::class, 'sendCode'])
                ->middleware('throttle:6,1')
                ->name('password.forgot.send');
            Route::get('/password/reset', [ForgotPasswordController::class, 'showReset'])->name('password.reset.form');
            Route::post('/password/reset', [ForgotPasswordController::class, 'reset'])
                ->middleware('throttle:10,1')
                ->name('password.reset');
        });

        Route::post('/logout', [SessionLoginController::class, 'destroy'])->middleware('auth')->name('logout');

        Route::get('/inscription', [PortalRegistrationController::class, 'showInscription'])->name('portal.inscription');
        Route::post('/inscription', [PortalRegistrationController::class, 'chooseMethod'])->name('portal.inscription.choose');
        Route::get('/registration/identity', [PortalRegistrationController::class, 'showIdentity'])->name('portal.identity');
        Route::post('/registration/identity', [PortalRegistrationController::class, 'storeIdentity'])->name('portal.identity.store');
        Route::get('/verify-code', [PortalRegistrationController::class, 'showVerify'])->name('portal.verify');
        Route::post('/verify-code', [PortalRegistrationController::class, 'verifyCode'])->name('portal.verify.submit');
        Route::get('/registration/complete', [PortalRegistrationController::class, 'showComplete'])->name('portal.complete');
        Route::post('/registration/complete', [PortalRegistrationController::class, 'complete'])->name('portal.complete.store');
        Route::get('/activate/{token}', [PortalRegistrationController::class, 'activate'])->name('portal.activate');

        Route::get('sede/{path}', [SedeMirrorController::class, 'show'])
            ->where('path', '.*')
            ->name('sede.page');
    });

/*
| Anciennes URL sans /es ou /fr → redirection automatique
*/
Route::fallback(function (Request $request) {
    if (in_array($request->segment(1), ['es', 'fr'], true)) {
        abort(404);
    }

    $locale = $request->session()->get('portal_locale', portal_default_locale());
    if (! in_array($locale, ['es', 'fr'], true)) {
        $locale = portal_default_locale();
    }

    $path = trim($request->path(), '/');
    $target = $path === '' ? "/{$locale}" : "/{$locale}/{$path}";

    if ($query = $request->getQueryString()) {
        $target .= '?'.$query;
    }

    return redirect($target, 302);
})->middleware('web');
