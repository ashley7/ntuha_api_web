<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNtuhaRidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ntuha_rides', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('driver_id');
            $table->integer('customer_id');
            $table->integer('from');
            $table->integer('to');
            $table->integer('amount');         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ntuha_rides');
    }
}
