<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/containers', 'ContainerController@index')->middleware(\App\Http\Middleware\ForceJsonResponse::class);
Route::get('/containers/{id}', 'ContainerController@show')->middleware(\App\Http\Middleware\ForceJsonResponse::class);
Route::post('/containers/add', 'ContainerController@add')->middleware(\App\Http\Middleware\ForceJsonResponse::class);

Route::get('/studiosets', 'PhotoStudioSetsController@index')->middleware(\App\Http\Middleware\ForceJsonResponse::class);