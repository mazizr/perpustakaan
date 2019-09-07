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

Route::get('/', function (Router $router) {
    return collect($router->getRoutes()->getRoutesByMethod()["GET"])->map(function ($value, $key) {
        return url($key);
    })->values();
});
Route::resource('petugas', 'PetugasAPIController', [
    'only' => ['index', 'show', 'store', 'update', 'destroy']
]);

Route::resource('rak', 'RakAPIController', [
    'only' => ['index', 'show', 'store', 'update', 'destroy']
]);


