<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubscriptiontypeToDrivers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('drivers', function (Blueprint $table) {
            $table->string('subscription_type');   
            $table->string('mailer');   
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
                Schema::table('drivers', function (Blueprint $table) {
                   $table->dropColumn('subscription_type'); 
                   $table->dropColumn('mailer'); 
                });
        
    }
}
