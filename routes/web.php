<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OfficersController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware('auth')->group(function(){
    // General navigation
    Route::controller(HomeController::class)->group(function(){
        Route::get('/', 'index')->name('home');
        Route::get('/officers', 'officers')->name('officers');
        Route::get('/officers/academy/{id}', 'officers_academy')->name('officers.academy');
        Route::get('/officers/positions/{id}', 'officers_position')->name('officers.positions');
        Route::get('/officers/familly/{id}', 'officers_familly')->name('officers.familly');
    });

   
});


Auth::routes();

