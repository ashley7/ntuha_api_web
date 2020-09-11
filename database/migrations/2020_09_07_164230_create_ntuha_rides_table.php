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
            $table->string('from');
            $table->string('to');
            $table->double('amount');
            $table->date('date');        
            $table->string('month_year');      
            $table->double('ntuha_amount')->default(200);      
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
