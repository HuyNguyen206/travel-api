<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('travels', [\App\Http\Controllers\V1\TravelController::class, 'index'])->name('travels.index');
Route::get('travels/{travel:slug}/tours', [\App\Http\Controllers\V1\TourController::class, 'index'])->name('travels.tours.index');
