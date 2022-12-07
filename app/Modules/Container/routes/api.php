<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Modules\Container\Http\Controllers\ContainerController;

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'api/containers'

], function ($router) {
    Route::post('/createOrUpdateContainer', [ContainerController::class, 'createOrUpdateContainer']);
    Route::get('/allClaim', [ContainerController::class, 'allClaim']);
    Route::get('/allIncident', [ContainerController::class, 'allIncident']);
    Route::post('/delete', [ContainerController::class, 'delete']);


});
