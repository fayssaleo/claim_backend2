<?php

use App\Modules\Equipment\Http\Controllers\EquipmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'api/equipments'

], function ($router) {
    Route::post('/createOrUpdateEquipment', [EquipmentController::class, 'createOrUpdateEquipment']);


});
