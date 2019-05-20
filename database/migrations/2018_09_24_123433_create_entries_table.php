<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEntriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('entries', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('dateFrom');
            $table->string('dateTo')->nullable();
            $table->uuid('vehicleId');
            $table->foreign('vehicleId')->references('id')->on('vehicles');
            $table->uuid('customerId');
            $table->foreign('customerId')->references('id')->on('customers');
            $table->string('startKm')->nullable();
            $table->string('endKm')->nullable();
            $table->string('total')->nullable();
            $table->string('locationFrom')->nullable();
            $table->string('locationTo')->nullable();
            $table->string('loadType')->nullable();
//            $table->integer('loadType')->unsigned();
//            $table->foreign('loadType')->references('id')->on('load_types');
            $table->string('ton')->nullable();
            $table->string('billAmount')->nullable();
            $table->string('advance')->nullable();
            $table->string('driverPadi')->nullable();
            $table->string('cleanerPadi')->nullable();
            $table->string('driverPadiAmount')->nullable();
            $table->string('cleanerPadiAmount')->nullable();
            $table->string('comission')->nullable();
            $table->string('loadingMamool')->nullable();
            $table->string('unLoadingMamool')->nullable();
            $table->bigInteger('balance')->nullable();
            $table->string('account_id')->nullable();
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
        Schema::dropIfExists('entries');
    }
}
