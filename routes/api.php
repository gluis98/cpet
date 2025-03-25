<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OfficersController;
use App\Http\Controllers\OfficersPositionsController;
use App\Http\Controllers\OfficersAcademyController;
use App\Http\Controllers\PositionsController;
use App\Http\Controllers\OfficersFamillyController;
use App\Http\Controllers\OfficersFilesController;
use App\Http\Controllers\OfficersVacationsController;

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

Route::controller(OfficersFamillyController::class)->group(function(){
    Route::get('/officers/familly/index/{id}', 'index');
    Route::post('/officers/familly', 'store');
    Route::get('/officers/familly/{id}', 'show');
    Route::put('/officers/familly/{id}', 'update');
    Route::delete('/officers/familly/{id}', 'destroy');
});

Route::controller(OfficersFilesController::class)->group(function(){
    Route::get('/officers/files/index/{id}', 'index');
    Route::post('/officers/files/add-files/{id}', 'store');
    Route::get('/officers/files/{id}', 'show');
    Route::put('/officers/files/{id}', 'update');
    Route::delete('/officers/files/{id}', 'destroy');
});

Route::controller(OfficersVacationsController::class)->group(function(){
    Route::get('/officers/vacations/index/{id}', 'index');
    Route::post('/officers/vacations', 'store');
    Route::get('/officers/vacations/{id}', 'show');
    Route::put('/officers/vacations/{id}', 'update');
    Route::delete('/officers/vacations/{id}', 'destroy');
});