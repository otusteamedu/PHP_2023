<?php

declare(strict_types=1);

use App\Controllers\EventsController;
use App\Router\Route;

return [
    Route::get('/read', [EventsController::class, 'read']),
    Route::delete('/clear', [EventsController::class, 'clear']),
    Route::post('/add', [EventsController::class, 'add']),
];
