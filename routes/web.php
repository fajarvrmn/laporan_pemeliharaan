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

Route::group(['middleware' => ['auth']], function() {
    Route::resource('home', App\Http\Controllers\HomeController::class);
    Route::resource('dashboard', App\Http\Controllers\DashboardController::class);
    Route::resource('merekperalatan', App\Http\Controllers\MerekController::class);
    Route::resource('tipeperalatan', App\Http\Controllers\TipeController::class);
    Route::resource('garduinduk', App\Http\Controllers\GarduController::class);
    Route::resource('status', App\Http\Controllers\StatusController::class);
    Route::resource('peralatan', App\Http\Controllers\PeralatanController::class);
    Route::resource('personil', App\Http\Controllers\PersonilController::class);
    Route::resource('laporan', App\Http\Controllers\LaporanController::class);
    Route::get('laporan/pdf/{search}', [App\Http\Controllers\LaporanController::class, 'cetak_pdf']);
    Route::get('laporan/excel/{search}', [App\Http\Controllers\LaporanController::class, 'exportExcel']);
});

// Route::middleware(['admin'])->group(function () {

//     Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//     Route::prefix('admin')->group(function () {

//         // Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//         Route::resource('dashboard', App\Http\Controllers\DashboardController::class);
//         Route::resource('merekperalatan', App\Http\Controllers\MerekController::class);
//         Route::resource('tipeperalatan', App\Http\Controllers\TipeController::class);
//         Route::resource('garduinduk', App\Http\Controllers\GarduController::class);
//         Route::resource('status', App\Http\Controllers\StatusController::class);
//         Route::resource('peralatan', App\Http\Controllers\PeralatanController::class);
//         Route::resource('personil', App\Http\Controllers\PersonilController::class);
//         Route::resource('laporan', App\Http\Controllers\LaporanController::class);
//         // Route::resource('namabay', NamabayController::class);

//     });

// });

// Route::middleware(['supervisor'])->group(function () {

//     Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//     Route::prefix('supervisor')->group(function () {

//         // Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//         Route::resource('dashboard', App\Http\Controllers\DashboardController::class);
//         Route::resource('merekperalatan', App\Http\Controllers\MerekController::class);
//         Route::resource('tipeperalatan', App\Http\Controllers\TipeController::class);
//         Route::resource('garduinduk', App\Http\Controllers\GarduController::class);
//         Route::resource('status', App\Http\Controllers\StatusController::class);
//         Route::resource('peralatan', App\Http\Controllers\PeralatanController::class);
//         Route::resource('personil', App\Http\Controllers\PersonilController::class);
//         Route::resource('laporan', App\Http\Controllers\LaporanController::class);
//         // Route::resource('namabay', NamabayController::class);

//     });

// });