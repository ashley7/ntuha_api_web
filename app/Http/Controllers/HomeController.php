<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\Driver;
use App\NtuhaRideUssd;
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
        ini_set('memory_limit', '512M');

        $rides = $male = $female = $all_youth = $non_youth = $male_youth = $none_male_youth =  $female_youth = $none_female_youth = 0;

        $ageArray = $maleAgeArray = $femaleAgeArray = $gender = array();
        $working = NtuhaDashboardController::working_drivers();
        // $customers = count(NtuhaDashboardController::read_ntuha_customers());
        $customers = Customer::count();
        // $drivers = count(NtuhaDashboardController::read_ntuha_drivers());
        $drivers = Driver::count();
        $available_drivers = count(NtuhaDashboardController::drivers_available());
        $working_drivers = count($working);

        $completed_ussd = NtuhaRideUssd::where('status','completed')->count();
        $pending_ussd = NtuhaRideUssd::where('status','pending')->count();

        $famers = Customer::where('occupation','Farmer')->count();
        $commuters = Customer::where('occupation','Commuter')->count();
        $both = Customer::where('occupation','Farmer and Commuter')->count();

        $user_info_by_age = \DB::table('customers')
                 ->select('year_of_birth as age','sex', \DB::raw('count(*) as total'))
                 ->groupBy('age','sex')
                 ->get();           

        foreach ($user_info_by_age as $totalValue) {

            if ($totalValue->age < 31) {
              $all_youth = $all_youth + $totalValue->total;  
            }else{
              $non_youth = $non_youth + $totalValue->total;
            }                  

            if ($totalValue->sex == "male") {

                if ($totalValue->age < 31) {
                   $male_youth = $male_youth + $totalValue->total;
                }else{
                   $none_male_youth = $none_male_youth +  $totalValue->total;
                }

            }elseif ($totalValue->sex == "female") {

                if ($totalValue->age < 31) {
                    $female_youth = $female_youth + $totalValue->total;
                }else{
                    $none_female_youth = $none_female_youth + $totalValue->total;
                }
            }
            // ===================================
            if ($totalValue->sex == "male") {
               $male = $male + $totalValue->total;
            }elseif($totalValue->sex == "female"){
               $female = $female + $totalValue->total;
            }

        }

        $ageArray[] = ['16 to 30 (Youth)',$all_youth];
        $ageArray[] = ['Above 30',$non_youth];

        $maleAgeArray[] = ['16 to 30 (Male Youth)',$male_youth];
        $maleAgeArray[] = ['Men Above 30)',$none_male_youth];

        $femaleAgeArray[] = ['16 to 30 (Female Youth)',$female_youth];
        $femaleAgeArray[] = ['Women above 30)',$none_female_youth];

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
            'femaleOccupation' => $femaleOccupation,
            'famers' => $famers,
            'commuters' => $commuters,
            'both' => $both,
            'completed_ussd' => $completed_ussd,
            'pending_ussd' => $pending_ussd
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
