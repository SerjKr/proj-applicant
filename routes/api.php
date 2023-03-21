<?php

use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentTypeController;
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
Route::resource('equipment', EquipmentController::class);
Route::resource('equipment-type', EquipmentTypeController::class);

/*Route::controller(EquipmentController::class)->group(function () {
    Route::get('/equipment', 'index');
    Route::get('/equipment/{id}', 'show');
    Route::post('/equipment', 'store');
    Route::put('/equipment/{id}', 'update');
    Route::delete('/equipment/{id}', 'destroy');
});*/

//Route::get('/equipment-type', [EquipmentTypeController::class, 'index']);
