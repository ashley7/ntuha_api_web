<?php

Route::any('activate_driver','DriverController@activate_driver');

Route::any('service_price','DriverController@service_price');

Route::any('ride_history','RideHistoryController@record_ride');

Route::any('customer_register','RideHistoryController@customer_register');

Route::any('driverRemeber_password','RideHistoryController@driverRemeberPassword');

Route::any('customerRemeber_assword','RideHistoryController@customerRemeberPassword');

Route::any('payments','FrontEndController@payments');

Route::any('record_account_ride','FrontEndController@record_account_ride');

Route::any('customer_payments','FrontEndController@customer_payments');

Route::any('account_balance','FrontEndController@account_balance');

Route::any('check_payment_approval','FrontEndController@check_payment_approval');

Route::any('phone_number','FrontEndController@phone_number');

Route::any('number_of_rides','FrontEndController@number_of_rides');

Route::any('customer_number_of_rides','FrontEndController@customer_number_of_rides');

Route::any('read_ntuha_drivers','NtuhaDashboardController@read_ntuha_drivers');

Route::any('get_rider_price','FrontEndController@getRidePrice');
