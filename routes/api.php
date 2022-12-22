<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AutomationController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('auto',AutomationController::class);
Route::post('auto1', 'App\Http\Controllers\Api\AutomationController@store');
Route::get('checkifnotified/{subscription_id}', 'App\Http\Controllers\Api\AutomationController@checkifnotified');


