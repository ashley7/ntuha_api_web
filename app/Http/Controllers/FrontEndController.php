<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\NtuhaDashboardController;
use App\Http\Controllers\DriverController;
use App\Payment;
use App\Withdraw;

class FrontEndController extends Controller
{
    public static function rides()
    {
    	$ride = NtuhaDashboardController::rides();

    	$data = array();

        if (!empty($ride)) {        
        	foreach ($ride as $key => $value) { 
        	$customer_name =  $driver_name = $from = $to = $date = $distance = $date = $rating = $amount_paid = "";
     	        foreach ($value as $customer_key => $customer_value) {
     	        	$results = array();
    	            if($customer_key == "driver"){
    	                $driver = $customer_value[0]; 
    	                $driver_name = $driver['name']."(".$driver['phone'].")";

                        $distance = $value['distance'];
                        $rating = $value['rating'];
                        $date = date("Y-m-d",$value['timestamp']);
                        $customer_name = $value['customer_name'];
                        $from = $value['from'];              
                        $to = $value['to']; 
                        $amount_paid = $value['amount_paid'];
    	            }         
      			} 
      			    $results['customer_name'] = $customer_name;
    	            $results['driver_name'] = $driver_name;
    	            $results['from'] =  $from;
    	            $results['to'] =  $to;
    	            $results['date'] = $date;
    	            $results['distance'] = $distance;	            
    	            $results['rate'] = $rating;
                    $results['amount_paid'] = $amount_paid;

    	            $data[] = $results;
    	      }
          }
        
            return view('pages.rides')->with(['ride'=>$data]);
       
    }

    public static function get_customers()
    {
      $customers = NtuhaDashboardController::read_ntuha_customers();
      return view("pages.customer_list")->with(['customers'=>$customers]);   
    }

    public function read_single_customer($customer_id)
    {
    	$customer = NtuhaDashboardController::single_customer($customer_id);
    	$customer_history = NtuhaDashboardController::single_user_history("Customers",$customer_id);
    	$data = ['customer'=>$customer,'customer_history'=>$customer_history];  
    	return view('pages.customer_details')->with($data);   	 
    }

    public static function get_drivers()
    {
    	$drivers = NtuhaDashboardController::read_ntuha_drivers();
    	return view('pages.driver_list')->with(['drivers'=>$drivers]);
    }

    public function read_single_driver($driver_id)
    {
    	$driver = NtuhaDashboardController::single_driver($driver_id);
    	$driver_history = NtuhaDashboardController::single_user_history("Drivers",$driver_id);
    	$data = ['driver'=>$driver,'driver_history'=>$driver_history];  
    	return view('pages.driver_details')->with($data);   	 
    }


    public static function available_drivers()
    {
    	$available_drivers = NtuhaDashboardController::drivers_available();
    	return view('pages.available_driver')->with(['available_drivers'=>$available_drivers]);
    }

    public function payments(Request $request)
    {

        $phone_number = $request->phone_number;

        \Beyonic::setApiKey(env("BEYONIC_API_KEY"));

        $collection_request = \Beyonic_Collection_Request::create(array(
          "phonenumber" => "+256".ltrim($phone_number,"0"),
          "amount" => (int)$request->amount,
          "currency" => "UGX",
          "reason" => "Ntuha Ride transaction.",
          "success_message" => "Dear {customer}, You have paid {amount} for Ntuha Ride. Thank you ",
          "error_message" => "Dear {customer}, Your payment of {amount} to Ntuha Ride has failed. ",
          "metadata" => array("email"=>$phone_number."@gmail.com"),
          "send_instructions" => True,
          "expiry_date" => "5 minutes"
        ));

        $save_payment = new Payment();
        $save_payment->email  = $phone_number."@gmail.com";
        $save_payment->amount = $collection_request->amount;
        $save_payment->status = $collection_request->status;
        $save_payment->transaction_id = $collection_request->id;
        $save_payment->phone_number = $collection_request->phonenumber;
        $save_payment->customer_name = $request->name;
        try {

            $save_payment->save();
            $response['status'] = "SUCCESS";
            $response['message'] = "Thank you, Please approve the transaction. It will expires in the next 5 minutes.";
            $response['transaction_id'] = $collection_request->id;
            return \Response::json([$response]);

        } catch (\Exception $e) {

            $response['status'] = "FAILED";
            $response['message'] = "Payment failed: ".$e->getMessage();
            return \Response::json([$response]);
            
        }        
    }


    public  function check_payment_approval(Request $request)
    {
        $response = array();

        \Beyonic::setApiKey(env("BEYONIC_API_KEY"));

        $collection_request = \Beyonic_Collection_Request::get((int)$request->transaction_id);
        
        $update_status = Payment::all()->where('transaction_id',$request->transaction_id)->last();

        if (empty($update_status)) {
            $response['status'] = "Error";
            $response['message'] = "Transaction id ".$request->transaction_id." does not exist.";
            return \Response::json([$response]);
        }

        $update_status->status = $collection_request->status;
        $update_status->save();

        if ($collection_request->status == "success") {

            $response['message'] = "Payment approved";
            $response['status'] = $collection_request->status;
            $message = "Your Ntuha ride account has been updated by ".$collection_request->amount;
            DriverController::sendSMS($phone_number,$message);
            return \Response::json([$response]);

        }elseif ($collection_request->status == "pending") {

            $response['status'] = $collection_request->status;
            $response['message'] = "Payment not yet approved";
            return \Response::json([$response]);

        }else{

            $response['status'] = "EXPIRED";
            $response['message'] = $collection_request->status;
            return \Response::json([$response]);

        }
    }

    public function record_account_ride(Request $request)
    {
        $save_withdraw = new Withdraw();
        $save_withdraw->email = $request->email;
        $save_withdraw->amount = $request->amount;
        $save_withdraw->save();
    }

    public function customer_payments(Request $request)
    {
        return Payment::where('email',$request->email)->get();
    }

    public static function account_balance(Request $request)
    {
        $payments = Payment::where('email',$request->email)->where('status','success')->sum('amount');
        $with_draw = Withdraw::where('email',$request->email)->sum('amount');
        return ($payments - $with_draw);        
    }
}
