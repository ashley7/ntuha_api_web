<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\NtuhaDashboardController;

class FrontEndController extends Controller
{
    public static function rides()
    {
    	$ride = NtuhaDashboardController::rides();


    	$data = array();

    	foreach ($ride as $key => $value) { 
    	$customer_name =  $driver_name = $from = $to = $date = $distance = $date = $rating = "";
 	        foreach ($value as $customer_key => $customer_value) {
 	        	$results = array();
	            if ($customer_key == "customer") {
	                $customers = $customer_value[0];

	                $customer_name = $customers['name']."(".$customers['phone'].")";
	                $distance = $value['distance'];
	                $rating = $value['rating'];
	                $date = date("Y-m-d",$value['timestamp']);
	            }

	            if($customer_key == "driver"){
	                $driver = $customer_value[0]; 
	                $driver_name = $driver['name']."(".$driver['phone'].")";
	            }

	            if($customer_key == "location"){

	                $from_location = $customer_value['from'];              
	                $to_location = $customer_value['to'];           
	                $from = $from_location['lat']."(".$from_location['lng'].")";
	                $to = $to_location['lat']."(".$to_location['lng'].")";

	            }	           
  			} 
  			    $results['customer_name'] = $customer_name;
	            $results['driver_name'] = $driver_name;
	            $results['from'] = $from;
	            $results['to'] = $to;
	            $results['date'] = $date;
	            $results['distance'] = $distance;	            
	            $results['rate'] = $rating;	            

	            $data[] = $results;
	      }
    
        return view('pages.rides')->with(['ride'=>$data]);
    }

    public static function get_customers()
    {
      $customers = NtuhaDashboardController::read_ntuha_customers();
      return view("pages.customer_list")->with(['customers'=>$customers]);   
    }

    public function read_single_customer($customer_id)
    {
    	$customer = NtuhaDashboardController::single_customer($customer_id);
    	$customer_history = NtuhaDashboardController::single_user_history("Customers",$customer_id);
    	$data = ['customer'=>$customer,'customer_history'=>$customer_history];  
    	return view('pages.customer_details')->with($data);   	 
    }

    public static function get_drivers()
    {
    	$drivers = NtuhaDashboardController::read_ntuha_drivers();
    	return view('pages.driver_list')->with(['drivers'=>$drivers]);
    }

    public function read_single_driver($driver_id)
    {
    	$driver = NtuhaDashboardController::single_driver($driver_id);
    	$driver_history = NtuhaDashboardController::single_user_history("Drivers",$driver_id);
    	$data = ['driver'=>$driver,'driver_history'=>$driver_history];  
    	return view('pages.driver_details')->with($data);   	 
    }


    public static function available_drivers()
    {
    	$available_drivers = NtuhaDashboardController::drivers_available();
    	return view('pages.available_driver')->with(['available_drivers'=>$available_drivers]);
    }
}
