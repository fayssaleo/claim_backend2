<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'api/fonctions'

], function ($router) {
    Route::post('/createOrUpdateEquipment', [EquipmentController::class, 'createOrUpdateEquipment']);


});
