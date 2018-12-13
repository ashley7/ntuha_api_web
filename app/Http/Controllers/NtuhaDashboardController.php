<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase;
use Kreait\Firebase\Factory; 
use Kreait\Firebase\ServiceAccount; 
use Kreait\Firebase\Database;

class NtuhaDashboardController extends Controller
{
    

    public static function connection_to_firebase()
    {
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/ntuhatransport-firebase-adminsdk-9e7cu-56ffdea3cf.json');
        $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri('https://ntuhatransport.firebaseio.com/')->create();       
        return $firebase->getDatabase();
    }


    public function read_ntuha_customers()
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


    public function read_ntuha_drivers()
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


    public function single_driver_history($user_type,$user_id)
    {
        $driver = $this->user_details($user_type,$user_id);
    }


    public function driver_history($driver_id)
    {

        $reference = $this->connection_to_firebase()->getReference('Users');
        $drivers = $reference->getChild("Drivers");
        if (!empty($drivers->getValue())) {
            
            foreach ($drivers->getValue() as $driver_key => $driver) {
                if (gettype($driver)=="array") {
                    foreach ($driver as $key => $driverValueDetails) {
                       if (gettype($driverValueDetails) == "array") {

                            if ($driver_key === $driver_id) {
                                $driver_data = [];
                                foreach ($driverValueDetails as $driver_history_key => $value) {
                                    // echo $driver_history_key."<br>";
                                    // read the history of this key
                                    $history_refrence_reference = $this->connection_to_firebase()->getReference('history');
                                      foreach ($history_refrence_reference->getValue() as $history_key => $history_value) {
                                        if ($history_key == $driver_history_key) {
                                            // print_r($history_value);
                                            foreach ($history_value as $data_key => $data_value) {
                                                if ($data_key != "location") {
                                                    $result = [];
                                                    $result['customer'] = $history_value['customer'];
                                                    $result['distance'] = $history_value['distance'];
                                                    $result['driver'] = $history_value['driver'];
                                                    $result['rating'] = $history_value['rating'];
                                                    $result['timestamp'] = $history_value['timestamp'];
                                                    $result['location'] = (array)$history_value['location'];
                                                    $driver_data[] = $result;
                                                }
                                            }
                                         }
                                       }
                                    }
                                }                   
                            }
                        } 
                    }
                }
            }

            $data = array_unique($driver_data, SORT_REGULAR);
            return response()->json($data); 
        }



        public function user_details($user_type,$user_id)
        {
            $data = array();
            $reference = $this->connection_to_firebase()->getReference('Users');
            $drivers = $reference->getChild($user_type)->orderByKey()->equalTo($user_id)->getValue();

            /*   Loading Driver details */
            // foreach ($drivers as $key => $value) {
            //     $result = [];
            //     $result['name'] = $value['name'];
            //     $result['phone'] = $value['phone'];
            //     $result['car'] = $value['car'];
            //     $result['service'] = $value['service'];
            //     $result['profileImageUrl'] = $value['profileImageUrl'];
            //     $data[] = $result;           
            // }
            // return json_encode($data);

             /*   Loading Driver customer */
            // foreach ($drivers as $key => $value) {
            //     $result = [];
            //     $result['name'] = $value['name'];
            //     $result['phone'] = $value['phone'];         
            //     $result['profileImageUrl'] = $value['profileImageUrl'];
            //     $data[] = $result;           
            // }
            // return json_encode($data);

            return $drivers;//this is a single index for one user
        }


/*
  1. read customers [done]
  2. read drivers [done]
  3. Read customer history [from to cost]
  4. Read Driver history
  5. Count THEM
  6. Rides btn periods
  7. Read single data for user[done]
*/
    public function index()
    {  
      
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
