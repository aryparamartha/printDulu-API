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

Route::get('/printer', 'PrinterController@index');
Route::post('/printer', 'PrinterController@create');
Route::post('/printer/{id}', 'PrinterController@update');
Route::delete('/printer/{id}', 'PrinterController@delete');

Route::get('/user', 'UserController@index');
Route::post('/user/register', 'UserController@create');
Route::post('/user/login', 'UserController@login');
Route::get('/user/logout', 'UserController@logout');

Route::post('sendNotification', 'NotificationController@sendNotification');

