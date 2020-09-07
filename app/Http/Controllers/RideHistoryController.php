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
        $age = rand(18,30);
        if (isset($request->year_of_birth)) {
            $age = $request->year_of_birth;
        }

        $occupation = Driver::randomSelector(Driver::occupn());

        if (isset($request->occupation)) {
           $occupation = $request->occupation;
        }

        $destination_location = 'not disabled';

        if (isset($request->destination_location)) {
           $destination_location = $request->destination_location;
        }

        $gender = "female";
        if (isset($request->gender)) {
            $gender = $request->gender;
        }
        
        $save_customer = new Customer();
        $save_customer->name = $name;
        $save_customer->password = $access_code;
        $save_customer->email = $phone_number.'@gmail.com';
        $save_customer->year_of_birth = $age;
        $save_customer->gender = strtolower($gender);
        $save_customer->occupation = strtolower($occupation);
        $save_customer->sign_up_date = now();
        $save_customer->destination_location = strtolower($destination_location);
        $save_customer->agent_name = "Android";
        $save_customer->location = Driver::randomSelector(Driver::locations());
        try {
            $save_customer->save();
            DriverController::sendSMS($phone_number,$message);
            return $message;
        } catch (\Exception $e) {
            return "Registration failed, please try again";
        }       

    }

    public function customerRemeberPassword(Request $request)
    {
        $response = array();
        $phone_number = $request->phone_number;
        $customer = Customer::where('email',$phone_number.'@gmail.com')->get();
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


    public function assignThemAge()
    {

        Customer::chunk(1, function ($users) {

            foreach ($users as $user) {

                $customer = Customer::find($user->id);                

                if (empty($customer->year_of_birth)) {
                    $customer->location = Driver::randomSelector(Driver::locations());
                    $customer->occupation = Driver::randomSelector(Driver::occupn());
                    $customer->year_of_birth = rand(18,30);
                    $customer->sign_up_date = $customer->created_at;
                    $customer->agent_name = "Android";
                    $customer->save();                         
                } else{
                    try {
                        $current_age = $customer->year_of_birth;
                        if (strlen($current_age) == 4) {
                            $new_age = date("Y") - (int)$customer->year_of_birth;
                            $customer->year_of_birth = $new_age;
                            $customer->save();
                        }
                                             
                        
                    } catch (\Exception $e) {}
                   
                    // return $customer;
                    // exit();
                }               
            }
        }); 
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
