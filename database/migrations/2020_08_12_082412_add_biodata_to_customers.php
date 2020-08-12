<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBiodataToCustomers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->enum('sex',['male','female']);
            $table->string('year_of_birth')->nullable();
            $table->enum('disability_status',['disabled','not disabled'])->default('not disabled');
            $table->string('location')->nullable();
            $table->string('occupation')->nullable();
            $table->string('sign_up_date')->nullable();
            $table->string('description')->nullable();
            $table->string('agent_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('sex');
            $table->dropColumn('year_of_birth');
            $table->dropColumn('disability_status');
            $table->dropColumn('location');
            $table->dropColumn('occupation');
            $table->dropColumn('sign_up_date');
            $table->dropColumn('description');
        });
    }
}
