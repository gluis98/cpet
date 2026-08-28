<?php

use App\Http\Controllers\Auth\SetupController;
use App\Http\Controllers\BulkImportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfficerFormController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportesController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/setup', [SetupController::class, 'create'])->name('setup.create');
Route::post('/setup', [SetupController::class, 'store'])->name('setup.store');

Route::middleware('auth')->group(function () {
    Route::get('/perfil', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/perfil/contrasena', [ProfileController::class, 'updatePassword'])->name('profile.password.update');

    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'index')->name('home');
        Route::get('/officers/radiogram/{id}', 'officers_radiogram')->name('officers.radiogram');
        Route::get('/officers/academy/{id}', 'officers_academy')->name('officers.academy');
        Route::get('/officers/courses/{id}', 'officers_courses')->name('officers.courses');
        Route::get('/officers/positions/{id}', 'officers_position')->name('officers.positions');
        Route::get('/officers/familly/{id}', 'officers_familly')->name('officers.familly');
        Route::get('/officers/vacations/{id}', 'officers_vacations')->name('officers.vacations');
        Route::get('/officers/awards/{id}', 'officers_awards')->name('officers.awards');
        Route::get('/officers/health/{id}', 'officers_health')->name('officers.health');
        Route::get('/officers/icap/{id}', 'officers_icap')->name('officers.icap');
        Route::get('/officers/urra/{id}', 'officers_urra')->name('officers.urra');

        Route::get('/stations', 'stations')->name('stations');
        Route::get('/users', 'users')->name('users');
        Route::get('/config/discapacidades', 'config_discapacidades')->name('config.discapacidades');
        Route::get('/config/cursos', 'config_cursos')->name('config.cursos');
        Route::get('/config/cargos', 'config_cargos')->name('config.cargos');
        Route::get('/config/cargos-administrativos', 'config_cargos_administrativos')->name('config.cargos_administrativos');
    });

    Route::get('/officers', fn () => redirect()->route('officers.tipo', 'policial'))->name('officers');

    Route::controller(OfficerFormController::class)->group(function () {
        Route::get('/officers/search', 'search')->name('officers.search');
        Route::get('/officers/ficha/{id}', 'ficha')->name('officers.ficha');
        Route::get('/officers/tipo/{tipo}', 'index')->whereIn('tipo', ['policial', 'administrativo', 'obrero'])->name('officers.tipo');
        // Nombres officers.form.* para no chocar con apiResource officers.* (api/officers)
        Route::get('/officers/tipo/{tipo}/create', 'create')->whereIn('tipo', ['policial', 'administrativo', 'obrero'])->name('officers.form.create');
        Route::post('/officers/tipo/{tipo}', 'store')->whereIn('tipo', ['policial', 'administrativo', 'obrero'])->name('officers.form.store');
        Route::get('/officers/tipo/{tipo}/{id}/edit', 'edit')->whereIn('tipo', ['policial', 'administrativo', 'obrero'])->name('officers.form.edit');
        Route::put('/officers/tipo/{tipo}/{id}', 'update')->whereIn('tipo', ['policial', 'administrativo', 'obrero'])->name('officers.form.update');
    });

    Route::controller(ReportesController::class)->group(function () {
        Route::get('/reports/vacation/{id}', 'vacation')->name('report.vacation');
        Route::get('/reports/radiogram/{id}', 'radiogram')->name('report.radiogram');
        Route::get('/reports/officers', 'officers')->name('report.officers');
        Route::get('/reports/officers/officers-born_date', 'officers_born_date')->name('report.officers_born_date');
        Route::get('/reports/officers/ingress-date', 'ingress_date')->name('report.officers.ingress_date');
        Route::get('/reports/officers/card', 'card')->name('report.officers.card');
        Route::get('/reports/officers/officers-cargo', 'officers_cargo')->name('report.officers.officers_cargo');
        Route::get('/reports/officers/family-members', 'family_members')->name('report.officers.family_members');
        Route::get('/reports/officers/sizes-officers', 'sizes')->name('report.officers.sizes');
        Route::get('/reports/officers/filtros', 'officersFiltered')->name('report.officers.filtered');
        Route::get('/reports/urra/ficha/{id}', 'urraFicha')->name('report.urra.ficha');
        Route::get('/reports/urra/historial', 'urraHistorial')->name('report.urra.historial');
        Route::get('/reports/urra/actuales', 'urraActuales')->name('report.urra.actuales');
    });

    Route::controller(BulkImportController::class)->group(function () {
        Route::get('/carga-masiva/plantilla/{module}', 'template')->name('bulk-import.template');
        Route::post('/carga-masiva/importar', 'import')->name('bulk-import.import');
    });
});

Auth::routes(['register' => false]);
