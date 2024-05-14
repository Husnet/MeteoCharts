<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/devices/sensors', [\App\Http\Controllers\Api\Devices\SensorsController::class, 'raw_status'])
    ->name('api.devices.sensors.status_raw');
Route::post('/devices/logs', [\App\Http\Controllers\Api\Devices\LogsController::class, 'receive_logs'])
    ->name('api.devices.logs.receive');
