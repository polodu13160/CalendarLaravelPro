<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FullCalenderController;

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


Route::controller(FullCalenderController::class)->group(function () {

    Route::get('fullcalender', 'index')->name('fullcalender');

    Route::post('fullcalenderAjax', 'ajax');

    Route::get('test','getTest')->name('test');
    Route::post('test','postTest');
    
});
