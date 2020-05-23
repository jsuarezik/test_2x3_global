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

Route::get('/clients', 'ClientController@all');
Route::get('/payments', 'PaymentController@all');
Route::post('/payments', 'PaymentController@add');
Route::get('/test', 'ClientController@test');
