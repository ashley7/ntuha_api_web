<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\NtuhaDashboardController;
use App\User;
use App\Customer;

class CustomerController extends Controller
{
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
        $data = ['title'=>'Create new farmer'];
        return view('customer.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $rules = ['email'=>'required'];

        $this->validate($request,$rules);

        $check_user = User::get()->where('email',$request->email);

        if ($check_user->count() == 0) {
            return back()->with(['email'=>'Email not found in the system']);
        }

        $user =  $check_user->last();

        $characters = env("PASSWORD_STRING");
         $charactersLength = strlen($characters);
         $randomString = '';
            for ($i = 0; $i < 10; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }

        $sms = $user->name." Your new Ntuha ride password is ".$randomString;

        $this->send_Email($user->email,"Ntuha ride ~ new password",$sms,'ntuha.deliveries@gmail.com');

        return redirect('/login')->with(['status'=>'A new Email has been sent to your '.$user->email]);
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
        $read_customer = Customer::find($id);

        $data = [
            'read_customer' => $read_customer,
            'title' => 'Edit '.$read_customer->name

        ];

        return view('customer.edit_customer')->with($data);
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
    
        $saveCustomer = Customer::find($id);
        $saveCustomer->first_name = $request->first_name;
        $saveCustomer->last_name = $request->last_name;
        $saveCustomer->name = $request->last_name." ".$request->first_name;
        $saveCustomer->sex = $request->sex;
        $saveCustomer->email = $request->phone_number."@gmail.com";
        $saveCustomer->year_of_birth = $request->year_of_birth;
        $saveCustomer->disability_status = $request->disability_status;
        $saveCustomer->occupation = $request->occupation;

        $saveCustomer->location = $request->location;
        $saveCustomer->sign_up_date = $request->sign_up_date;
        $saveCustomer->agent_name = $request->agent_name;
 
        $saveCustomer->save();
        
        return redirect('/read_customers');
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



    public static function send_Email($to,$subject,$sms,$from) {

          $user = User::all()->where('email',$to)->last();

          $data = [
            'name'=>$user->name,
            'email'=>$sms
          ];
       
          \Mail::send(['text'=>'layouts.mail'], $data, function($message) use ($to,$subject,$from) {
 
            $message->to($to, env("APP_NAME"))->subject($subject);
            $message->from('ntuha.deliveries@gmail.com','Ntuha ride');

          });
         
   }

   public function saveCustomer(Request $request)
   {        
        try {             
            Customer::saveCustomer($request->first_name,$request->last_name,$request->sex,$request->year_of_birth,$request->disability_status,$request->location,$request->occupation,$request->sign_up_date,$request->description,$request->phone_number,$request->agent_name);
            return "Saved successfully";
        } catch (\Exception $e) {
            return "Failed to save customer. ".$e->getMessage();
        }
   }

   public function readCustomers()
   {

        $customers = Customer::paginate(1000);
        $data = ['title'=>'List of customers','customers'=>$customers];       
        return view('customer.list')->with($data);
   }

   public function importCustomers(Request $data)
   {
        \Excel::load($data->file('excel_file'), function($reader) {    

            $dataresults = $reader->all();   

            // global $request;            

            foreach ($dataresults as $request) { 
              
                Customer::saveCustomer($request->first_name,$request->last_name,$request->sex,$request->age,$request->disability_status,$request->location,$request->occupation,$request->sign_up_date,$request->description,$request->phone_number,$request->agent_name);
            }
        });

        return redirect('/read_customers');
   }

   public function importUser()
   {
        $data = ['title'=>'Import customers'];
        return view('customer.import_customers')->with($data);  
   }

   public function loadCustomer()
   {
       $data = ['title'=>'Generate customer reports'];
       return view('reports.get_customer_report')->with($data); 
   }

   public function customerReport(Request $request)
   {

         $customerReport = Customer::whereBetween('created_at',[$request->from."-1 day",$request->to."+1 day"])->get();

            $title = "Customers that registred between ".$request->from." and ".$request->to;

            $data = [
                'customers' => $customerReport,
                'title' => $title
            ];
 
            return view('reports.customer_report')->with($data);
       
   }

   public function changeAge()
   {

        $customers = Customer::where('year_of_birth','>',1000)->get();

        foreach ($customers as $value) {
            $date_bone = 2020 - (int)$value->year_of_birth;
            $customer = Customer::find($value->id);
            $customer->year_of_birth = $date_bone;
            $customer->save();
        }

        return redirect()->route('customers.index');
       
   }

   public function contact(Request $request)
   {
        $sms = $request->name. "is saying ". $request->message." You can get back to him on ".$request->email;
        try {
            mail("ntuha.deliveries@gmail.com", "Ntuha ride Contact us", $sms);
        } catch (\Exception $e) {}       
        return back();       
   }


}
