<?php

use App\Http\Controllers\Api\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DeskController;
use App\Http\Controllers\Api\DeskListContoller;
use App\Http\Controllers\Api\CardContoller;
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
Route::apiResources([
    'tasks'=>TaskController::class,
    'desks'=>DeskController::class,
    'lists'=>DeskListContoller::class,
    'cards'=>App\Http\Controllers\Api\CardContoller::class


]);
