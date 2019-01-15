<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = ['name','email','phone_number','driver_id','identification_number','identification_type','motor_type','number_plate','service'];
}
