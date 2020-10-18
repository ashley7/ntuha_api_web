<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Driver;

class Customer extends Model
{
    public static function saveCustomer($first_name,$last_name,$sex,$year_of_birth,$disability_status,$location,$occupation,$sign_up_date,$description,$phone_number,$agent_name)
    {      

    	$saveCustomer = new Customer();
        $saveCustomer->first_name = $first_name;
        $saveCustomer->last_name = $last_name;
        $saveCustomer->name = $last_name." ".$first_name;
        $saveCustomer->sex = $sex;
        $saveCustomer->year_of_birth = $year_of_birth;
        $saveCustomer->disability_status = $disability_status;

        // if (empty($location)) {
            $saveCustomer->location = Driver::randomSelector(Driver::locations());
        // }else{
        //     $saveCustomer->location =  $location;
        // }

        // if (empty($occupation)) {
            $saveCustomer->occupation = Driver::randomSelector(Driver::occupn());
        // }else{
        //     $saveCustomer->occupation = $occupation;
        // }        
        
        $saveCustomer->sign_up_date = $sign_up_date;
        $saveCustomer->description = $description;
        $saveCustomer->email = $phone_number."@gmail.com";
        $saveCustomer->password = rand(400000,500000);
        $saveCustomer->agent_name = $agent_name;
        try {
        	 $saveCustomer->save();
        } catch (\Exception $e) {}
       
        return $saveCustomer;
    }

    public static function checkCustomer($phone_number)
    {
        return Customer::where('email',$phone_number."@gmail.com")->get();         
    }

   
}
