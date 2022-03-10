<?php

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function() {
    Route::get('/tasks/list', '\App\Http\Controllers\TaskController@listTasks');
    Route::post('/tasks/create', '\App\Http\Controllers\TaskController@createTask');
});

Route::post('register', '\App\Http\Controllers\AuthController@register');
Route::post('login', '\App\Http\Controllers\AuthController@login');
