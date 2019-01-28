<?php
ini_set('max_execution_time', '1200');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware' => 'auth'], function () {
	Route::get('/home', 'HomeController@index')->name('home');
	Route::resource('ntuha_dashboard','NtuhaDashboardController');
	Route::get('read_ntuha_customers','NtuhaDashboardController@read_ntuha_customers');
	Route::get('read_ntuha_drivers','NtuhaDashboardController@read_ntuha_drivers');
	Route::get('driver_history/{driver_id}','NtuhaDashboardController@driver_history');

	Route::get('rides','FrontEndController@rides');
	Route::get('get_customers','FrontEndController@get_customers');
	Route::get('read_single_customer/{customer_id}','FrontEndController@read_single_customer');
	Route::get('read_single_driver/{driver_id}','FrontEndController@read_single_driver');
	Route::get('get_drivers','FrontEndController@get_drivers');
	Route::get('available_drivers','FrontEndController@available_drivers');
	Route::resource('price','PriceController');
	Route::resource('driver','DriverController');
});
