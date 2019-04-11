<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\NtuhaDashboardController;
use App\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        $data = [

            'users' => $users,
            'title' => 'List of users',
        ];

        return view('user.list')->with($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => 'Create user',
        ];
        return view('user.create')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' =>'required|string|max:255',
            'email'=>'required|string|email|max:255|unique:users',
        ];

        $this->validate($request,$rules);

        $pin = rand(400000,500000);

        $save_user = new User($request->all());
        $save_user->password = bcrypt($pin);
        $save_user->email_verified_at = now();
        $save_user->remember_token = str_random(32);
        $save_user->save();

        $sms = "Dear ".$save_user->name." your Ntuha ride password is ".$pin." Visit ".$_SERVER['REQUEST_URI']." to Login";

        NtuhaDashboardController::send_Email($save_user->email,"Ntuha ride password",$sms,"ntuha.deliveries@gmail.com");

        $data = [
            'status'=>'User created successfully'
        ];

        return redirect()->route('user.index')->with($data);

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
