<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRideHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ride_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('date')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_photo')->nullable();
            $table->string('driver_key')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_key')->nullable();
            $table->string('amount_paid')->nullable();
            $table->string('from')->nullable();
            $table->string('to')->nullable();
            $table->string('status',2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ride_histories');
    }
}
