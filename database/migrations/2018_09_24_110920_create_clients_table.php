<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('transportName')->nullable();
            $table->string('mobile')->unique();
            $table->string('address')->nullable();
            $table->string('expires_on')->nullable();
            $table->string('referral_number')->nullable();
            $table->string('vehicleCredit')->default(1)->nullable();
            $table->string('memosheet')->default('DefaultTripSheet');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clients');
    }
}
