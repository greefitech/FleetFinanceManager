<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTyreLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tyre_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('transaction')->nullable();
            $table->uuid('vehicleId')->nullable();
            $table->foreign('vehicleId')->references('id')->on('vehicles');
            $table->uuid('tyre_id')->nullable();
            $table->foreign('tyre_id')->references('id')->on('tyres');
            $table->string('position')->nullable();
            $table->string('km')->nullable();
            $table->string('current_depth')->nullable();
            $table->string('note')->nullable();
            $table->uuid('staffId')->nullable();
            $table->foreign('staffId')->references('id')->on('staff');
            $table->integer('clientid')->unsigned();
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
        Schema::dropIfExists('tyre_logs');
    }
}
