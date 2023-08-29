<?php

use App\Http\Controllers\ControllerPlaylist;
use App\Http\Controllers\ControllerSubscriber;
use App\Http\Controllers\ControllerTrack;
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

Route::group(['prefix' => 'track'], function() {
    Route::get('/', [ControllerTrack::class, 'getList']);
    Route::post('/add', [ControllerTrack::class, 'add']);
    Route::post('/get_by_genre', [ControllerTrack::class, 'getByGenre']);
    Route::post('/subscribe', [ControllerSubscriber::class, 'add']);
});

Route::group(['prefix' => 'playlist'], function() {
    Route::get('/', [ControllerPlaylist::class, 'getList']);
    Route::put('/add', [ControllerPlaylist::class, 'add']);
});
