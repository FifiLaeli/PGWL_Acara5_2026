<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// Homepage
Route::get('/', [PageController::class, 'landingpage'])->name('home');

// Halaman Peta
Route::get('/peta', [PageController::class, 'peta']) ->middleware(['auth', 'verified']) ->name('peta');

// Dashboard
Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Tabel
Route::get('/tabel', [PageController::class, 'tabel'])->name('tabel');

//Points
Route::post('/points', [App\Http\Controllers\PointController::class, 'store'])
->name('points.store');

Route::delete('/delete-points/{id}', [App\Http\Controllers\PointController::class, 'destroy'])
->name('points.delete');

Route::patch('/edit-points/{id}', [App\Http\Controllers\PointController::class, 'update'])
    ->name('points.update');

Route::get('/edit-points/{id}', [App\Http\Controllers\PointController::class, 'edit'])
->name('points.edit');


//Polylines
Route::post('/polylines', [App\Http\Controllers\PolylinesController::class, 'store'])
->name('polylines.store');

Route::delete('/delete-polylines/{id}', [App\Http\Controllers\PolylinesController::class, 'destroy'])
->name('polylines.delete');

Route::patch('/edit-polylines/{id}', [App\Http\Controllers\PolylinesController::class, 'update'])
    ->name('polylines.update');

Route::get('/edit-polylines/{id}', [App\Http\Controllers\PolylinesController::class, 'edit'])
->name('polylines.edit');

//Polygons
Route::post('/polygons', [App\Http\Controllers\PolygonsController::class, 'store'])
->name('polygons.store');

Route::delete('/delete-polygons/{id}', [App\Http\Controllers\PolygonsController::class, 'destroy'])
->name('polygons.delete');

Route::patch('/edit-polygons/{id}', [App\Http\Controllers\PolygonsController::class, 'update'])
    ->name('polygons.update');

Route::get('/edit-polygons/{id}', [App\Http\Controllers\PolygonsController::class, 'edit'])
->name('polygons.edit');

require __DIR__.'/settings.php';
