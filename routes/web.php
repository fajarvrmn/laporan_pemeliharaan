<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::middleware(['admin'])->group(function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::prefix('admin')->group(function () {

        // Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::resource('merekperalatan', App\Http\Controllers\MerekController::class);
        Route::resource('tipeperalatan', App\Http\Controllers\TipeController::class);
        Route::resource('garduinduk', App\Http\Controllers\GarduController::class);
        Route::resource('status', StatusController::class);
        Route::resource('namabay', NamabayController::class);

    });

});