<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;


//  Web Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');
//Halaman Peta Interaktif
Route::get('/peta', [PageController::class, 'peta'])->name('peta');
//Halaman Tabel Data
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
//Halaman Tabel Data
Route::get('/tabel', [PageController::class, 'tabel'])->name('tabel');

//Points
Route::post('/points', [App\Http\Controllers\PointController::class, 'store'])
->name('points.store');

//Polylines
Route::post('/polylines', [App\Http\Controllers\PolylinesController::class, 'store'])
->name('polylines.store');

//Polygons
Route::post('/polygons', [App\Http\Controllers\PolygonsController::class, 'store'])
->name('polygons.store');

require __DIR__.'/settings.php';
