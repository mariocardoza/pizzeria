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

Route::apiResource('masas', 'api\MasaController');
Route::apiResource('tamanios', 'api\TamanioController');
Route::apiResource('ingredients', 'api\IngredientController');
Route::get('allIngredients','api\IngredientController@allIngredients');
Route::apiResource('basics', 'api\BasicController');
Route::get('allSpecialityIngredients/{id}','api\SpecialityController@allIngredients');
Route::get('allSpecialities','api\SpecialityController@allSpecialities');
Route::get('getSpeciality/{id}','api\SpecialityController@getSpeciality');
Route::apiResource('specialities', 'api\SpecialityController');
Route::get('orders/getPending/{token}','api\OrderController@getPending');
Route::delete('orders/delete2/{token}','api\OrderController@delete2');
Route::delete('orders/delete3/{token}','api\OrderController@delete3');
Route::post('orders/confirmar/{id}','api\OrderController@confirmar');
Route::apiResource('orders', 'api\OrderController');
