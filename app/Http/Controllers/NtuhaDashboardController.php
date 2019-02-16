<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory; 
use Kreait\Firebase\ServiceAccount; 
use Kreait\Firebase\Database;


class NtuhaDashboardController extends Controller
{


    public function databaseObject()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.''.env('FIREBASE_CREDENTIALS'));
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri(env('FIREBASE_DATABASE'))->create();

        return $firebase;
    }

    /*
      returns all customers
    */
    public static function read_ntuha_customers()
    {
        /** 

         * @connections Connection to the database
         * @return a database instance

        */     
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.''.env('FIREBASE_CREDENTIALS'));
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri(env('FIREBASE_DATABASE'))->create();

        $database = $firebase->getDatabase();

        $customers = $database->getReference('Users')->getChild("Customers");
       // $customers = $reference->getChild("Customers");
        $customer_data = [];
        if (!empty($customers->getValue())) {
            
            foreach ($customers->getValue() as $customer_key => $customer) {
                if (gettype($customer)=="array") {
                    foreach ($customer as $key => $customerValueDetails) {
                       if (gettype($customerValueDetails) != "array") {
                        $result = [];
                        try {
                           $result["customeId"] = $customer_key;
                           $result['name'] = $customer['name'];
                           $result['phone'] = $customer['phone'];
                           if (!isset($customer['profileImageUrl'])) {
                             $result['profileImageUrl'] = "default.jpg";
                           }else{
                              $result['profileImageUrl'] = $customer['profileImageUrl'];
                          }
                           $customer_data[] = $result;   
                        } catch (\Exception $e) {
                          echo $e->getMessage();
                          exit();
                        }
                                                  
                       }
                    } 
                }
            }
        }

        $data = array_unique($customer_data, SORT_REGULAR);
        return (array)$data;
        // return response()->json($data);
    }

    /*
       returns all drivers
    */
    public static function read_ntuha_drivers()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.''.env('FIREBASE_CREDENTIALS'));
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri(env('FIREBASE_DATABASE'))->create();

        $database = $firebase->getDatabase();

        $reference = $database->getReference('Users');
        $drivers = $reference->getChild("Drivers");
        $driver_data = [];
        if (!empty($drivers->getValue())) {
           
            foreach ($drivers->getValue() as $driver_key => $driver) {
                if (gettype($driver)=="array") {
                    foreach ($driver as $key => $driverValueDetails) {
                       if (gettype($driverValueDetails) != "array") {
                        $result = [];
                        try {
                            $result["driverId"] = $driver_key;
                            $result['name'] = $driver['name'];
                            $result['car'] = $driver['car'];
                            $result['service'] = $driver['service'];
                            $result['phone'] = $driver['phone'];
                            $result['driver_id'] = $driver['driver_id'];
                            if (!isset($driver['profileImageUrl'])) {
                             $result['profileImageUrl'] = "default.jpg";
                            }else{
                              $result['profileImageUrl'] = $driver['profileImageUrl'];
                            }
                            $driver_data[] = $result;  
                            
                        } catch (\Exception $e) {}
                                                 
                       }else{
                          // $result = [];
                          // $result['history'] = (array)$driverValueDetails;
                          // $driver_data[] = $result;
                       }
                    } 
                }
            }
        }
        $data = array_unique($driver_data, SORT_REGULAR);
        return (array)$data;
        // return response()->json($data);   
    }

    /*

      1. Taken in Customer or Driver as user type and the key of that user
      2. return the history recods of single user

    */
    public static function single_user_history($user_type,$user_id)
    {

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.''.env('FIREBASE_CREDENTIALS'));
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri(env('FIREBASE_DATABASE'))->create();

        $database = $firebase->getDatabase();

        $driver = NtuhaDashboardController::user_details($user_type,$user_id);
        $history_data = array();
        foreach ($driver as $data_key => $data_value) {
            // for each history, read details
            if (!empty($data_value['history'])) {
            
                foreach ($data_value['history'] as $key_data => $key_value) {
                    $history_refrence_reference = $database->getReference('history')->getChild($key_data)->getValue();
                    array_push($history_data,$history_refrence_reference);
                }
            }
        }

        return $history_data;

    }

    /*

    1. Takes in Driver or Customer as $user_type and the ket of that entity
    2. Returns the user details

    */ 

    public static function user_details($user_type,$user_id)
    {
        $data = array();
       $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.''.env('FIREBASE_CREDENTIALS'));
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri(env('FIREBASE_DATABASE'))->create();

        $database = $firebase->getDatabase();

        $reference = $database->getReference('Users');
        $user = $reference->getChild($user_type)->orderByKey()->equalTo($user_id)->getValue();
        return $user;//this is a single object for one user
    }

    public static function single_customer($customer_id)
    {
        $data = array();
         foreach (NtuhaDashboardController::user_details("Customers",$customer_id) as $key => $value) {
            $result = [];
            try {
                $result['name'] = $value['name'];
                $result['phone'] = $value['phone'];         
                 if (!isset($value['profileImageUrl'])) {
                   $result['profileImageUrl'] = "default.jpg";
                  }else{
                    $result['profileImageUrl'] = $value['profileImageUrl'];
                  }
                $data[] = $result; 
            } catch (\Exception $e) {}
                      
        }
        return $data;
     }


    public static function single_driver($driver_id)
    {
        $data = array();
         foreach (NtuhaDashboardController::user_details("Drivers",$driver_id) as $key => $value) {
            $result = [];
            try {
               $result['name'] = $value['name'];
               $result['phone'] = $value['phone'];
               $result['car'] = $value['car'];
               $result['car_plate'] = $value['car_plate'];
               $result['service'] = $value['service'];
               $result['driver_id'] = $value['driver_id'];
               // $result['profileImageUrl'] = $value['profileImageUrl'];
               if (!isset($value['profileImageUrl'])) {
                 $result['profileImageUrl'] = "default.jpg";
                }else{
                  $result['profileImageUrl'] = $value['profileImageUrl'];
                }
               $data[] = $result; 
            } catch (\Exception $e) {}
                      
        }
        return $data;
     }
    

    /*

      1. return all the rides

    */
    public static function rides()
    {
        $rides_data = array();

        // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/ntuhatransport-firebase-adminsdk-9e7cu-56ffdea3cf.json');
        // $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://ntuhatransport.firebaseio.com/')->create();

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.''.env('FIREBASE_CREDENTIALS'));
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri(env('FIREBASE_DATABASE'))->create();

        $database = $firebase->getDatabase();

        $rides = $database->getReference('history')->getValue();
        if (!empty($rides)) {
            
            foreach ($rides as $key_key => $ride_value) {
                $result = [];
                try {
                  
                    $result["customer_name"] = $ride_value['customer_name'];
                    $result["distance"] = $ride_value['distance'];
                    $result["driver"] = NtuhaDashboardController::single_driver($ride_value['driver']);
                    $result["from"] = $ride_value['from'];
                    $result["to"] = $ride_value['destination'];
                    $result["rating"] = $ride_value['rating'];
                    $result["timestamp"] = $ride_value['timestamp'];
                    $result["amount_paid"] = $ride_value['amount_paid'];
                    $rides_data[] = $result;
             
              } catch (\Exception $e) {}
            }
            $data = array_unique($rides_data, SORT_REGULAR);
            return (array)$data;
            // return response()->json($data);
        }
    }

/*
  This returns drivers that are active, but now warking
*/ 
    public static function drivers_available()
    {
        $rides_data = array();

        // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/ntuhatransport-firebase-adminsdk-9e7cu-56ffdea3cf.json');
        // $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://ntuhatransport.firebaseio.com/')->create();

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.''.env('FIREBASE_CREDENTIALS'));
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri(env('FIREBASE_DATABASE'))->create();
        $database = $firebase->getDatabase();

        $driversAvailable = $database->getReference('driversAvailable')->getValue();
        if (isset($driversAvailable)) {
         
        foreach ($driversAvailable as $key => $driver_value) {
            $driver = NtuhaDashboardController::single_driver($key);
            foreach ($driver as $driver_value) {
                $data = array();
                $data['name'] = $driver_value['name'];
                $data['phone'] = $driver_value['phone'];
                $data['car'] = $driver_value['car'];
                $data['service'] = $driver_value['service'];
                // $data['profileImageUrl'] = $driver_value['profileImageUrl'];
                if (!isset($driver_value['profileImageUrl'])) {
                   $result['profileImageUrl'] = "default.jpg";
                  }else{
                    $result['profileImageUrl'] = $driver_value['profileImageUrl'];
                  }
                array_push($rides_data, $data);
                
            }
          }
        }
        return (array)$rides_data;
        // return response()->json($rides_data);
    }

    /*
       This will return all the drivers that are working
    */ 

   public static function working_drivers()
   {
        $rides_data = array();
        // $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/ntuhatransport-firebase-adminsdk-9e7cu-56ffdea3cf.json');
        // $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://ntuhatransport.firebaseio.com/')->create();

        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.''.env('FIREBASE_CREDENTIALS'));
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri(env('FIREBASE_DATABASE'))->create();

        $database = $firebase->getDatabase();

        $working_drivers = $database->getReference('driversWorking')->getValue();

        if (isset($working_drivers)) {
          foreach ($working_drivers as $key => $driver_value) {
            array_push($rides_data, NtuhaDashboardController::single_driver($key));
          }
      }
        return (array)$rides_data;
        // return response()->json($rides_data);         
    }






    public static function getAddress($latitude,$longitude){    

      $geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false'); 
      $output = json_decode($geocodeFromLatLong);
      $status = $output->status;
      $address = ($status=="OK")?$output->results[1]->formatted_address:''; 

      echo  $address; 
    }


/*
  1. read customers [done]
  2. read drivers [done]
  3. Read customer history [done]
  4. Read Driver history [done]
  5. Count THEM
  6. Rides btn periods
  7. Read single data for user[done]
*/
    public function index()
    {  
     
        $phone_number = ltrim("0787444081", '0');
        echo "+256".$phone_number;
       
    }    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
 
   
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
