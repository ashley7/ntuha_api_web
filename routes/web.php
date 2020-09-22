<?php
ini_set('max_execution_time', '1200');
use App\Http\Controllers\DriverController;
Route::get('/', function () {
    return view('front');
});



Auth::routes();

Route::resource('user_psw_reset','CustomerController');
Route::get('test_connection','NtuhaDashboardController@testConnection');

Route::group(['middleware' => 'auth'], function () {
	
	Route::get('/home', 'HomeController@index')->name('home');

	Route::post('customer','CustomerController@saveCustomer');
	
	Route::get('customer','CustomerController@create');

	Route::resource('customers','CustomerController');

	Route::post('import_customer','CustomerController@importCustomers');

	Route::get('import_user','CustomerController@importUser');

	Route::get('read_customers','CustomerController@readCustomers')->name('read_customers');

	Route::resource('ntuha_dashboard','NtuhaDashboardController');

	Route::get('read_ntuha_customers','NtuhaDashboardController@read_ntuha_customers');

	Route::get('read_ntuha_drivers','NtuhaDashboardController@read_ntuha_drivers');

	Route::get('driver_history/{driver_id}','NtuhaDashboardController@driver_history');

	Route::get('updated_history_status/{history_key}','NtuhaDashboardController@updated_history_status');

	Route::get('updated_driver_category/{driver_key}','NtuhaDashboardController@updated_driver_category');

	Route::get('updated_driver_subscription/{driver_key}','NtuhaDashboardController@updated_driver_subscription');

	Route::get('rides','FrontEndController@rides');

	Route::get('get_customers','FrontEndController@get_customers');

	Route::get('read_single_customer/{customer_id}','FrontEndController@read_single_customer');

	Route::get('read_single_driver/{driver_id}','FrontEndController@read_single_driver');

	Route::get('get_drivers','FrontEndController@get_drivers');

	Route::get('available_drivers','FrontEndController@available_drivers');

	Route::get('transactions','FrontEndController@transactions');

	Route::get('confirm_transaction/{id}','FrontEndController@confirm_transaction');
	
	Route::resource('price','PriceController');

	Route::resource('driver','DriverController');

	Route::resource('user','UserController');

	Route::resource('driver_top_up','DriverTopupController');

	Route::resource('ussd_requests','NtuhaRideUssdController');

	Route::get('assign_them_age','RideHistoryController@assignThemAge');

	Route::get('working_drivers','HomeController@workingDrivers');

	Route::resource('ntuha_rides','NtuhaRideController');

	Route::get('get_revenue_reports','NtuhaRideController@getRevenueReports');

	Route::get('load_customer','CustomerController@loadCustomer');

	Route::post('customer_report','CustomerController@customerReport');

	Route::get('get_driver_report','DriverController@getDriverReport');
	
	Route::post('driver_report','DriverController@driverReport');


});

Route::get('/beyonic', function () {
    \Beyonic::setApiKey("ab594c14986612f6167a975e1c369e71edab6900");

	$collection_request = \Beyonic_Collection_Request::create(array(
	  "phonenumber" => "+256787444081",
	  "amount" => "500",
	  "currency" => "BXC",
	  "metadata" => array("email"=>"123ASDAsd123"),
	  "send_instructions" => True
	));

	return json_encode($collection_request);
});

Route::get('/test_route', function () {

   $result = DriverController::SMS("0782348914","Hello Ntuha ride");

   printf($result);

});




