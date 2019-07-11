<?php

namespace App\Http\Controllers;

use App\DriverTopup;
use Illuminate\Http\Request;
use App\Driver;
use App\Customer;
use App\Http\Controllers\DriverTopupController;

class DriverTopupController extends Controller
{
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DriverTopup  $driverTopup
     * @return \Illuminate\Http\Response
     */
    public function show(DriverTopup $driverTopup)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DriverTopup  $driverTopup
     * @return \Illuminate\Http\Response
     */
    public function edit(DriverTopup $driverTopup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DriverTopup  $driverTopup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DriverTopup $driverTopup)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DriverTopup  $driverTopup
     * @return \Illuminate\Http\Response
     */
    public function destroy(DriverTopup $driverTopup)
    {
        //
    }

    public function checkUser(Request $request)
    {

        $phone_number = $request->phone_number;

        $check_customer = Customer::all()->where('email',$phone_number."@gmail.com")->last();

        if (empty($check_customer)) {
            echo "Phone Number not found";
            return;
        }

        echo $check_customer->name;     

    }


     public static function check_user($phone_number)
    {      

        $check_customer = Customer::all()->where('email',$phone_number."@gmail.com")->last();

        if (empty($check_customer)) {
             
            return "Phone Number not found ";
        }

        return $check_customer->name;     

    }


    public function driverTopUp(Request $request)
    {

        $phone_number = $request->phone_number;

        $check_driver = Driver::all()->where('driver_id',$request->driver_id)->last();

        if (empty($check_driver)) {
            echo "Driver Not found";
            return;
        }

        if ($check_driver->access_key != $request->pin) {

            echo "Driver Pin is Incorrect";
            return;
             
        }

        // update the wallet

        $save_payment = new Payment();
        $save_payment->email  = $phone_number."@gmail.com";
        $save_payment->amount = $request->amount;
        $save_payment->status = "successful";
        $save_payment->transaction_id = time();
        $save_payment->paying_phone_number = "Driver";
        $save_payment->phone_number = $phone_number;
        $save_payment->customer_name = DriverTopupController::check_user($phone_number);
        $save_payment->save();

        // record driver
        $driverTopup = new DriverTopup();
        $driverTopup->amount = $save_payment->amount;
        $driverTopup->customer_name = $save_payment->customer_name;
        $driverTopup->customer_email = $save_payment->email;
        $driverTopup->driver_id = $request->driver_id;

        $driverTopup->save();

        echo "You have successfuly toped up UGX ".$save_payment->amount." on ".$save_payment->customer_name."'s Wallet";
         
    }
}
