<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Kreait\Firebase;
// use Kreait\Firebase\Factory; 
// use Kreait\Firebase\ServiceAccount; 
// use Kreait\Firebase\Database;
use App\Http\Controllers\DriverController;
use App\User;
use App\Customer;


class NtuhaDashboardController extends Controller
{

  public function testConnection()
  { 

    $ride = NtuhaDashboardController::rides();
    return $ride;
 
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
    
        $database = User::databaseObject();

        $customers = $database->getReference('Users')->getChild("Customers")->getValue();

        $customer_data = [];

        if (!empty($customers)) {

          foreach ($customers as $key => $customer) {
            try {             
              $result = [];                        
             
              $customer_local_data = Customer::where('email',$customer['phone'].'@gmail.com')->get()->last();
               $result["customeId"] = $key;
               $result['name'] =  $customer['name'];
               $result['phone'] = $customer['phone'];
               try {
                 $result['pin'] = $customer_local_data->password;
               } catch (\Exception $e) {
                $result['pin'] = "None";
               }
               
               if (!isset($customer['profileImageUrl'])) {
                 $result['profileImageUrl'] = "default.jpg";
               }else{
                  $result['profileImageUrl'] = $customer['profileImageUrl'];
              }
              $customer_data[] = $result;  

          } catch (\Exception $e) {}            
        }
      }
      $data = array_unique($customer_data, SORT_REGULAR);
      return (array)$data;
      
    }

    /*
       returns all drivers
    */
    public static function read_ntuha_drivers()
    {
        $database = User::databaseObject();

        $drivers = $database->getReference('Users')->getChild("Drivers")->getValue();

        $driver_data = [];

        foreach ($drivers as $key => $driver) {

            $result = [];
            try {
                $result["driverId"] = $key;
                $result['name'] = $driver['name'];
                $result['car'] = $driver['car'];
                $result['service'] = $driver['service'];
                $result['phone'] = $driver['phone'];
                $result['driver_id'] = $driver['driver_id'];
                $result['category'] = $driver['category'];
                $result['subscription_type'] = $driver['subscription_type'];
                $result['profileImageUrl'] = DriverController::read_driver_image($driver['driver_id']);

                $driver_data[] = $result;  
                
            } catch (\Exception $e) {}
          
        }
        $data = array_unique($driver_data, SORT_REGULAR);
        return (array)$data;
    }

    /*

      1. Taken in Customer or Driver as user type and the key of that user
      2. return the history recods of single user

    */
    public static function single_user_history($user_type,$user_id)
    {
        
        $database = User::databaseObject();

        $driver = NtuhaDashboardController::user_details($user_type,$user_id);

        $history_data = [];

        foreach ($driver as $data_key => $data_value) {
            // for each history, read details
          $history = $data_value['history'];

            if (!empty($history)) {
            
                foreach ($history as $key_data => $key_value) {

                    $history_refrence_reference = $database->getReference('history')->getChild($key_data)->getValue();

                    $data = ['record_key'=>$key_data];

                    try {

                      $user_history = array_merge($history_refrence_reference,$data);

                      array_push($history_data, $user_history);

                    } catch (\Exception $e) {}                  
                    
                }
            }
        }

        return $history_data;

    }

    // Update the status of the history

    public function updated_history_status($history_key)
    {
      $database = User::databaseObject();
      $database->getReference('history')->getChild($history_key)->update(['status'=>1]);
      return back();
    }


    public function updated_driver_category($data)
    {

        $result = explode("*", $data);

        $driver_key = $result[0];

        $category = $result[1];

        $new_category = "No category";

        if ($category == "Active") {

          $new_category = "Inactive";

        }elseif ($category == "Inactive" ) {

          $new_category = "Active";

        }

        $database = User::databaseObject();

        $database->getReference('Users')->getChild('Drivers')->getChild($driver_key)->update(['category'=>$new_category]);

        return back();

    }

    public function updated_driver_subscription($data)
    {
        $result = explode("*", $data);
        
        $driver_key = $result[0];
        $subscription = $result[1];

        $subscription_type = "No subscription type";

        if ($subscription == "per_ride") {
            $subscription_type = "monthly";
        }elseif ($subscription == "monthly" ) {
          $subscription_type = "per_ride";
        }
        
        $database = User::databaseObject();
        $database->getReference('Users')->getChild('Drivers')->getChild($driver_key)->update(['subscription_type'=>$subscription_type]);

        return back();
    }

    /*

    1. Takes in Driver or Customer as $user_type and the ket of that entity
    2. Returns the user details

    */ 

    public static function user_details($user_type,$user_id)
    {      
        $database = User::databaseObject();      
        return $database->getReference('Users')->getChild($user_type)->orderByKey()->equalTo($user_id)->getValue();//this is a single object for one user
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
        $user_details = NtuhaDashboardController::user_details("Drivers",$driver_id);
         foreach ($user_details as $key => $value) {
            $result = [];
            try {
               $result['name'] = $value['name'];
               $result['phone'] = $value['phone'];
               $result['car'] = $value['car'];
               $result['email'] = $value['email_address'];
               $result['category'] = $value['category'];
               $result['subscription_type'] = $value['subscription_type'];
               $result['car_plate'] = $value['car_plate'];
               $result['service'] = $value['service'];
               $result['driver_id'] = $value['driver_id'];
               $result['profileImageUrl'] = DriverController::read_driver_image($value['driver_id']);
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
      
        $database = User::databaseObject(); 

        $rides = $database->getReference('history')->getValue();
        if (!empty($rides)) {
            
            foreach ($rides as $key_key => $ride_value) {
                
                try {
                    $result = [];
                  
                    $result["customer_name"] = $ride_value['customer_name'];
                    $result["distance"] = $ride_value['distance'];
                    $result["driver"] = NtuhaDashboardController::single_driver($ride_value['driver']);
                    $result["from"] = $ride_value['from'];
                    $result["to"] = $ride_value['destination'];
                    $result["rating"] = $ride_value['rating'];
                    $result["timestamp"] = $ride_value['timestamp'];
                    $result["amount_paid"] = $ride_value['amount_paid'];
                    $result["cash_amount"] = $ride_value['cash_amount'];
                    $result["account_amount"] = $ride_value['account_amount'];
                    $result["driver_amount"] = $ride_value['driver_amount'];
                    $result["ntuha_amount"] = $ride_value['ntuha_amount'];
                    $result["payment_type"] = $ride_value['payment_type'];
                    $result["status"] = $ride_value['status'];
                    $result["rate_type"] = $ride_value['rate_type'];
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

        $database = User::databaseObject(); 

        $driversAvailable = $database->getReference('driversAvailable')->getValue();

        if (isset($driversAvailable)) {

           try {    
         
              foreach ($driversAvailable as $key => $driver_value) {
                  $driver = NtuhaDashboardController::single_driver($key);

                  foreach ($driver as $driver_value) {
                      $data = array();
                      $data['name'] = $driver_value['name'];
                      $data['phone'] = $driver_value['phone'];
                      $data['car'] = $driver_value['car'];
                      $data['service'] = $driver_value['service'];
                      if (!isset($driver_value['profileImageUrl'])) {
                         $result['profileImageUrl'] = "default.jpg";
                        }else{
                          $result['profileImageUrl'] = $driver_value['profileImageUrl'];
                        }

                      array_push($rides_data, $data);
                       
                  }
                }
              } catch (\Exception $e) {}
            }

      return (array)$rides_data;
    }

    /*
       This will return all the drivers that are working
    */ 

   public static function working_drivers()
   {
        $rides_data = array();

        $database = User::databaseObject();

        $working_drivers = $database->getReference('driversWorking')->getValue();

        if (isset($working_drivers)) {
          foreach ($working_drivers as $key => $driver_value) {
            array_push($rides_data, NtuhaDashboardController::single_driver($key));
          }
        }
        return (array)$rides_data;
    }






    public static function getAddress($latitude,$longitude){    

      $geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false'); 
      $output = json_decode($geocodeFromLatLong);
      $status = $output->status;
      $address = ($status=="OK")?$output->results[1]->formatted_address:''; 

      echo  $address; 
    }




    public static function send_Email($to,$subject,$sms,$from) {

      $user = User::where('email',$to)->get()->last();

      $data = [
        'name'=>$user->name,
        'email'=>$sms
      ];
   
      \Mail::send(['text'=>'layouts.mail'], $data, function($message) use ($to,$subject,$from) {

        $message->to($to, env("APP_NAME"))->subject($subject);
        $message->from('ntuha.deliveries@gmail.com','Ntuha ride');

      });
         
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
     
      return $this->single_driver("IOZndg6zo8cHqORjxrJV5tpzlds1");
       
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
    }


    public function update_driver(Request $request)
    {          
                    
        $firebase_data = [
            'name'=>$request->name,
            'phone'=>$request->phone_numner,
        ];
 
        $database = User::databaseObject();
        $database->getReference('Users')->getChild('Drivers')->getChild($request->driver_id)->update($firebase_data);
    
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
