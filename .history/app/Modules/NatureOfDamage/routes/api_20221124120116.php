<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Modules\NatureOfDamage\Http\Controllers\NatureOfDamageController;

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'api/NatureOfDamage'

], function ($router) {
    Route::get('/', [NatureOfDamageController::class, 'index']);
    Route::get('/{id}', [NatureOfDamageController::class, 'get']);
    Route::post('/create', [NatureOfDamageController::class, 'create']);
    Route::post('/update', [NatureOfDamageController::class, 'update']);
    Route::post('/delete', [NatureOfDamageController::class, 'delete']);
});
