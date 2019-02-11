<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RideHistory;
use App\includes\AfricasTalkingGateway;
use App\Http\Controllers\DriverController;

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
        $message = "Dear ".$name.", Thank you for joining Ntuha Transport. Your password is ".$access_code;
        DriverController::sendSMS($phone_number,$message);

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
