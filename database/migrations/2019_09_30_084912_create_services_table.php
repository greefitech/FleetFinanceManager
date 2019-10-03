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
            $table->increments('id');
            $table->string('date');
            $table->string('next_service_km')->nullable();
            $table->string('next_service_date')->nullable();
            $table->uuid('vehicle_id')->nullable();
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->integer('service_type_id')->nullable()->unsigned();
            $table->foreign('service_type_id')->references('id')->on('servicetypes');
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
