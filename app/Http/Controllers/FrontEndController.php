<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\NtuhaDashboardController;
use App\Http\Controllers\DriverController;
use App\Price;
use App\Payment;
use App\Withdraw;
use App\NtuhaRide;
use App\Customer;
use App\Driver;

class FrontEndController extends Controller
{
    public static function rides()
    {
    	$ride = NtuhaDashboardController::rides();
        
        $data = array();

        if (!empty($ride)) {        
        	foreach ($ride as $key => $value) { 

        	$customer_name =  $driver_name = $from = $to = $date =
             $distance = $date = $rating = $amount_paid = $account_amount = $driver_amount = $ntuha_amount = $payment_type = $status = $cash_amount = $ride_type = "";

     	        foreach ($value as $customer_key => $customer_value) {
     	        	$results = array();
    	            if($customer_key == "driver"){
                        try {                           
                        
    	                $driver = $customer_value[0]; 
    	                $driver_name = $driver['name']."(".$driver['phone'].")";

                        $distance = $value['distance'];
                        $rating = $value['rating'];
                        $date = date("Y-m-d",$value['timestamp']);
                        $customer_name = $value['customer_name'];
                        $from = $value['from'];              
                        $to = $value['to']; 
                        $amount_paid = $value['amount_paid'];

                        $account_amount = $value['account_amount'];
                        $driver_amount = $value['driver_amount'];
                        $ntuha_amount = $value['ntuha_amount'];
                        $payment_type = $value['payment_type'];
                        $status = $value['status'];
                        $cash_amount = $value['cash_amount'];
                        $ride_type = $value['rate_type'];

                    } catch (\Exception $e) {}

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
                    $results['cash_amount'] = $cash_amount;

                    $results['account_amount'] = $account_amount;
                    $results['driver_amount'] = $driver_amount;
                    $results['ntuha_amount'] = $ntuha_amount;
                    $results['payment_type'] = $payment_type;
                    $results['status'] = $status;
                    $results['ride_type'] = $ride_type;

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
    	$data = [
            'driver'=>$driver,
            'driver_history'=>$driver_history,
            'driver_key'=>$driver_id
        ];  

        //return gettype($driver_history);

    	return view('pages.driver_details')->with($data);   	 
    }


    public static function available_drivers()
    {
    	$available_drivers = NtuhaDashboardController::drivers_available();
     	return view('pages.available_driver')->with(['available_drivers'=>$available_drivers]);
    }

    public function payments(Request $request)
    {      


        // {"status":"Transaction successfully fetched","message":"Tx Fetched","data":{"id":64421451,"txRef":"Ntuha-RideQW6JCYECA0LX05MXXSN42PE8EVQK6UZ7","orderRef":"URF_MMGH_1562339809476_1076835","flwRef":"923482415623398117680","redirectUrl":"http:\/\/127.0.0","device_fingerprint":"357903083086862","settlement_token":null,"cycle":"one-time","amount":500,"charged_amount":513.25,"appfee":13.25,"merchantfee":0,"merchantbearsfee":0,"chargeResponseCode":"00","raveRef":null,"chargeResponseMessage":"Transaction is being processed","authModelUsed":"MOBILEMONEY","currency":"UGX","IP":"105.21.72.46:61513","narration":"Thembo Charles Lwanga","status":"successful","modalauditid":"66375383d8c2fae6e899e485b80233a8","vbvrespmessage":"N\/A","authurl":"NO-URL","vbvrespcode":"N\/A","acctvalrespmsg":"Approved Or Completed Successfully","acctvalrespcode":"00","paymentType":"mobilemoneyug","paymentPlan":null,"paymentPage":null,"paymentId":"N\/A","fraud_status":"ok","charge_type":"normal","is_live":0,"createdAt":"2019-07-05T15:16:49.000Z","updatedAt":"2019-07-05T15:17:22.000Z","deletedAt":null,"customerId":38829329,"AccountId":27735,"customer.id":38829329,"customer.phone":"0787444081","customer.fullName":"Lwanga Customer","customer.customertoken":null,"customer.email":"ashley7520charles@gmail.com","customer.createdAt":"2019-07-05T12:29:59.000Z","customer.updatedAt":"2019-07-05T12:29:59.000Z","customer.deletedAt":null,"customer.AccountId":27735,"meta":[],"flwMeta":{}}}


        $phone_number = $request->phone_number;

        $collection_request = json_decode($request->response);
      

        $data = $collection_request->data;

        $save_payment = new Payment();
        $save_payment->email  = $phone_number."@gmail.com";
        $save_payment->amount = $data->amount;
        $save_payment->status = $data->status;
        $save_payment->transaction_id = $data->txRef;
        $save_payment->paying_phone_number = $phone_number;
        $save_payment->phone_number = $phone_number;
        $save_payment->customer_name = $request->name."(".$data->narration.")";
  
        try {

            $save_payment->save();
            $response['status'] = "SUCCESS";
            $response['message'] = "Thank you, Your transaction has been successful";         
            return \Response::json([$response]);

        } catch (\Exception $e) {

            $response['status'] = "FAILED";
            $response['message'] = "Payment failed";
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
        $update_status->amount = $collection_request->amount;
        $update_status->save();

        if ($collection_request->status == "successful") {

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
        $driver = Driver::select('id','service','name','driver_id')->where('phone_number',$request->driver_phone_number)->get()->last();
     
        $customer = Customer::select('id','name','email')->where('email',$request->customer_phone_number."@gmail.com")->get()->last();

        $ntuha_amount = 1000;

        if ($driver->service == "Ntuha Boda") {
            $ntuha_amount = 200;
        }elseif($driver->service == "Ntuha Taxi"){
            $ntuha_amount = 500;
        }

        NtuhaRide::saveRide($driver->id,$customer->id,$request->amount_paid,$request->from,$request->to,date('Y-m-d'),date('Y-m'),$ntuha_amount);

        $phone_number = str_replace("@gmail.com", "", $request->email);

        $save_payment = new Payment();

        $save_payment->email  = $request->email;

        $save_payment->amount = (0 - $request->account_payment);

        $save_payment->status = "successful";

        $save_payment->transaction_id = "Withdraw - ".time();

        $save_payment->paying_phone_number = $phone_number;

        $save_payment->phone_number = $phone_number;

        $save_payment->customer_name = $customer->name;

        try {
            $save_payment->save();            
        } catch (\Exception $e) {}

        try {

            $message = "Hello ".$customer->name.", your Ntuha ride with ".$driver->name." (No.".$driver->driver_id."), to ".$request->to." has ended, It costed Ush".$request->amount_paid.", thank you.";        
            DriverController::sendSMS($phone_number,$message);
            
        } catch (\Exception $e) {}     
        
    }

    public function customer_payments(Request $request)
    {
        return Payment::where('email',$request->email)->get();
    }

    public static function account_balance(Request $request)
    {
           
       return Payment::where('email',$request->email)->where('status','successful')->sum('amount');      

    }

    public function phone_number()
    {
        return env("PHONE_NUMBER");
    }

    public function number_of_rides(Request $request)
    {
        $response = array();
        $driver_history = NtuhaDashboardController::single_user_history("Drivers",$request->user_id);
        $number_of_rides = count($driver_history);
        $total_unpaid = 0;

        foreach ($driver_history as $unpaid_key => $unpaid_value) {
            if($unpaid_value['status'] == 0){

               $total_unpaid = $total_unpaid + $unpaid_value["ntuha_amount"];

            }
        }

        $response["status"] = "SUCCESS";
        $response["ntuha_amount"] = $total_unpaid;
        $response["number_of_rides"] = $number_of_rides;
        
        return \Response::json([$response]);
    }

    public function customer_number_of_rides(Request $request)
    {
       $customer_history = NtuhaDashboardController::single_user_history("Customers",$request->user_id);
        return count($customer_history);
    }

    public function transactions()
    {

        $transactions = Payment::all();

        $data = [
            'transactions'=>$transactions,
            'title' => 'All  Transactions',
        ];

        return view('pages.transactions')->with($data);        
    }

    public function confirm_transaction($payment_id)
    {
        $transactions = Payment::find($payment_id);
        if ($transactions->status == 'pending') {
            $transactions->status = 'successful';
        } elseif ($transactions->status == 'successful') {
            $transactions->status = 'pending';
        }
        $transactions->save();
        return back();        
    }


    public function getRidePrice(Request $request)
    {

        $response = array();

        $subscription_type = $driver_email = "";

        $read_price = Price::all()->where('type',$request->service)->last();

        $driver = NtuhaDashboardController::single_driver($request->driver_id);

        $ride_distance = $request->distanceInKiloMeters;

        $payment_method = $request->payment_method;

        foreach ($driver as $driver_details) {
            $subscription_type = $driver_details["subscription_type"];

            $driver_email = $driver_details["email"];
        }

        if (!empty($read_price)) {

            $balance = 0;

            $ntuha_amount = 0;

            $cash_amount = $account_payment = $payment_type = "";

            if ($payment_method == 'Account') {
                # paying from account
                $balance = $this->account_balance($request);
            }       
          
            $unit_price = $read_price->price;            

            // $estimated_price = ($unit_price * round($distanceInKiloMeters)); 

            $estimated_price = 0;

            if (!empty($request->ride_price)) {
                $estimated_price = $request->ride_price;
            }else{
                $estimated_price = ($unit_price * round($ride_distance));
            }
            
            // if( ($request->service == "Ntuha Boda") && $estimated_price < env("BODA_PRICE")){
            //     $estimated_price = env("BODA_PRICE");

            // }

            // if( ($request->service == "Ntuha Taxi") && $estimated_price < env("TAXI_PRICE")){
            //     $estimated_price = env("TAXI_PRICE");
            // }

            // if( ($request->service == "Ntuha Truck") && $estimated_price < env("TRUCK_PRICE")){
            //     $estimated_price = env("TRUCK_PRICE");
            // }

             $ntuha_amount =  $read_price->rate;

            if ($subscription_type == "monthly") {
                $ntuha_amount = 0;
            }
            
            if ($payment_method == "Account"){
              
                $remaining_balance = $balance - $estimated_price;

                if ($remaining_balance <  0){
                    $cash_amount = (-1 * $remaining_balance);
                    //making positive of the balance, cash payment
                    $account_payment = $balance;//all your balance was paid
                    $payment_type = "Cash|Account";
                } else{//had enough money on account
                    $account_payment = $estimated_price;
                    $payment_type = "Account";
                    $cash_amount = 0;
                }

                $save_withdraw = new Withdraw();
                $save_withdraw->email = $driver_email;
                $save_withdraw->amount = $account_payment;
                try {

                    $save_withdraw->save();
                     
                } catch (\Exception $e) {}

            } elseif($payment_method == "Cash"){
                $account_payment = 0;
                $payment_type = "Cash";
                $cash_amount = $estimated_price;
            }

            $driver_amount = $estimated_price - $ntuha_amount;

            $response["status"] = "SUCCESS";
            $response["balance"] = $balance;
            $response["type"] = $read_price->type;
            $response["ratetype"] = $read_price->ratetype;
            $response["rate"] = $read_price->rate;
            $response["driver_amount"] = $driver_amount;
            $response["ntuha_amount"] = $ntuha_amount;
            $response["amount_paid"] = $estimated_price;
            $response["cash_amount"] = $cash_amount;
            $response["account_amount"] = $account_payment;
            $response["payment_type"] = $payment_type;
            $response["rate_type"] = $read_price->ratetype;

            return \Response::json([$response]);
                    
        }else{
            $response["status"] = "FAILED";
            $response["message"] = "No Price found";
            return \Response::json([$response]);
        }
        
    }

    public function rave_public_Keys()
    {
        
        $response = array();
        $response["RAVE_PUBLIC_KEY"] = env("RAVE_PUBLIC_KEY");
        $response["RAVE_SECRET_KEY"] = env("RAVE_SECRET_KEY");
        $response["RAVE_ENCRYPTION_KEY"] = env("RAVE_ENCRYPTION_KEY");
        $response["status"] = "SUCCESS";

        return \Response::json([$response]);  
        
    }
}
