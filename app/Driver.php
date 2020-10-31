<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name','phone_number','driver_id','identification_number','identification_type','motor_type','number_plate','service','subscription_type','location'];

    public static function randomSelector($array)
    {      
        $codeKey = array_rand($array);
        $selectedCode = $array[$codeKey];
        return  $selectedCode;
    }

    public static function locations()
    {
    	$locs = ['Mbarara','Ntungamo','Bushenyi','Isingiro','Mbarara','Bushenyi','Ntungamo','Kabale','Ibanda','Kamwenge','Fortpotal','Kasese','Bushenyi','Kazo','Rubirizi','Kitagwenda','Rwampara','Rukiga','Rukungiri','Kisoro','Kiruhura','Mbarara','Mbarara','Ntungamo'];

    	return $locs;
    }

    public static function occupn()
    {
    	$occupation = ['Commuter','Farmer','Farmer','Commuter','Farmer','Farmer'];
    	return $occupation;
    }

    public static function readDriver($driver_number)
    {
        $readDriver = Driver::where('driver_id',$driver_number)->get();

        if (count($readDriver) == 1) {
            return $readDriver->last();
        }else{
            return [];
        }
    }
}
