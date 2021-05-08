<?php

namespace App;

use App\Customer;
use App\Driver;
use App\Http\Controllers\DriverController;
use Illuminate\Database\Eloquent\Model;

class NtuhaRideUssd extends Model
{

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class,'driver_id');
    }

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
    	$response  = "CON What is your District name?";
        $response .= "\n1. Mbarara";       
        $response .= "\n2. Ibanda";       
        $response .= "\n3. Bushenyi";       
        $response .= "\n4. Fortpotal";       
        $response .= "\n5. Kamwenge";       
        $response .= "\n6. Isingiro";       
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
        $response  .= "\n1. Farmer";     
        $response  .= "\n2. Commuter";    
        NtuhaRideUssd::loadMenu($response);
    }

    public static function saveCustomer($data,$phoneNumber)
    { 

    	$sex = "";   

    	if ($data[3] == 1) {
    		$sex = "Female";
    	}elseif ($data[3] == 2) {
    		$sex = "Male"; 
    	}

    	$year_of_birth = date("Y") - $data[5];

    	if ($data[6] == 1) {
    		$disability_status = "Not disabled"; 
    	}elseif ($data[6] == 2) {
    		$disability_status = "disabled"; 
    	}

    	$customer = Customer::saveCustomer($data[2],"",$sex,$year_of_birth,$disability_status,$data[4],$data[7],now(),"USSD customer",$phoneNumber,"SELF");

    	$message = "Hello ".$customer->name." thank you for registering with Ntuha Ride";

    	NtuhaRideUssd::killSeesion($message);

     }

     /*====================================
        THE FUCNTIONS FOR MAKING A REQUEST
     ======================================*/ 


     public static function selectService($phoneNumber)
     {

        $customer = Customer::checkCustomer($phoneNumber);

        if (count($customer) == 0) {

            NtuhaRideUssd::killSeesion("Ntuha Ride does not recognise ".$phoneNumber."\n Please register first");

            return;
             
         } 

        $thiscustomer = $customer->last();
        $response  = "CON ".$thiscustomer->name.", Please select a service";
        $response .= "\n1. Ntuha Boda";
        $response .= "\n2. Ntuha Truck";
        $response .= "\n3. Ntuha Taxi";    
        NtuhaRideUssd::loadMenu($response);
     }

     public static function cargoType()
     {
        $response  = "CON What do you want to transport?";         
        NtuhaRideUssd::loadMenu($response);
     }

     public static function pickUpLocation()
     {
        $response  = "CON What is your pick up location?";         
        NtuhaRideUssd::loadMenu($response);
     }

     public static function destinationLocation()
     {
        $response  = "CON What is your destination location?";         
        NtuhaRideUssd::loadMenu($response);
     }

     public static function placeRequest($data,$phone_number)
     {
        $service = "Not specified";

        if ($data[2] == 1) {
            $service = "Ntuha Boda";
        }elseif ($data[2] == 2) {
            $service = "Ntuha Truck";
        }
        elseif ($data[2] == 3) {
            $service = "Ntuha Taxi";
        }

        $customer = Customer::checkCustomer($phone_number);
        $customer = $customer->last();
        $saveNtuhaRideUssd = new NtuhaRideUssd();
        $saveNtuhaRideUssd->customer_id = $customer->id;
        $saveNtuhaRideUssd->service = $service;
        $saveNtuhaRideUssd->product = $data[3];
        $saveNtuhaRideUssd->pick_up_location = $data[4];
        $saveNtuhaRideUssd->destination_location = $data[5];
        $saveNtuhaRideUssd->save();

        $message = "We have recieved your Ntuha ride order No. ".$saveNtuhaRideUssd->id." , we shall call you shortly to confirm it. Help line: +256755223813  Thank you";

        NtuhaRideUssd::killSeesion($message);

        $admin_message = "Hello Ntuha ride, ".$customer->name." has requested for ".$saveNtuhaRideUssd->service." to transport ".$saveNtuhaRideUssd->product."  from ".$saveNtuhaRideUssd->pick_up_location." To ".$saveNtuhaRideUssd->destination_location.", contact him on ".str_replace("@gmail.com", "", $customer->email);

        DriverController::sendSMS(env('PHONE_NUMBER'),$admin_message);

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
