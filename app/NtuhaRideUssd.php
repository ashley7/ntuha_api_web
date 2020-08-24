<?php

namespace App;

use App\Customer;
use App\Http\Controllers\DriverController;
use Illuminate\Database\Eloquent\Model;

class NtuhaRideUssd extends Model
{
    public static function welcomeMessage()
    {
    	$response  = "CON Welcome to Ntuha Ride!";
        $response .= "\n1. Register for the Service";
        $response .= "\n2. Request for a Ride";    
        NtuhaRideUssd::loadMenu($response);
    }

    public static function promptName()
    {
    	$response = "CON What is your name?";
    	NtuhaRideUssd::loadMenu($response);
    }

    public static function promptGender()
    {
    	$response  = "CON What is your gender?";
        $response .= "\n1. Female";
        $response .= "\n2. Male";    
        NtuhaRideUssd::loadMenu($response);
    }

    public static function promptDistrict()
    {
    	$response  = "CON What id your District name?";
        $response .= "\ne.g Mbarara";       
        NtuhaRideUssd::loadMenu($response);
    }

    public static function promptAge()
    {
    	$response  = "CON How old are you today?";
        $response .= "\ne.g 23";       
        NtuhaRideUssd::loadMenu($response);
    }

    public static function disAbility()
    {
    	$response  = "CON Do you have any physical emparement?";
        $response .= "\n1. No";       
        $response .= "\n2. Yes";       
        NtuhaRideUssd::loadMenu($response);	 
    }


    public static function occupation($data,$phoneNumber)
    {
    	$response  = "CON What is your occupation?";     
        NtuhaRideUssd::loadMenu($response);	 
        NtuhaRideUssd::saveCustomer($data,$phoneNumber);	 
    }

    public static function saveCustomer($data,$phoneNumber)
    { 

    	$sex = "";   

    	if ($data[3] == 1) {
    		$sex = "Female";
    	}elseif ($data[3] == 2) {
    		$sex = "Male"; 
    	}

    	$year_of_birth = $data[5] - date("Y");

    	if ($data[6] == 1) {
    		$disability_status = "Not disabled"; 
    	}elseif ($data[6] == 2) {
    		$disability_status = "disabled"; 
    	}

    	$customer = Customer::saveCustomer($data[2],"",$sex,$year_of_birth,$disability_status,$data[4],$data[7],now(),"USSD customer",$phoneNumber,"SELF");
    	$message = "Hello ".$customer->name." thank you for registering with Ntuha Ride";
    	NtuhaRideUssd::killSeesion($message);

     }

    public static function loadMenu($response)
	{
	    header('Content-type: text/plain');
	    echo $response;
	}

	public static function killSeesion($message)
	{
	    header('Content-type: text/plain');              
	    echo "END ".$message;
	}

}
