<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\NtuhaDashboardController;
use App\User;
use App\Customer;
use App\Driver;
use App\Http\Controllers\DriverController;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();

        $data = [

            'users' => $users,
            'title' => 'List of users',
        ];

        return view('user.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Create user',
        ];
        return view('user.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' =>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
        ];

        $this->validate($request,$rules);

        $pin = rand(400000,500000);

        $save_user = new User($request->all());
        $save_user->password = bcrypt($pin);
        $save_user->email_verified_at = now();
        $save_user->remember_token = str_random(32);
        $save_user->save();

        $sms = "Dear ".$save_user->name." your Ntuha ride password is ".$pin." Visit ".$_SERVER['HTTP_HOST']." to Login";

        NtuhaDashboardController::send_Email($save_user->email,"Ntuha ride password",$sms,"ntuha.deliveries@gmail.com");

        $data = [
            'status'=>'User created successfully'
        ];

        return redirect()->route('user.index')->with($data);

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
            User::destroy($id);
        } catch (\Exception $e) {}

        return back();
    }


    public function sendNotification(Request $request)
    {
        $customer_phone = $request->customer_phone;

        $driver_phone_number = $request->driver_phone."@gmail.com";

        $customer = Customer::checkCustomer($customer_phone);

        if (count($customer) > 0) {
            
            $customer = $customer->last();

            $readDriver = Driver::where('email',$driver_phone_number)->get();

            if (count($readDriver) > 0) {

                $driver = $readDriver->last();

                $message = "Hello, ".$customer->name." your Ntuha ride with ".$driver->name." (No.".$driver->driver_id."), to ".$request->to." has started.";

                DriverController::sendSMS($customer_phone,$message);

                echo $message;

            }else{
                echo "No Driver with Phone Number ".$driver_phone_number;
            }

        }
        else{
            echo "No User with ".$customer_phone;
        }
         
    }      

}
