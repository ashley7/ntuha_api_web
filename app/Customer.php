<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        $saveCustomer->location = $location;
        $saveCustomer->occupation = $occupation;
        $saveCustomer->sign_up_date = $sign_up_date;
        $saveCustomer->description = $description;
        $saveCustomer->email = $phone_number."@gmail.com";
        $saveCustomer->password = rand(400000,500000);
        $saveCustomer->agent_name = $agent_name;
        $saveCustomer->save();
        return $saveCustomer;
    }
}
