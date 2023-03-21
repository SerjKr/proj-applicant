<?php

use App\Http\Resources\EquipmentErrorResource;
use App\Models\Equipment;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
//    return  new \App\Http\Resources\UserCollection(Equipment::all());
    return view('welcome');
});
