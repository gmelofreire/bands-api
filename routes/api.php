<?php

use App\Http\Controllers\BandController;
use Illuminate\Http\Request;
use App\Http\Controllers\HelloWorldController;
use Illuminate\Support\Facades\Route;

// Route::get('hello/{name}', [HelloWorldController::class, 'hello']);

// Route::post('hello-post/{name}', [HelloWorldController::class, 'helloPost']);

Route::get('bands', [BandController::class, 'getAll']);

Route::get('band/{id}', [BandController::class, 'getById']);

Route::get('bands/gender/{id}', [BandController::class, 'getByGenre']);

Route::post('band/store', [BandController::class, 'store']);

Route::delete('band/delete/{id}', [BandController::class, 'deleteBand']);

Route::put('band/update/{id}', [BandController::class, 'updateBand']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
