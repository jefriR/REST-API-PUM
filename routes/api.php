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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('test', 'API\UserController2@testing');

//Route::post('login', 'API\UserController2@login');
//Route::post('register', 'API\UserController2@register');
Route::get('details', 'API\UserController2@details');
Route::get('users', 'API\UserController2@users');

//Route::get('getdept', 'API\UserController2@getdept');
//Route::get('gettrxtype', 'API\UserController2@gettrxtype');
//Route::post('doctype', 'API\UserController2@typeDocument');

Route::post('createpum', 'API\UserController2@createPum');


//*********** User Route ******************//
Route::POST('login',    'UserController@login');
Route::POST('register', 'UserController@register');


//*********** Create PUM Route ******************//
Route::get('getdept',       'PumController\CreatePumController@getdept');
Route::get('gettrxtype',    'PumController\CreatePumController@gettrxtype');
Route::post('getdoctype',   'PumController\CreatePumController@getTypeDocument');





//Route::group(['middleware' => 'auth:api'], function(){
//    Route::post('details', 'API\UserController@details');
//});

