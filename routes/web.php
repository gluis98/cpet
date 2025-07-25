<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ReportesController;
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
        Route::get('/officers/radiogram/{id}', 'officers_radiogram')->name('officers.radiogram');
        Route::get('/officers/academy/{id}', 'officers_academy')->name('officers.academy');
        Route::get('/officers/courses/{id}', 'officers_courses')->name('officers.courses');
        Route::get('/officers/positions/{id}', 'officers_position')->name('officers.positions');
        Route::get('/officers/familly/{id}', 'officers_familly')->name('officers.familly');
        Route::get('/officers/vacations/{id}', 'officers_vacations')->name('officers.vacations');
        Route::get('/officers/awards/{id}', 'officers_awards')->name('officers.awards');
        Route::get('/officers/health/{id}', 'officers_health')->name('officers.health');

        Route::get('/stations', 'stations')->name('stations');
        Route::get('/users', 'users')->name('users');
    });
    
    Route::controller(ReportesController::class)->group(function(){
        Route::get('/reports/vacation/{id}', 'vacation')->name('report.vacation');
        Route::get('/reports/radiogram/{id}', 'radiogram')->name('report.radiogram');
        Route::get('/reports/officers', 'officers')->name('report.officers');
        Route::get('/reports/officers/officers-born_date', 'officers_born_date')->name('report.officers_born_date');
        Route::get('/reports/officers/ingress-date', 'ingress_date')->name('report.officers.ingress_date');
        Route::get('/reports/officers/card', 'card')->name('report.officers.card');
        Route::get('/reports/officers/officers-cargo', 'officers_cargo')->name('report.officers.officers_cargo');
        Route::get('/reports/officers/family-members', 'family_members')->name('report.officers.family_members');
    });
   
});


Auth::routes();

