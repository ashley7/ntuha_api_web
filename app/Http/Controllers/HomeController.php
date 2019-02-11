<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\NtuhaDashboardController;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rides = 0;
        $working = NtuhaDashboardController::working_drivers();
        $customers = count(NtuhaDashboardController::read_ntuha_customers());
        $drivers = count(NtuhaDashboardController::read_ntuha_drivers());
        $available_drivers = count(NtuhaDashboardController::drivers_available());
        $working_drivers = count($working);
        try {
            $rides = count(NtuhaDashboardController::rides());
        } catch (\Exception $e) {}
        
        
        $data = ['customers'=>$customers,'drivers'=>$drivers,'available_drivers'=>$available_drivers,'working_drivers'=>$working_drivers,'rides'=>$rides,'working'=>$working];
        return view('home')->with($data);
    }
}
