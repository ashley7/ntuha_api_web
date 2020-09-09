<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Driver;
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
        ini_set('memory_limit', '500M');

        

    
        $rides = $male = $female = 0;
        $ageArray = $maleAgeArray = $femaleAgeArray = $gender = array();
        $working = NtuhaDashboardController::working_drivers();
        // $customers = count(NtuhaDashboardController::read_ntuha_customers());
        $customers = Customer::count();
        // $drivers = count(NtuhaDashboardController::read_ntuha_drivers());
        $drivers = Driver::count();
        $available_drivers = count(NtuhaDashboardController::drivers_available());
        $working_drivers = count($working);

        $user_info_by_age = \DB::table('customers')
                 ->select('year_of_birth as age','sex', \DB::raw('count(*) as total'))
                 ->groupBy('age','sex')
                 ->get();        

        foreach ($user_info_by_age as $totalValue) {

            $ageArray[] = [$totalValue->age.' Years',$totalValue->total];

            if ($totalValue->sex == "male") {
                $maleAgeArray[] = [ucfirst($totalValue->sex).' aged '.$totalValue->age.' Years',$totalValue->total];
            }elseif ($totalValue->sex == "female") {
                $femaleAgeArray[] = [ucfirst($totalValue->sex).' aged '.$totalValue->age.' Years',$totalValue->total];
            }

            // ===================================

            if ($totalValue->sex == "male") {
               $male = $male + $totalValue->total;
            }elseif($totalValue->sex == "female"){
               $female = $female + $totalValue->total;
            }

        }

        $gender[] = ['Male',$male];
        $gender[] = ['Female',$female];


        $user_info_by_occupation = \DB::table('customers')
                 ->select('occupation','sex', \DB::raw('count(*) as total'))
                 ->groupBy('occupation','sex')
                 ->get();

        $maleOccupation = $femaleOccupation = array();

        foreach ($user_info_by_occupation as $occupation_value) {
            if ($occupation_value->sex == 'male') {
               $maleOccupation[] = [$occupation_value->occupation,$occupation_value->total];
            }

            if ($occupation_value->sex == 'female') {
               $femaleOccupation[] = [$occupation_value->occupation,$occupation_value->total];
            }
             
        }
 
        try {
            // $rides = count(NtuhaDashboardController::rides());
        } catch (\Exception $e) {}        
        
        $data = [
            'customers'=>$customers,
            'drivers'=>$drivers,
            'available_drivers'=>$available_drivers,
            'working_drivers'=>$working_drivers,
            'rides'=>$rides,
            'working'=>$working,
            'ageArray' => $ageArray,
            'femaleAgeArray' => $femaleAgeArray,
            'maleAgeArray' => $maleAgeArray,
            'gender' => $gender,
            'maleOccupation' => $maleOccupation,
            'femaleOccupation' => $femaleOccupation
        ];

        return view('home')->with($data);
    }

    public function workingDrivers()
    {
        $working = NtuhaDashboardController::working_drivers();
        $data = [
            'working' => $working
        ];

        return view('driver.working_drivers')->with($data);
    }
}
