<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('ownerName');
            $table->string('vehicleNumber');
            $table->string('vehicleName')->nullable();
            $table->string('modelNumber')->nullable();
            $table->string('vehicleLastKm')->nullable();
            $table->integer('vehicleType')->unsigned();
            $table->foreign('vehicleType')->references('id')->on('vehicle_types');
            $table->string('VehicleProfit')->nullable()->default(0);
            $table->integer('clientid')->unsigned();
            $table->foreign('clientid')->references('id')->on('clients');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('account');
            $table->string('HolderName')->nullable();
            $table->integer('clientid')->unsigned()->nullable();
            $table->foreign('clientid')->references('id')->on('clients');
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
        Schema::dropIfExists('vehicles');
        Schema::dropIfExists('accounts');
    }
}
