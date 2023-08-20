<?php

use Illuminate\Support\Facades\Route;

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

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');

Route::middleware('auth:api')->group(function () {
    Route::get('/user', 'AuthController@user');
    Route::post('/logout', 'AuthController@logout');

    // Route for Employees
    Route::group(['prefix' => 'employees'], function () {
        Route::get('/', 'EmployeeController@index');
        Route::get('/show/{id}', 'EmployeeController@show');
        Route::put('/update/{id}', 'EmployeeController@update');
        Route::delete('/destory/{id}', 'EmployeeController@destroy');
    });
});
