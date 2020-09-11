<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NtuhaRide extends Model
{
    public static function saveRide($driver_id,$customer_id,$amount,$from,$to,$date,$month_year,$ntuha_amount)
    {
    	$save_ride = new NtuhaRide();
    	$save_ride->driver_id = $driver_id;
    	$save_ride->customer_id = $customer_id;
    	$save_ride->from = $from;
    	$save_ride->to = $to;
    	$save_ride->amount = $amount;
        $save_ride->date = $date;
        $save_ride->month_year = $month_year;
        $save_ride->ntuha_amount = $ntuha_amount;
    	$save_ride->save();
    }

    public static function getDays($from,$to,$sizeOfData)
    {
        $period = new \DatePeriod(new \DateTime($from),new \DateInterval('P1D'),new \DateTime($to));//get all days btn the date customer was created and today

        $dates = $month_year = $dataValues = array();

        foreach ($period as $key => $value) {

           $dates[] = ['date'=>$value->format('Y-m-d'), 'month'=>$value->format('Y-m')];//puck them together       

        }

        $keys = array_rand($dates, $sizeOfData);//select random N days from them

        foreach ($keys as $k => $value) {
            $dataValues[] = $dates[$value];
        }

        sort($dataValues);//sort those days

        return $dataValues;
    }

    public static function randomItemSeletor($arrayObject)
    {
        $key = array_rand($arrayObject);
        return $arrayObject[$key];
    }

  
}
