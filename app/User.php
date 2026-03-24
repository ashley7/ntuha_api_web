<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kreait\Firebase;
use Kreait\Firebase\Factory; 
use Kreait\Firebase\ServiceAccount; 
use Kreait\Firebase\Database;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function databaseObject()
    {

        // $path = base_path(config('firebase.credentials'));

        // $serviceAccount = ServiceAccount::fromJsonFile($path);
        // $firebase = (new Factory)->withServiceAccount($serviceAccount)->withDatabaseUri(env('FIREBASE_DATABASE'))->create();

        // $database = $firebase->getDatabase();

        // return $database;

        $jsonPath = base_path(config('firebase.credentials'));
        $dbUrl = config('firebase.database');

        if (!file_exists($jsonPath)) {
            throw new \Exception("Firebase JSON not found: " . $jsonPath);
        }

        return (new Factory)
            ->withServiceAccount($jsonPath)
            ->withDatabaseUri($dbUrl)
            ->createDatabase();
    }

    public static function sendSMS($phone_number,$message)
    {

        if(empty($phone_number)) return;

        $phone = User::validatePhoneNumber($phone_number); 
        
        $username = env("SMSUSERNAME");
        $pass   = env("SMSAPIKEY"); //password 
        
        $token = User::getSmSToken($username, $pass); 

        if (!$token) return;

        $url = "https://sms.dmarkmobile.com/v3/api/send_sms/";

        $data = json_encode([
            'msg' => $message,
            'numbers' => $phone
        ]);

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // JSON encoded body
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
            'authToken: ' . $token
        ]);        

        try {
            curl_exec($ch);
        } catch (\Exception $th) {}       

        curl_close($ch);            
 
    }

    public static  function getSmSToken($username,$pass){

        $url = "https://sms.dmarkmobile.com/v3/api/get_token/";
        
        $data = json_encode([
            'username' => $username,
            'password' => $pass
        ]);
        
        $ch = curl_init($url);
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data); // JSON encoded body
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        ]);

        try {
            $response = curl_exec($ch);

            curl_close($ch);

            $results = json_decode($response,1);

            return $results['access_token']; 

        } catch (\Exception $th) {

           curl_close($ch);

        }
    }

    public static function validatePhoneNumber($phone)
    {

        $phone_number = "";

        $phone = str_replace(" ", "", $phone);

        if ($phone[0]=="+") {

           $phone_number=str_replace("+", "", $phone);

        }elseif ($phone[0]=="0") {

            $out = ltrim($phone, "0");

            $phone_number="256".$out;

        }else{

            $phone_number=$phone;

        }

        return $phone_number;

    }
}
