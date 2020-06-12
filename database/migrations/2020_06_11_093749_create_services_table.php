<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('date')->nullable();
            $table->string('service_station_name')->nullable();
            $table->string('next_service_date')->nullable();


            $table->string('service_km')->nullable();
            $table->string('next_service_km')->nullable();


            $table->string('note')->nullable();

            $table->uuid('vehicle_service_id')->nullable();
            $table->foreign('vehicle_service_id')->references('id')->on('vehicle_services');

            $table->uuid('vehicleId')->nullable();
            $table->foreign('vehicleId')->references('id')->on('vehicles');

            $table->integer('clientid')->unsigned()->nullable();
            $table->foreign('clientid')->references('id')->on('clients');
            $table->integer('managerid')->unsigned()->nullable();
            $table->foreign('managerid')->references('id')->on('managers');

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
        Schema::dropIfExists('services');
    }
}
