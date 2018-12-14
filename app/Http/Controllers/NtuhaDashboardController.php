<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory; 
use Kreait\Firebase\ServiceAccount; 
use Kreait\Firebase\Database;

class NtuhaDashboardController extends Controller
{


    /** 

     * @connections Connection to the database
     * @return a database instance

    */     

    public static function connection_to_firebase()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/ntuhatransport-firebase-adminsdk-9e7cu-56ffdea3cf.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://ntuhatransport.firebaseio.com/')->create();       
        return $firebase->getDatabase();
    }

    /*
      returns all customers
    */
    public static function read_ntuha_customers()
    {
        $reference = $this->connection_to_firebase()->getReference('Users');
        $customers = $reference->getChild("Customers");
        if (!empty($customers->getValue())) {
            $customer_data = [];
            foreach ($customers->getValue() as $customer_key => $customer) {
                if (gettype($customer)=="array") {
                    foreach ($customer as $key => $customerValueDetails) {
                       if (gettype($customerValueDetails) != "array") {
                        $result = [];
                        try {
                           $result["customeId"] = $customer_key;
                           $result['name'] = $customer['name'];
                           $result['phone'] = $customer['phone'];
                           $result['profileImageUrl'] = $customer['profileImageUrl'];
                           $customer_data[] = $result;   
                        } catch (\Exception $e) {}
                                                  
                       }
                    } 
                }
            }
        }
        $data = array_unique($customer_data, SORT_REGULAR);
        return response()->json($data);
    }

    /*
       returns all drivers
    */
    public static function read_ntuha_drivers()
    {
        $reference = $this->connection_to_firebase()->getReference('Users');
        $drivers = $reference->getChild("Drivers");
        if (!empty($drivers->getValue())) {
            $driver_data = [];
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
                            $result['profileImageUrl'] = $driver['profileImageUrl'];
                            $driver_data[] = $result;  
                            
                        } catch (\Exception $e) {}
                                                 
                       }else{
                          $result = [];
                          $result['history'] = (array)$driverValueDetails;
                          $driver_data[] = $result;
                       }
                    } 
                }
            }
        }
        $data = array_unique($driver_data, SORT_REGULAR);
        return response()->json($data);   
    }

    /*

      1. Taken in Customer or Driver as user type and the key of that user
      2. return the history recods of single user

    */
    public static function single_user_history($user_type,$user_id)
    {
        $driver = $this->user_details($user_type,$user_id);
        $history_data = array();
        foreach ($driver as $data_key => $data_value) {
            // for each history, read details
            if (!empty($data_value['history'])) {
            
                foreach ($data_value['history'] as $key_data => $key_value) {
                    $history_refrence_reference = $this->connection_to_firebase()->getReference('history')->getChild($key_data)->getValue();

                    array_push($history_data,$history_refrence_reference);

                }
            }
        }

        return json_encode($history_data);

    }

    /*

    1. Takes in Driver or Customer as $user_type and the ket of that entity
    2. Returns the user details

    */ 

    public static function user_details($user_type,$user_id)
    {
        $data = array();
        $reference = $this->connection_to_firebase()->getReference('Users');
        $user = $reference->getChild($user_type)->orderByKey()->equalTo($user_id)->getValue();
        return $user;//this is a single object for one user
    }

    public static function single_customer($customer_id)
    {
        $data = array();
         foreach ($this->user_details("Customers",$customer_id) as $key => $value) {
            $result = [];
            try {
                $result['name'] = $value['name'];
                $result['phone'] = $value['phone'];         
                $result['profileImageUrl'] = $value['profileImageUrl'];
                $data[] = $result; 
            } catch (\Exception $e) {}
                      
        }
        return $data;
     }


    public static function single_driver($driver_id)
    {
        $data = array();
         foreach ($this->user_details("Drivers",$driver_id) as $key => $value) {
            $result = [];
            try {
               $result['name'] = $value['name'];
               $result['phone'] = $value['phone'];
               $result['car'] = $value['car'];
               $result['service'] = $value['service'];
               $result['profileImageUrl'] = $value['profileImageUrl'];
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
        $rides = $this->connection_to_firebase()->getReference('history')->getValue();
        foreach ($rides as $key_key => $ride_value) {
            $result = [];
            $result["customer"] = $this->single_customer($ride_value['customer']);
            $result["distance"] = $ride_value['distance'];
            $result["driver"] = $this->single_driver($ride_value['driver']);
            $result["location"] = (array)$ride_value['location'];
            $result["rating"] = $ride_value['rating'];
            $result["timestamp"] = $ride_value['timestamp'];
            $rides_data[] = $result;
        }
        $data = array_unique($rides_data, SORT_REGULAR);
        return response()->json($data);
    }

/*
  This returns drivers that are active, but now warking
*/ 
    public static function drivers_available()
    {
        $rides_data = array();
        $rides = $this->connection_to_firebase()->getReference('driversAvailable')->getValue();
        foreach ($rides as $key => $driver_value) {
            array_push($rides_data, $this->single_driver($key));
        }
        return response()->json($rides_data);
    }

    /*
       This will return all the drivers that are working
    */ 

   public static function working_drivers()
   {
        $rides_data = array();
        $rides = $this->connection_to_firebase()->getReference('workingDrivers');
        $working_drivers = $rides->getValue();
        foreach ($rides as $key => $driver_value) {
            array_push($rides_data, $this->single_driver($key));
        }
        return response()->json($rides_data);         
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
        return $this->working_drivers();
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
