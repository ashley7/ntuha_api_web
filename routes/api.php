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

Route::any('activate_driver','DriverController@activate_driver');
Route::any('service_price','DriverController@service_price');
Route::any('ride_history','RideHistoryController@record_ride');
Route::any('customer_register','RideHistoryController@customer_register');