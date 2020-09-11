<?php

namespace App\Http\Controllers;

use App\NtuhaRide;
use App\Driver;
use Illuminate\Http\Request;

class NtuhaRideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
      return NtuhaRide::getDays('2019-04-12 18:49:17',now(),11);

       

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Driver::where('status',1)->chunk(1, function ($drivers) {

            $taxi_rates = [10000,15000,24000,13500,12000,10000,14000,8000,17000];
            $boda_rates = [1000,1500,2000,2500,1000,1500,3500,5000,2000];
            $truck_rates = [35000,50000,25000,54000,50000,55000,35000];
            $rideCount = [10,7,8,5,11];
            
            $from_locations = [];
            $to_locations = [];

            $ntuha_amount = $amount = 1000;

            foreach ($drivers as $driver) {

                $customers = Customer::whereDate('sign_up_date','>',$driver->created_at)->inRandomOrder()->limit(30)->get();

                foreach ($customers as $customer) {

                   $number_of_rides = NtuhaRide::randomItemSeletor($rideCount);

                    if (empty($customer->sign_up_date)) continue;                   

                    $days_riden = NtuhaRide::getDays($customer->sign_up_date,now(),$number_of_rides);//array of dates

                    foreach ($days_riden as $dates) {

                        $from = NtuhaRide::randomItemSeletor($from_locations);
                        $to = NtuhaRide::randomItemSeletor($to_locations);

                        if ($driver->service = "Ntuha Boda") {
                            $ntuha_amount = 200;
                            $amount = NtuhaRide::randomItemSeletor($boda_rates);
                        }if ($driver->service == "Ntuha Taxi") {
                            $ntuha_amount = 500;
                            $amount = NtuhaRide::randomItemSeletor($taxi_rates);
                        }else{
                            $amount = NtuhaRide::randomItemSeletor($truck_rates); 
                        }

                        NtuhaRide::saveRide($driver->id,$customer->,$amount,$from,$to,$dates->date,$dates->month,$ntuha_amount);
                    }                  
                }            
            }

        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NtuhaRide  $ntuhaRide
     * @return \Illuminate\Http\Response
     */
    public function show($ntuhaRide)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NtuhaRide  $ntuhaRide
     * @return \Illuminate\Http\Response
     */
    public function edit( $ntuhaRide)
    {
          
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NtuhaRide  $ntuhaRide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NtuhaRide $ntuhaRide)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NtuhaRide  $ntuhaRide
     * @return \Illuminate\Http\Response
     */
    public function destroy(NtuhaRide $ntuhaRide)
    {
        //
    }
}
