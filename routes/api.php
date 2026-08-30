<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfficersController;
use App\Http\Controllers\OfficersPositionsController;
use App\Http\Controllers\OfficersAcademyController;
use App\Http\Controllers\OfficersCoursesController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\OfficersFamillyController;
use App\Http\Controllers\OfficersFilesController;
use App\Http\Controllers\OfficersVacationsController;
use App\Http\Controllers\OfficersAwardsController;
use App\Http\Controllers\OfficersArmamentController;
use App\Http\Controllers\ArmamentController;
use App\Http\Controllers\OfficersRadiogramController;
use App\Http\Controllers\OfficersHealthController;
use App\Http\Controllers\OfficersIcapController;
use App\Http\Controllers\OfficersUrraController;
use App\Http\Controllers\CatalogosController;
use App\Http\Controllers\StationController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('/officers', OfficersController::class);
Route::apiResource('/positions', PositionsController::class);
Route::apiResource('/armament', ArmamentController::class);
Route::apiResource('/stations', StationController::class);
Route::apiResource('/users', UserController::class);
Route::post('/users/confirm-password-admin', [UserController::class, 'confirm_password_admin']);

Route::controller(OfficersPositionsController::class)->group(function(){
    Route::get('/officers/position/index/{id}', 'index');
    Route::post('/officers/position', 'store');
    Route::get('/officers/position/{id}', 'show');
    Route::put('/officers/position/{id}', 'update');
    Route::delete('/officers/position/{id}', 'destroy');
});

Route::controller(OfficersAcademyController::class)->group(function(){
    Route::get('/officers/academy/index/{id}', 'index');
    Route::post('/officers/academy', 'store');
    Route::get('/officers/academy/{id}', 'show');
    Route::put('/officers/academy/{id}', 'update');
    Route::delete('/officers/academy/{id}', 'destroy');
});

Route::controller(OfficersCoursesController::class)->group(function(){
    Route::get('/officers/course/index/{id}', 'index');
    Route::post('/officers/course', 'store');
    Route::get('/officers/course/{id}', 'show');
    Route::put('/officers/course/{id}', 'update');
    Route::delete('/officers/course/{id}', 'destroy');
});

Route::controller(OfficersAwardsController::class)->group(function(){
    Route::get('/officers/awards/index/{id}', 'index');
    Route::post('/officers/awards', 'store');
    Route::get('/officers/awards/{id}', 'show');
    Route::put('/officers/awards/{id}', 'update');
    Route::delete('/officers/awards/{id}', 'destroy');
});

Route::controller(OfficersFamillyController::class)->group(function(){
    Route::get('/officers/familly/index/{id}', 'index');
    Route::post('/officers/familly', 'store');
    Route::get('/officers/familly/{id}', 'show');
    Route::put('/officers/familly/{id}', 'update');
    Route::delete('/officers/familly/{id}', 'destroy');
});

Route::controller(CatalogosController::class)->group(function () {
    Route::get('/discapacidades', 'discapacidadesIndex');
    Route::post('/discapacidades', 'discapacidadesStore');
    Route::get('/discapacidades/{id}', 'discapacidadesShow');
    Route::put('/discapacidades/{id}', 'discapacidadesUpdate');
    Route::delete('/discapacidades/{id}', 'discapacidadesDestroy');

    Route::get('/catalogo-cursos', 'cursosIndex');
    Route::post('/catalogo-cursos', 'cursosStore');
    Route::get('/catalogo-cursos/{id}', 'cursosShow');
    Route::put('/catalogo-cursos/{id}', 'cursosUpdate');
    Route::delete('/catalogo-cursos/{id}', 'cursosDestroy');

    Route::get('/cargos', 'cargosIndex');
    Route::post('/cargos', 'cargosStore');
    Route::get('/cargos/{id}', 'cargosShow');
    Route::put('/cargos/{id}', 'cargosUpdate');
    Route::delete('/cargos/{id}', 'cargosDestroy');

    Route::get('/cargos-administrativos', 'cargosAdministrativosIndex');
    Route::post('/cargos-administrativos', 'cargosAdministrativosStore');
    Route::get('/cargos-administrativos/{id}', 'cargosAdministrativosShow');
    Route::put('/cargos-administrativos/{id}', 'cargosAdministrativosUpdate');
    Route::delete('/cargos-administrativos/{id}', 'cargosAdministrativosDestroy');

    Route::get('/municipios', 'municipiosIndex');
    Route::post('/municipios', 'municipiosStore');
    Route::get('/parroquias', 'parroquiasIndex');
    Route::post('/parroquias', 'parroquiasStore');
});

Route::controller(OfficersFilesController::class)->group(function(){
    Route::get('/officers/files/index/{id}', 'index');
    Route::post('/officers/files/add-files/{id}', 'store');
    Route::get('/officers/files/{id}', 'show');
    Route::put('/officers/files/{id}', 'update');
    Route::delete('/officers/files/{id}', 'destroy');
    Route::get('/officers/files/reposos/{id}', 'get_reposos');
    Route::post('/officers/files/reposos/{id}', 'updateReposo');
});

Route::controller(OfficersVacationsController::class)->group(function(){
    Route::get('/officers/vacations/index/{id}', 'index');
    Route::post('/officers/vacations', 'store');
    Route::get('/officers/vacations/{id}', 'show');
    Route::put('/officers/vacations/{id}', 'update');
    Route::delete('/officers/vacations/{id}', 'destroy');
});

Route::controller(OfficersArmamentController::class)->group(function(){
    Route::get('/officers/armament/index/{id}', 'index');
    Route::post('/officers/armament', 'store');
    Route::get('/officers/armament/{id}', 'show');
    Route::put('/officers/armament/{id}', 'update');
    Route::delete('/officers/armament/{id}', 'destroy');
});

Route::controller(OfficersRadiogramController::class)->group(function(){
    Route::get('/officers/radiogram/index/{id}', 'index');
    Route::post('/officers/radiogram', 'store');
    Route::get('/officers/radiogram/{id}', 'show');
    Route::put('/officers/radiogram/{id}', 'update');
    Route::delete('/officers/radiogram/{id}', 'destroy');
});

Route::controller(OfficersHealthController::class)->group(function(){
    Route::get('/officers/health/index/{id}', 'index');
    Route::post('/officers/health', 'store');
    Route::get('/officers/health/{id}', 'show');
    Route::put('/officers/health/{id}', 'update');
    Route::delete('/officers/health/{id}', 'destroy');
});

Route::controller(OfficersIcapController::class)->group(function(){
    Route::get('/officers/icap/expedientes/index/{id}', 'indexExpedientes');
    Route::post('/officers/icap/expedientes', 'storeExpediente');
    Route::get('/officers/icap/expedientes/{id}', 'showExpediente');
    Route::put('/officers/icap/expedientes/{id}', 'updateExpediente');
    Route::delete('/officers/icap/expedientes/{id}', 'destroyExpediente');

    Route::get('/officers/icap/sobreviviente/index/{id}', 'indexSobreviviente');
    Route::post('/officers/icap/sobreviviente', 'storeSobreviviente');
    Route::get('/officers/icap/sobreviviente/{id}', 'showSobreviviente');
    Route::put('/officers/icap/sobreviviente/{id}', 'updateSobreviviente');
    Route::delete('/officers/icap/sobreviviente/{id}', 'destroySobreviviente');
});

Route::controller(OfficersUrraController::class)->group(function () {
    Route::get('/officers/urra/index/{id}', 'index');
    Route::post('/officers/urra', 'store');
    Route::get('/officers/urra/{id}', 'show');
    Route::put('/officers/urra/{id}', 'update');
    Route::delete('/officers/urra/{id}', 'destroy');
});