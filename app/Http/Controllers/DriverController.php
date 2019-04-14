<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Driver;
use App\Price;
use App\includes\AfricasTalkingGateway;
use App\Http\Controllers\FrontEndController;

class DriverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $read_local_drivers = Driver::all();
        return view('driver.driver_list')->with(['read_local_drivers'=>$read_local_drivers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('driver.add_driver');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, ['input_img' => 'required|image','name'=>'required','phone_number'=>'required','driver_id'=>'required|unique:drivers','identification_number'=>'required','identification_type'=>'required','motor_type'=>'required','number_plate'=>'required','service'=>'required','subscription_type'=>'required']);

        $save_driver = new Driver($request->all());
        $save_driver->email = $request->phone_number."@gmail.com";
        $save_driver->input_img = env("DEFAULT_IMAGE");
        $save_driver->mailer = $request->mailer;
        try {         
            if ($request->hasFile('input_img')) {
                $image = $request->file('input_img');
                $name = time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('images');
                $image->move($destinationPath, $name);
                $save_driver->input_img = $name;                
            }
            $save_driver->access_key = rand(400000,500000);
            $save_driver->save();

            $message = "Dear ".$request->name.", Thank you for Joining Ntuha Ride, Your Number is ".$save_driver->driver_id." and your access key is ".$save_driver->access_key;

            $this->sendSMS($save_driver->phone_number,$message);

            


        } catch (\Exception $e) {
        	echo $e->getMessage();
        	exit();
        }
        return redirect()->route('driver.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
        	Driver::destroy($id);
        } catch (\Exception $e) {}

        return back();
    }


    public static function sendSMS($phone_number,$message)
    { 

        if ($phone_number[0] == 0) {
             $phone_number = ltrim($phone_number, '0');
        }

       
        $gateway = new AfricasTalkingGateway(env('API_USERNAME'),env('API_KEY'));
        $gateway->sendMessage("+256".$phone_number, $message);

    }

    public function activate_driver(Request $request)
    {
        $response = array();
        $driver_id = $request->driver_id;
        $access_key = $request->access_key;

        $driver = Driver::all()->where('driver_id',$driver_id)->where('access_key',$access_key)->where('status',0);

        if ($driver->count() == 0) {
             $response['status'] = "FAILED";
             $response['message'] = "Invalid Driver credetials";
             return \Response::json([$response]);
        }elseif($driver->count() == 1){
            $driver_data = $driver->last();
            $driver_data->status = 1;
            $driver_data->save();
            // read the data to upload
            $response['status'] = "SUCCESS";
            $response['name'] = $driver_data->name;
            $response['email'] = $driver_data->email;
            $response['phone'] = $driver_data->phone_number;
            $response['driver_id'] = $driver_data->driver_id;
            $response['motor_type'] = $driver_data->motor_type;
            $response['motor_plate'] = $driver_data->number_plate;
            $response['service'] = $driver_data->service;
            $response['password'] = $access_key;
            $response['subscription_type'] = $driver_data->subscription_type;
            return \Response::json([$response]);
        }
    }

    public function service_price(Request $request)
    {
        $response = array();
        $read_price = Price::all()->where('type',$request->service)->last();
        if (!empty($read_price)) {

            $balance = 0;

            if ($request->payment_method = 'Account') {
                # paying from account
                $balance = FrontEndController::account_balance($request);
            }          
          
            $response["status"] = "SUCCESS";
            $response["price"] = $read_price->price;
            $response["balance"] = $balance;
            $response["type"] = $read_price->type;
            $response["ratetype"] = $read_price->ratetype;
            $response["rate"] = $read_price->rate;

            return \Response::json([$response]);          
        }else{
            $response["status"] = "FAILED";
            $response["message"] = "No Price found";
            return \Response::json([$response]);
        }
    }


    public static function read_driver_image($driver_nunder)
    {
        $driver = Driver::all()->where('driver_id',$driver_nunder)->last();
        if (!empty($driver)) {
            return "http://45.63.91.159/images/".$driver->input_img;
        }else{
            return env("DEFAULT_IMAGE");
        }
    }
}
