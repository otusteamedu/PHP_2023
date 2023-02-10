<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Cache;
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

Route::get('/', function (Request $request) {
    Redis::set('redis', 'redis-test');
    $redis = Redis::get('redis');

    Cache::set('cache', 'cache-test');
    $cache = Cache::get('cache');

    dd($redis, $cache);

    return view('welcome');
});
