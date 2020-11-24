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
Route::post('/submitMob','loginController@submitMob');
Route::post('/class/add','classesController@add');
Route::put('/class/update','classesController@update');
Route::get('/class/list','classesController@list');
Route::get('/class/view/','classesController@view');
Route::post('/student/add','studentsController@add');
Route::put('/student/update','studentsController@update');
Route::get('/student/list','studentsController@list');