<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
//Rutas para Cliente
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::post('/clients', 'ClienteController@store');
    Route::get('/clients/{id}', 'ClienteController@show');
    Route::delete('/clients/{id}','ClienteController@destroy');
    Route::put('/clients/{id}','ClienteController@update');
});
//Rutas para el Producto
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::post('/products', 'ProductoController@store');
    Route::get('/products/{id}','ProductoController@show');
    Route::delete('/products/{id}','ProductoController@destroy');
    Route::put('/products/{id}','ProductoController@update');
});
//Rutas para las ventas
Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::post('/sales', 'VentaController@store');
});
