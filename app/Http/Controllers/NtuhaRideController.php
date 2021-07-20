<?php

namespace App\Http\Controllers;

use App\NtuhaRide;
use App\Driver;
use App\Customer;
use Carbon\Carbon;
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

        Driver::where('status',1)->orderBy('id','DESC')->limit(500)->chunk(1, function ($drivers) {

            $ntuha_amount = $amount = 1000;

            $counter = 0;

            $numRides = NtuhaRide::randomItemSeletor([2,3,1,4,5]);

            foreach ($drivers as $driver) {

                $customers = Customer::whereDate('sign_up_date','>',$driver->created_at)->inRandomOrder()->limit(100)->get();                

                foreach ($customers as $customer) {

                   $number_of_rides = NtuhaRide::randomItemSeletor([1,2,3]);

                    if (empty($customer->sign_up_date)) continue;                   

                    $days_riden = NtuhaRide::getDays($customer->sign_up_date,Carbon::yesterday()->toDateString(),$number_of_rides);//array of dates

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

                        
                        if ($counter < $numRides) {
                            NtuhaRide::saveRide($driver->id,$customer->id,$amount,$locations[0],$locations[1],$dates["date"],$dates["month"],$ntuha_amount);
                        }

                        $counter ++;

                        
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

        $reportname = $request->report_name;

        $days = $records = $totals = $ntuha_totals = $ntuha_records = $ntuhatotals = [];

        if ($reportname == "revenue") {

            $read_ntuha_ride = NtuhaRide::whereBetween('date',[$request->from."-1 day",$request->to."+1 day"])->select([\DB::raw('DATE(date) AS date'),\DB::raw('SUM(amount) AS total'),\DB::raw('SUM(ntuha_amount) as ntuha_amount')])->groupBy('date')->orderBy('date')->get();

            $title = "Transactions from ".$request->from." to ".$request->to;

            $records['name'] = 'Overall revenue';

            $ntuha_records['name'] = 'Ntuha revenue';

            foreach ($read_ntuha_ride as $value) {

              $days[] = $value->date;

              $totals[] =  $value->total;

              $ntuhatotals[] = $value->ntuha_amount;

            } 

            $records['data'] = $totals;  

            $ntuha_records['data'] = $ntuhatotals;

            $all_data  = array();

            array_push($all_data,$records);

            array_push($all_data,$ntuha_records);
             
            $data = [               
                'title' => $title,
                'from' => $request->from,
                'to' => $request->to,
                'records' => json_encode($all_data),
                'days' => json_encode($days),
            ];
 
            return view('reports.revenue_report')->with($data);

        }


        
    }

    public function getRevenueReports()
    {
        return view('reports.get_revenue_reports')->with(['title'=>'Generate revenue report']);
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
