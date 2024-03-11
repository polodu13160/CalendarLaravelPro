<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::resource('events', \App\Http\Controllers\EventController::class);
    Route::get('refetch-events', '\App\Http\Controllers\EventController@refetchEvents')->name('refetch-events');
    Route::put('events/{id}/resize', '\App\Http\Controllers\EventController@resizeEvent')->name('resize-event');
    Route::get('/authorize-google-calendar', [GoogleController::class, 'authorize'])->name('user.integration.authorize_google_calendar');
});

require __DIR__.'/auth.php';
