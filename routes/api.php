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
Route::post('auth/login', 'UserController@login');

Route::group(['middleware' => 'jwt.auth'], function () {
    Route::get('user', 'UserController@getAuthUser');
    Route::post('photoupload', 'UploadfileController@uploadfile');
    Route::post('photouploadaccesorio', 'UploadfileController@uploadfile2');
    Route::post('photouploadpedigree', 'UploadfileController@uploadfile3');
    Route::post('fotochat', 'UploadfileController@fotochat');
    Route::post('fotousuario', 'UploadfileController@fotousuario');
    Route::post('pruebab64', 'UploadfileController@pruebab64');

});
Route::post('auth/register', 'UserController@register');