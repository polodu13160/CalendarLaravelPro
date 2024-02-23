<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FullCalendarController;

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

Route::get('/', function () {
    return view('welcome');
})->name('welcome');


Route::controller(FullCalendarController::class)->group(function () {

    Route::get('fullcalendar', 'index')->name('fullcalendar');

    Route::post('fullcalendarAjax', 'ajax');
});
