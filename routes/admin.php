<?php

use App\Http\Controllers\Admin\AdminApplicationController;
use App\Http\Controllers\Admin\AdminAppointmentController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminDocumentController;
use App\Http\Controllers\Admin\AdminLogController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminPermitController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminVehicleController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/utilisateurs', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/utilisateurs/nouveau', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/utilisateurs/nouveau', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/utilisateurs/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::get('/utilisateurs/{user}/permis-digital', [AdminUserController::class, 'licenseDigital'])->name('users.license_digital');
    Route::post('/utilisateurs/{user}/permis', [AdminUserController::class, 'updateLicense'])->name('users.update_license');
    Route::post('/utilisateurs/{user}/points', [AdminUserController::class, 'adjustPoints'])->name('users.adjust_points');
    Route::post('/utilisateurs/{user}/code', [AdminUserController::class, 'regenerateCode'])->name('users.regenerate_code');
    Route::post('/utilisateurs/{user}/mot-de-passe', [AdminUserController::class, 'updatePassword'])->name('users.update_password');
    Route::post('/utilisateurs/{user}/vehicules', [AdminUserController::class, 'storeVehicle'])->name('users.store_vehicle');
    Route::delete('/utilisateurs/{user}/vehicules/{vehicle}', [AdminUserController::class, 'destroyVehicle'])->name('users.destroy_vehicle');
    Route::post('/utilisateurs/{user}/documents', [AdminUserController::class, 'uploadDocuments'])->name('users.upload_documents');
    Route::get('/utilisateurs/{user}/documents/{type}', [AdminUserController::class, 'document'])
        ->where('type', 'recto|verso|signature')
        ->name('users.document');

    Route::get('/permis', [AdminPermitController::class, 'index'])->name('permits.index');

    Route::get('/demandes', [AdminApplicationController::class, 'index'])->name('applications.index');
    Route::get('/demandes/nouveau', [AdminApplicationController::class, 'create'])->name('applications.create');
    Route::post('/demandes/nouveau', [AdminApplicationController::class, 'store'])->name('applications.store');
    Route::get('/demandes/{application}', [AdminApplicationController::class, 'show'])->name('applications.show');
    Route::post('/demandes/{application}/paiement/{payment}', [AdminApplicationController::class, 'confirmPayment'])->name('applications.confirm_payment');
    Route::post('/demandes/{application}/avancer', [AdminApplicationController::class, 'advanceStatus'])->name('applications.advance');
    Route::post('/demandes/{application}/examen', [AdminApplicationController::class, 'updateExam'])->name('applications.update_exam');
    Route::post('/demandes/{application}/valider', [AdminApplicationController::class, 'approve'])->name('applications.validate');
    Route::post('/demandes/{application}/refuser', [AdminApplicationController::class, 'reject'])->name('applications.reject');

    Route::get('/vehicules', [AdminVehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/paiements', [AdminPaymentController::class, 'index'])->name('payments.index');
    Route::post('/paiements', [AdminPaymentController::class, 'store'])->name('payments.store');
    Route::post('/paiements/{payment}/confirmer', [AdminPaymentController::class, 'confirm'])->name('payments.confirm');
    Route::delete('/paiements/{payment}', [AdminPaymentController::class, 'destroy'])->name('payments.destroy');
    Route::post('/utilisateurs/{user}/taxes', [AdminPaymentController::class, 'store'])->name('users.store_tax');
    Route::get('/documents', [AdminDocumentController::class, 'index'])->name('documents.index');
    Route::get('/rendez-vous', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::get('/logs', [AdminLogController::class, 'index'])->name('logs.index');
    Route::get('/parametres', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::post('/parametres', [AdminSettingsController::class, 'update'])->name('settings.update');
});
