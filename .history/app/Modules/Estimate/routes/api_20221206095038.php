<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Modules\Estimate\Http\Controllers\EstimateController;

Route::group([
    'middleware' => 'auth:sanctum',
    'prefix' => 'api/estimates'

], function ($router) {
    Route::get('/', [EstimateController::class, 'index']);
    Route::get('/{id}', [EstimateController::class, 'get']);
    Route::get('/file/sendEstimateFileStoragePath', [EstimateController::class, 'sendEstimateFileStoragePath']);
    Route::post('/file/Addfile', [EstimateController::class, 'Addfile']);
    Route::post('/create', [EstimateController::class, 'create']);
    Route::post('/update', [EstimateController::class, 'update']);
    Route::post('/delete', [EstimateController::class, 'delete']);
});
