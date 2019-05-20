<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('incomes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('date');
            $table->uuid('customerId');
            $table->foreign('customerId')->references('id')->on('customers');
            $table->uuid('vehicleId')->nullable();
            $table->foreign('vehicleId')->references('id')->on('vehicles');
            $table->string('recevingAmount')->nullable();
            $table->string('discountAmount')->nullable();
            $table->string('account_id')->nullable();
            $table->uuid('entryId');
            $table->foreign('entryId')->references('id')->on('entries');
            $table->uuid('tripId');
            $table->foreign('tripId')->references('id')->on('trips');
            $table->integer('clientid')->unsigned();
            $table->foreign('clientid')->references('id')->on('clients');
            $table->integer('managerid')->unsigned()->nullable();
            $table->foreign('managerid')->references('id')->on('managers');
            $table->softDeletes();
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
        Schema::dropIfExists('incomes');
    }
}
