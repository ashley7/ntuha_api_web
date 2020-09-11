<?php

namespace App\Http\Controllers;

use App\NtuhaRide;
use App\Driver;
use App\Customer;
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
      $read_ntuha_rides = NtuhaRide::orderBy('date')->paginate(100);

      $data = [
        'read_ntuha_rides' => $read_ntuha_rides,
        'title' => 'List of rides'
      ];

      return view('rides')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Driver::where('status',1)->chunk(1, function ($drivers) {          

            $ntuha_amount = $amount = 1000;

            foreach ($drivers as $driver) {

                $customers = Customer::whereDate('sign_up_date','>',$driver->created_at)->inRandomOrder()->limit(30)->get();

                foreach ($customers as $customer) {

                   $number_of_rides = NtuhaRide::randomItemSeletor([10,7,8,5,11]);

                    if (empty($customer->sign_up_date)) continue;                   

                    $days_riden = NtuhaRide::getDays($customer->sign_up_date,now(),$number_of_rides);//array of dates

                    foreach ($days_riden as $dates) {

                        $locations = NtuhaRide::movementLocations();

                        $boda_rates = [2000,1500,2000,2500,2000,1500,3500,5000,2000];

                        $taxi_rates = [10000,15000,24000,13500,12000,10000,14000,8000,17000];
                        
                        $truck_rates = [35000,50000,25000,54000,50000,55000,35000];

                        if ($driver->service == "Ntuha Boda") {

                            $ntuha_amount = 200;

                            $amount = NtuhaRide::randomItemSeletor($boda_rates);

                        }elseif ($driver->service == "Ntuha Taxi") {

                            $ntuha_amount = 500;

                            $amount = NtuhaRide::randomItemSeletor($taxi_rates);

                        }elseif($driver->service == "Ntuha Truck"){

                            $ntuha_amount = 1000;

                            $amount = NtuhaRide::randomItemSeletor($truck_rates); 

                        }else{
                            $ntuha_amount = 200;
                            $amount = 1500;
                        }

                        NtuhaRide::saveRide($driver->id,$customer->id,$amount,$locations[0],$locations[1],$dates["date"],$dates["month"],$ntuha_amount);
                    }                  
                }            
            }

        });

        return redirect('ntuha_rides');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
