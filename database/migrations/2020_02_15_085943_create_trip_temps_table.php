<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_temps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('dateFrom');
            $table->string('dateTo')->nullable();
            $table->uuid('vehicleId');
            $table->foreign('vehicleId')->references('id')->on('vehicles');
            $table->string('tripName');
            $table->string('startKm')->nullable();
            $table->string('endKm')->nullable();
            $table->string('totalKm')->nullable();
            $table->string('advance')->nullable();
            $table->uuid('staff1')->nullable();
            $table->foreign('staff1')->references('id')->on('staff');
            $table->uuid('staff2')->nullable();
            $table->foreign('staff2')->references('id')->on('staff');
            $table->uuid('staff3')->nullable();
            $table->foreign('staff3')->references('id')->on('staff');
            $table->integer('clientid')->unsigned();
            $table->foreign('clientid')->references('id')->on('clients');
            $table->integer('managerid')->unsigned()->nullable();
            $table->foreign('managerid')->references('id')->on('managers');
            $table->longText('entry')->nullable();
            $table->longText('diesel')->nullable();
            $table->longText('rto')->nullable();
            $table->longText('pc')->nullable();
            $table->longText('extraExpense')->nullable();
            $table->longText('tollgate')->nullable();
            $table->longText('driverAdvance')->nullable();
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
        Schema::dropIfExists('trip_temps');
    }
}
