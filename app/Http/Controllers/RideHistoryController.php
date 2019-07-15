<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RideHistory;
use App\includes\AfricasTalkingGateway;
use App\Http\Controllers\DriverController;
use App\Customer;
use App\Driver;

class RideHistoryController extends Controller
{


    public function record_ride(Request $request)
    {
        $save_history = new RideHistory($request->all());
        $response = array();
        try {
            $save_history->save();
            $response['status'] = "SUCCESS";
            $response['message'] = "Saved history";
             return \Response::json([$response]);
        } catch (\Exception $e) {
            $response['status'] = "FAILED";
            $response['message'] = "failed to save history";
            return \Response::json([$response]);            
        }
    }


    public function customer_register(Request $request)
    {
    
        $phone_number = $request->phone;
        $name = $request->name;
        $access_code = $request->access_code;
        
        $message = "Dear ".$name.", Thank you for joining Ntuha Ride. Your password is ".$access_code;
        
        $save_customer = new Customer();
        $save_customer->name = $name;
        $save_customer->password = $access_code;
        $save_customer->email = $phone_number.'@gmail.com';
        try {
            $save_customer->save();
            DriverController::sendSMS($phone_number,$message);
            echo $message;
        } catch (\Exception $e) {
            echo "Registration failed, please try again";
        }
        

    }

    public function customerRemeberPassword(Request $request)
    {
        $response = array();
        $phone_number = $request->phone_number;
        $customer = Customer::all()->where('email',$phone_number.'@gmail.com');
        if ($customer->count() == 0) {
            $response['status'] = "NOTFOUND";
            $response['message'] = "The user was not found.";
            return \Response::json([$response]);
        }elseif ($customer->count() == 1) {
            $single_customer = $customer->last();
            $message = "Dear ".$single_customer->name." Your password is ".$single_customer->password;
            try {
                DriverController::sendSMS($phone_number,$message);
            } catch (\Exception $e) {}
            $response['status'] = "SUCCESS";
            $response['message'] = "Password has been sent to ".$phone_number;
            return \Response::json([$response]);
        }
    }



    public function driverRemeberPassword(Request $request)
    {
        $response = array();
        $phone_number = $request->phone_number;
        $driver = Driver::all()->where('email',$phone_number.'@gmail.com');
        if ($driver->count() == 0) {
            $response['status'] = "NOTFOUND";
            $response['message'] = "The user was not found.";
            return \Response::json([$response]);
        }elseif ($driver->count() == 1) {
            $single_driver = $driver->last();
            $message = "Dear ".$single_driver->name." Your password is ".$single_driver->access_key;
            try {
                DriverController::sendSMS($phone_number,$message);
            } catch (\Exception $e) {}
            $response['status'] = "SUCCESS";
            $response['message'] = "Password has been sent to ".$phone_number;
            return \Response::json([$response]);
        }
    }


    public static function rendomString()
    {
        $characters = '23456789';
        $charactersLength = strlen($characters);
        $randomString = '';
            for ($i = 0; $i < 6; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
        return $randomString;
    }




    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }
}
