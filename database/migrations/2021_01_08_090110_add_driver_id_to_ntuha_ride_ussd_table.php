<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddDriverIdToNtuhaRideUssdTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ntuha_ride_ussds', function (Blueprint $table) {
            $table->integer('driver_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ntuha_ride_ussds', function (Blueprint $table) {
            $table->dropColumn('driver_id');
        });
    }
}
