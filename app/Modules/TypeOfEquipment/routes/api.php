<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Modules\TypeOfEquipment\Http\Controllers\TypeOfEquipmentController;

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'api/TypeOfEquipment'

], function ($router) {
    Route::get('/', [TypeOfEquipmentController::class, 'index']);
    Route::get('/{id}', [TypeOfEquipmentController::class, 'get']);
    Route::post('/create', [TypeOfEquipmentController::class, 'create']);
    Route::post('/update', [TypeOfEquipmentController::class, 'update']);
    Route::post('/delete', [TypeOfEquipmentController::class, 'delete']);
});
