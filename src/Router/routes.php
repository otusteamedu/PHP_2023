<?php

declare(strict_types=1);

use App\Controllers\DataMapperGenreController;
use App\Controllers\TableGatewayGenreController;
use App\Controllers\TableGatewayMovieController;
use App\Router\Route;

return [
    Route::get('/tableGateway/genres', [TableGatewayGenreController::class, 'getAllGenres']),
    Route::post('/tableGateway/genres', [TableGatewayGenreController::class, 'insert']),
    Route::put('/tableGateway/genres', [TableGatewayGenreController::class, 'update']),
    Route::delete('/tableGateway/genres', [TableGatewayGenreController::class, 'delete']),
    Route::get('/tableGateway/movies', [TableGatewayMovieController::class, 'getAllMovies']),
    Route::post('/tableGateway/movies', [TableGatewayMovieController::class, 'insert']),
    Route::put('/tableGateway/movies', [TableGatewayMovieController::class, 'update']),
    Route::get('/dataMapper/genres', [DataMapperGenreController::class, 'getAllGenres']),
    Route::post('/dataMapper/genres', [DataMapperGenreController::class, 'insert']),
    Route::put('/dataMapper/genres', [DataMapperGenreController::class, 'update']),
];
