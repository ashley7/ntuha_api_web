<?php

namespace App\Http\Controllers;

use App\NtuhaRideUssd;
use App\Customer;
use App\NtuhaRide;
use App\Driver;
use Illuminate\Http\Request;

class NtuhaRideUssdController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $ussdRequest = NtuhaRideUssd::orderBy('id','DESC')->get();

       $data = [
        'ussd_request' => $ussdRequest
       ];

       return view('ussd.ussd_request')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [

            'title' => 'Select date ranges for USSD',           

        ];

        return view("reports.gen_ussd_report")->with($data);
    }

    public function genUssdReport(Request $request)
    {

        $days = $ntuha_totals  = $records = [];

        $ntuha_count  = $record_count = [];

        $driver_report = NtuhaRideUssd::whereBetween('created_at',[$request->from."-1 day",$request->to."+1 day"])->get();

        $read_ntuha_ride = NtuhaRideUssd::whereBetween('created_at',[$request->from."-1 day",$request->to."+1 day"])->select([\DB::raw('DATE(created_at) AS date'),\DB::raw('SUM(amount) AS total'), \DB::raw('COUNT(*) AS total_rides')])->groupBy('date')->orderBy('date')->get();

        $records['name'] = 'Daily USSD revenue';
        $record_count['name'] = 'No. of daily USSD ride';

        foreach ($read_ntuha_ride as $value) {

            $days[] = $value->date;

            $ntuha_totals[] =  $value->total;

            $ntuha_count[] =   $value->total_rides; 

        }

        $array_data = array();

        $records['data'] = $ntuha_totals; 

        $record_count['data']  = $ntuha_count;

        array_push($array_data,$records);
        array_push($array_data,$record_count);

        $title = "USSD rides between ".$request->from." and ".$request->to;

        $data = [

            'ussd_request' => $driver_report,
            'title' => $title,
            'records' => json_encode($array_data),
            'days' => json_encode($days),
        ];
 
        return view('reports.ussd_ride_report')->with($data);


         
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        header('Content-type: text/plain');

        $phoneNumber = $request["phoneNumber"];//this is phone number sending the request

        $phoneNumber = ltrim($phoneNumber, '+256');

        $phoneNumber = "0".$phoneNumber;

        $userInPut = $request["text"];//this is the input from the user

        if (empty($userInPut)) {

            $userInPut = "0";//if there is no input, set to "0" to target main menu

        }else{
            $userInPut = "0*".$request["text"]; 
        }

        $data = explode("*",trim($userInPut));

        $level = count($data);

        switch ($level) {
            case 1:                

                NtuhaRideUssd::welcomeMessage();

                break;

            case 2:
                $option = $data[1];
                switch ($option) {
                    case 1:# He chose to register

                        $customer = Customer::checkCustomer($phoneNumber);

                        if (count($customer) > 0) {

                            $customer = $customer->last();
                            NtuhaRideUssd::killSeesion("Hello ".$customer->name.", you already have an account with Ntuha ride, Simply place your request");
                            return;
                             
                        } 
                         NtuhaRideUssd::promptName();
                         break;

                    case 2:# he chose to place a request

                        NtuhaRideUssd::selectService($phoneNumber);
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }

                break;

            case 3:
                $option = $data[1];

                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::promptGender();
                         break;

                    case 2:# he chose to place a request

                        NtuhaRideUssd::cargoType();
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }


                break;

            case 4:
                $option = $data[1];

                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::promptDistrict();
                         break;

                    case 2:# he chose to place a request

                         NtuhaRideUssd::pickUpLocation();
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }
                break;

            case 5:
                $option = $data[1];

                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::promptAge();
                         break;

                    case 2:# he chose to place a request

                        NtuhaRideUssd::destinationLocation();
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }
                break;

            case 6:
                $option = $data[1];

                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::disAbility();
                         break;

                    case 2:# he chose to place a request

                        NtuhaRideUssd::placeRequest($data,$phoneNumber);
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }
                break;

            case 7:
                $option = $data[1];

                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::occupation($data,$phoneNumber);
                         break;

                    case 2:# he chose to place a request
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }
                break;

            case 8:
                 $option = $data[1];

                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::saveCustomer($data,$phoneNumber);
                         break;

                    case 2:# he chose to place a request
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }
                break;

                break;
             
            
            default:
                # code...
                break;
        }




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NtuhaRideUssd  $ntuhaRideUssd
     * @return \Illuminate\Http\Response
     */
    public function show($ntuhaRideUssd)
    {       


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NtuhaRideUssd  $ntuhaRideUssd
     * @return \Illuminate\Http\Response
     */
    public function edit( $ntuhaRideUssd)
    {
        $readNtuhaRideUssd = NtuhaRideUssd::find($ntuhaRideUssd);

        $data = [
            'readNtuhaRideUssd' => $readNtuhaRideUssd
        ];

        return view('ussd.edit_request')->with($data);       

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NtuhaRideUssd  $ntuhaRideUssd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $ntuhaRideUssd)
    {

        if ($request->status == "completed") {

            $check_driver = Driver::readDriver($request->driver_number);

            if (empty($check_driver)) 

               return back()->with(['status'=>'Driver not found in the system']);
            
        }

        $update = NtuhaRideUssd::find($ntuhaRideUssd);
        $update->service = $request->service;
        $update->product = $request->product;
        $update->pick_up_location = $request->pick_up_location;
        $update->destination_location = $request->destination_location;
        $update->status = $request->status;
        $update->amount = $request->amount;
        $update->driver_id = $check_driver->id;

        try {

            $update->save();

             if ($request->status == "completed") {
                $driver = Driver::readDriver($request->driver_number);

                $ntuha_amount = 200;

                 if ($driver->service == "Ntuha Boda") {
                    $ntuha_amount = 200;                    
                }elseif ($driver->service == "Ntuha Taxi") {
                    $ntuha_amount = 500;                   
                }elseif($driver->service == "Ntuha Truck"){
                    $ntuha_amount = 1000;                   
                }else{
                    $ntuha_amount = 200;                  
                }

                NtuhaRide::saveRide($driver->id,$update->customer_id,$update->amount,$update->pick_up_location,$update->destination_location,date('Y-m-d'),date('Y-m'),$ntuha_amount);

            }


           
        } catch (\Exception $e) {}

        return redirect('ussd_requests');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NtuhaRideUssd  $ntuhaRideUssd
     * @return \Illuminate\Http\Response
     */
    public function destroy(NtuhaRideUssd $ntuhaRideUssd)
    {
        //
    }

    public function provideDriver()
    {

        $rideRequests = NtuhaRideUssd::select('customer_id','service','id')->where('status','completed')->get();

        foreach ($rideRequests as $value) {

            $read_driver = NtuhaRide::select('driver_id')->where('customer_id',$value->customer_id)->get()->last();

            if (empty($read_driver)) continue;

            $updateNtuhaRideUssd = NtuhaRideUssd::find($value->id);

            $updateNtuhaRideUssd->driver_id = $read_driver->driver_id;
            
            $updateNtuhaRideUssd->save();           
            
        }
        
    }
}
