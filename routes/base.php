<?php

use App\Enums\PermissionsEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CvController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\ScholarshipController;
use App\Http\Controllers\AgoraSessionController;
use App\Http\Controllers\Base\BaseController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\TopUniversityController;
use App\Http\Controllers\LocalUniversityController;
use App\Http\Controllers\EntrepreneurGuideController;
use App\Http\Controllers\UserProfessionalLinkController;

require __DIR__ . '/auth.php';

// Routes pour les filtres
Route::resource('filter', FilterController::class)->only([
    'index',
    'store',
]);
Route::patch('/filter', [FilterController::class, 'reset'])->name('filter.reset');

Route::middleware('auth')->group(function () {

    Route::controller(BaseController::class)->group(function () {
        Route::get('/account', 'account')->name('account');
        Route::get('/settings', 'settings')->name('settings');
        Route::get('/profil', 'profil')->name('profil');
    });

    // Routes pour l'utilisateur
    Route::prefix('user')->as('user.')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/me', 'me')->name('me');
            Route::get('/sessions', 'sessions')->name('sessions');

            Route::put('/info/{user}', 'updateInfo')->name('info.update');
            Route::put('/account/{user}', 'updateAccount')->name('account.update');

            Route::get('/permissions', 'permissions')->name('permissions');
            Route::patch('/permissions/{user}', 'updatePermissions')->name('permissions.update');
            Route::get('/roles', 'roles')->name('roles');
            Route::patch('/roles/{user}', 'updateRoles')->name('roles.update');

            Route::post('/invite', 'invite')->name('invite');
        });

        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    });
    Route::resource('user', UserController::class)->only([
        'index',
        'show',
        'update',
        'destroy',
    ]);

    Route::controller(NotificationController::class)->group(function () {
        Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.delete');
        Route::post('/notifications/archive', [NotificationController::class, 'archiveAll'])->name('notifications.archiveAll');
        Route::post('/notifications/read', [NotificationController::class, 'readAll'])->name('notifications.readAll');
    });

    // Routes pour la faq
    Route::resource(
        'faq',
        FaqController::class
    )->only([
        'index',
        'show',
    ]);

    // Routes pour les sessions d'agora
    Route::resource('agora-session', AgoraSessionController::class)->only([
        'index',
        'show',
    ]);

    // Routes pour les sondages
    Route::resource('poll', PollController::class)->only([
        'index',
        'show',
    ]);

    // Routes pour les offres d'emploi
    Route::resource('job', JobOfferController::class)->only([
        'store',
        'update',
        'destroy',
    ])->middleware(['can:' . PermissionsEnum::MANAGE_JOB_OFFERS->value]);

    // Routes pour les formations
    Route::resource('training', TrainingController::class)->only([
        'store',
        'update',
        'destroy',
    ])->middleware(['can:' . PermissionsEnum::MANAGE_TRAININGS->value]);

    // Routes pour les CVs
    Route::resource('cvs', CvController::class);

    // Routes pour les bourses
    Route::resource('scholarships', ScholarshipController::class)->middleware(['can:' . PermissionsEnum::MANAGE_SCHOLARSHIPS->value]);

    // Routes pour les appels d'offres
    Route::resource('tenders', TenderController::class)->middleware(['can:' . PermissionsEnum::MANAGE_TENDERS->value]);

    // Routes pour les guides entrepreneur
    Route::resource('entrepreneur-guides', EntrepreneurGuideController::class);

    // Routes pour les professionnels
    Route::resource('professionals', ProfessionalController::class);

    // Routes pour les relations utilisateur-professionnel
    Route::resource('user-professional-links', UserProfessionalLinkController::class);

    // Routes pour les universités au Bénin
    Route::resource('local-universities', LocalUniversityController::class);

    // Routes pour les meilleures universités dans le monde
    Route::resource('top-universities', TopUniversityController::class);
});
