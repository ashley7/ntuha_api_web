<?php

namespace App\Http\Controllers;

use App\NtuhaRideUssd;
use Illuminate\Http\Request;

class NtuhaRideUssdController extends Controller
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
        header('Content-type: text/plain');

        $phoneNumber = $request["phoneNumber"];//this is phone number sending the request

        $userInPut = $request["text"];//this is the input from the user

        if (empty($userInPut)) {

            $userInPut = "0";//if there is no input, set to "0" to target main menu

        }else{
            $userInPut = "0*".$request["text"]; 
        }

        $data = explode("*",trim($userInPut));

        $level = count($data);

        switch ($level) {
            case 1:
                NtuhaRideUssd::welcomeMessage();
                break;

            case 2:
                $option = $data[1];
                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::promptName();
                         break;

                    case 2:# he chose to place a request
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }

                break;

            case 3:
                $option = $data[1];

                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::promptGender();
                         break;

                    case 2:# he chose to place a request
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }


                break;

            case 4:
                $option = $data[1];

                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::promptDistrict();
                         break;

                    case 2:# he chose to place a request
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }
                break;

            case 5:
                $option = $data[1];

                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::promptAge();
                         break;

                    case 2:# he chose to place a request
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }
                break;

            case 6:
                $option = $data[1];

                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::disAbility();
                         break;

                    case 2:# he chose to place a request
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }
                break;

            case 7:
                $option = $data[1];

                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::occupation($data,$phoneNumber);
                         break;

                    case 2:# he chose to place a request
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }
                break;

            case 8:
                 $option = $data[1];

                switch ($option) {
                    case 1:# He chose to register
                         NtuhaRideUssd::saveCustomer($data,$phoneNumber);
                         break;

                    case 2:# he chose to place a request
                        
                        break;
                     
                     default:
                         NtuhaRideUssd::killSeesion("The option selected was not recognised");
                         break;
                 }
                break;

                break;
             
            
            default:
                # code...
                break;
        }




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\NtuhaRideUssd  $ntuhaRideUssd
     * @return \Illuminate\Http\Response
     */
    public function show(NtuhaRideUssd $ntuhaRideUssd)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\NtuhaRideUssd  $ntuhaRideUssd
     * @return \Illuminate\Http\Response
     */
    public function edit(NtuhaRideUssd $ntuhaRideUssd)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\NtuhaRideUssd  $ntuhaRideUssd
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, NtuhaRideUssd $ntuhaRideUssd)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\NtuhaRideUssd  $ntuhaRideUssd
     * @return \Illuminate\Http\Response
     */
    public function destroy(NtuhaRideUssd $ntuhaRideUssd)
    {
        //
    }
}
