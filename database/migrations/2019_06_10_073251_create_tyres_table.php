<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTyresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tyres', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('date');
            $table->string('tyre_number');
            $table->string('model')->nullable();
            $table->string('manufacture_company')->nullable();
            $table->string('condition')->nullable();
            $table->string('original_depth')->nullable();
            $table->string('current_depth')->nullable();
            $table->string('purchased_from')->nullable();
            $table->string('tyre_status')->nullable();
            $table->string('is_sold')->default(0);
            $table->uuid('vehicleId')->nullable();
            $table->foreign('vehicleId')->references('id')->on('vehicles');
            $table->integer('clientid')->unsigned();
            $table->foreign('clientid')->references('id')->on('clients');
            $table->integer('managerid')->unsigned()->nullable();
            $table->foreign('managerid')->references('id')->on('managers');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('assign_tyres', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('vehicleId')->nullable();
            $table->foreign('vehicleId')->references('id')->on('vehicles');
            $table->uuid('tyre_id')->nullable();
            $table->foreign('tyre_id')->references('id')->on('tyres');
            $table->string('position')->nullable();
            $table->integer('clientid')->unsigned();
            $table->foreign('clientid')->references('id')->on('clients');
            $table->integer('managerid')->unsigned()->nullable();
            $table->foreign('managerid')->references('id')->on('managers');
            $table->timestamps();
        });

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

        Schema::table('documents', function($table){
            $table->string('file')->nullable()->after('notes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tyres');
        Schema::dropIfExists('assign_tyres');
        Schema::dropIfExists('tyre_logs');
    }
}
