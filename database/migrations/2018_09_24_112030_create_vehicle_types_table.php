<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehicleTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('vehicleType')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('address')->nullable();
            $table->string('type')->nullable();
            $table->integer('clientid')->unsigned();
            $table->foreign('clientid')->references('id')->on('clients');
            $table->integer('managerid')->unsigned()->nullable();
            $table->foreign('managerid')->references('id')->on('managers');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('load_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('loadType')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

         Schema::create('document_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('documentType')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

         Schema::create('staff', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('mobile1');
            $table->string('mobile2')->nullable();
            $table->string('address');
            $table->enum('type',['manager', 'cleaner', 'driver']);
            $table->string('licenceNumber')->nullable();
            $table->string('licenceRenewal')->nullable();
            $table->integer('clientid')->unsigned();
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
        Schema::dropIfExists('vehicle_types');
        Schema::dropIfExists('customers');
        Schema::dropIfExists('load_types');
        Schema::dropIfExists('document_types');
        Schema::dropIfExists('staff');
    }
}
