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
}
