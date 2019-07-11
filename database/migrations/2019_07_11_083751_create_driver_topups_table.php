<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverTopupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_topups', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('amount');
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('driver_id');        
            $table->string('status')->default("Not paid");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_topups');
    }
}
