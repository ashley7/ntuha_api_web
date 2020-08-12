<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

        $check_user = User::all()->where('email',$request->email);

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

   public function saveCustomer()
   {
        $saveCustomer = new Customer();
        $saveCustomer->first_name = $request->first_name;
        $saveCustomer->last_name = $request->last_name;
        $saveCustomer->name = $request->last_name." ".$request->first_name;
        $saveCustomer->sex = $request->sex;
        $saveCustomer->email = $request->sex;
        $saveCustomer->year_of_birth = $request->year_of_birth;
        $saveCustomer->disability_status = $request->disability_status;
        $saveCustomer->location = $request->location;
        $saveCustomer->occupation = $request->occupation;
        $saveCustomer->sign_up_date = $request->sign_up_date;
        $saveCustomer->description = $request->description;
        $saveCustomer->email = $request->phone_number;
        $saveCustomer->password = rand(400000,500000);
        try {
            $saveCustomer->save();
            return "Saved successfully";
        } catch (\Exception $e) {
            return "Failed to save customer. ".$e->getMessage();
        }
   }

   public function readCustomers()
   {
        $customers = Customer::paginate(50);
        $data = ['title'=>'List of customers','customers'=>$customers];       
        return view('customer.list')->with($data);
   }
}
