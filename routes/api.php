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
Route::post('user/update', 'UserController@update');

Route::post('sendNotification', 'NotificationController@sendNotification');

Route::group(['middleware' => 'auth:api'], function(){
	Route::get('user/profile', 'UserController@profile');
	Route::post('user/profile/{id}', 'UserController@edit_profile'); //inget edit fungsinya yg setelah @
    Route::get('user/vendor','UserController@showVendor');
    Route::get('user/trans', 'UserController@showTransaction');
    Route::get('vendor/trans', 'UserController@showTransactionVendor');
});

Route::post('upload/add', 'UploadController@addFile');

Route::post('/trans/create', 'TransactionController@create');


