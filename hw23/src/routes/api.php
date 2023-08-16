<?php

use App\Http\Controllers\API\PlaylistController;
use App\Http\Controllers\API\TrackController;
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

Route::post('/create-track', [TrackController::class, 'create']);
Route::post('/create-list', [PlaylistController::class, 'create']);
Route::get('/tracks', [TrackController::class, 'showList']);
Route::get('/lists', [PlaylistController::class, 'showList']);
