<?php

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
    return redirect('orden');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/orden', 'OrdenController@index')->name('orden');
Route::get('/orden/login', 'OrdenController@login')->name('login2');
Route::get('/orden/registrar', 'OrdenController@registrar')->name('registrar');
Route::get('/pedidos', 'OrdenController@pedidos')->name('pedidos');
Route::get('masas','AdminController@masas')->name('masas');
Route::get('ingredientes','AdminController@ingredient')->name('ingredientes');
Route::get('basicas','AdminController@basics')->name('basicas');
Route::get('especialidades','AdminController@specialities')->name('especialidades');
Route::get('pdf/{id}','OrdenController@pdf');
