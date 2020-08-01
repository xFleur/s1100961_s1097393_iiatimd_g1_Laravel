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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

//user
Route::post('login','Api\AuthController@login');
Route::post('register','Api\AuthController@register');
Route::get('logout','Api\AuthController@logout');
Route::post('save_user_info','Api\AuthController@saveUserInfo')->middleware('jwtAuth');
Route::get('userinfo','Api\AuthController@userinfo')->middleware('jwtAuth');

//scoreboard
Route::post('score/create','Api\ScoreController@create')->middleware('jwtAuth');
Route::post('score/delete','Api\ScoreController@delete')->middleware('jwtAuth');
Route::post('score/update','Api\ScoreController@update')->middleware('jwtAuth');
Route::get('score','Api\ScoreController@posts')->middleware('jwtAuth');