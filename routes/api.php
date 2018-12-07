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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

// -- user: login, register, logout
Route::post('register', 'Auth\RegisterController@register');
Route::post('login', 'Auth\LoginController@login');
Route::middleware('auth:api')->get('logout', 'Auth\LoginController@logout');


Route::group([ 'prefix' => 'subscriber', 'middleware' => 'auth:api' ], function(){
	Route::get('/list', 'SubscriptionController@index');
	Route::get('/{subscription}', 'SubscriptionController@show');
	Route::post('/', 'SubscriptionController@store');
	Route::delete('/{subscription}', 'SubscriptionController@delete');
	Route::patch('/{subscription}', 'SubscriptionController@update');
});

Route::group([ 'prefix' => 'field', 'middleware' => 'auth:api' ], function(){
	Route::get('/list', 'FieldController@index');
});