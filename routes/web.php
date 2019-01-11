<?php
ini_set('max_execution_time', '900');
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('ntuha_dashboard','NtuhaDashboardController');
Route::get('read_ntuha_customers','NtuhaDashboardController@read_ntuha_customers');
Route::get('read_ntuha_drivers','NtuhaDashboardController@read_ntuha_drivers');
Route::get('driver_history/{driver_id}','NtuhaDashboardController@driver_history');

Route::get('rides','FrontEndController@rides');