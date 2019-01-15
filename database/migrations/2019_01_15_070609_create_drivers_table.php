<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('name');
            $table->string('email');            
            $table->string('phone_number')->unique();
            $table->string('driver_id')->unique();
            $table->string('identification_number')->unique();//NIN or driving permit
            $table->string('identification_type');
            $table->string('motor_type');
            $table->string('number_plate');
            $table->string('service');
            $table->string('input_img');
            $table->string('access_key');
            $table->string('status')->default(0);//0 is not active, 1 ia active
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('drivers');
    }
}
