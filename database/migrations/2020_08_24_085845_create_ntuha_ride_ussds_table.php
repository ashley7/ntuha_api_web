<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNtuhaRideUssdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ntuha_ride_ussds', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('customer_id'); 
            $table->string('product');
            $table->string('pick_up_location');
            $table->string('destination_location');
            $table->string('status')->default('pending');//accepted, completed,pending,declined
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ntuha_ride_ussds');
    }
}
