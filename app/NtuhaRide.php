<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NtuhaRide extends Model
{
    public static function saveRide($driver_id,$customer_id,$amount,$from,$to)
    {
    	$save_ride = new NtuhaRide();
    	$save_ride->driver_id = $driver_id;
    	$save_ride->customer_id = $customer_id;
    	$save_ride->from = $from;
    	$save_ride->to = $to;
    	$save_ride->amount = $amount;
    	$save_ride->save();
    }

  
}
