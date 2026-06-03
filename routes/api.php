<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

//GeoJSON API
Route::get('/points', [App\Http\Controllers\APIController::class, 'getPoints'])->name('api.points');
Route::get('/polylines', [App\Http\Controllers\APIController::class, 'getPolylines'])->name('api.polylines');
Route::get('/polygons', [App\Http\Controllers\APIController::class, 'getPolygons'])->name('api.polygons');
Route::get('/points/{id}', [App\Http\Controllers\APIController::class, 'geojson_point'])->name('geojson.point');
Route::get('/polylines/{id}', [App\Http\Controllers\APIController::class, 'geojson_polyline'])->name('geojson.polyline');
Route::get('/polygons/{id}', [App\Http\Controllers\APIController::class, 'geojson_polygon'])->name('geojson.polygon');
