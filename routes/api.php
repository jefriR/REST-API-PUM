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

Route::get('test', 'TestingController@testing');
Route::POST('testarray', 'TestingController@testarray');

//Route::post('login', 'API\UserController2@login');
//Route::post('register', 'API\UserController2@register');
Route::get('details', 'API\UserController2@details');
Route::get('users', 'API\UserController2@users');

//Route::get('getdept', 'API\UserController2@getdept');
//Route::get('gettrxtype', 'API\UserController2@gettrxtype');
//Route::post('doctype', 'API\UserController2@typeDocument');

//Route::post('createpum', 'API\UserController2@createPum');


//*********** User Route ******************//
Route::POST('login',    'UserController@login');
Route::POST('register', 'UserController@register');

//*********** Detail PUM Route ******************//
Route::post('detailpum',        'PumController\DetailPumController@detailPum');
Route::post('summarycreatepum', 'PumController\DetailPumController@summaryCreatePum');

//*********** Create PUM Route ******************//
Route::post('cekavailablepum',  'PumController\CreatePumController@cekAvailablePum');
Route::get('getdept',           'PumController\CreatePumController@getdept');
Route::get('gettrxtype',        'PumController\CreatePumController@gettrxtype');
Route::post('getdocdetail',     'PumController\CreatePumController@getDocDetail');
Route::post('createpum',        'PumController\CreatePumController@createPum');


//*********** Approval PUM Route ******************//
Route::post('listapproval',     'PumController\ApprovalController@listApproval');;
Route::post('approvepum',       'PumController\ApprovalController@approvePum');

//*********** History Pum Route ******************//
Route::post('historycreatepum',         'PumController\HistoryPumController@historyCreatePum');
Route::post('filterhistorycreatepum',   'PumController\HistoryPumController@filterHistoryCreatePum');
Route::post('historyapprovepum',        'PumController\HistoryPumController@historyApprovalPum');

//*********** Responsibility Pum Route ******************//
Route::post('getdataresponse',  'PumController\ResponsibilityController@getAllData');
Route::post('submitresponse',     'PumController\ResponsibilityController@submitResponsibility');



//Route::group(['middleware' => 'auth:api'], function(){
//    Route::post('details', 'API\UserController@details');
//});

