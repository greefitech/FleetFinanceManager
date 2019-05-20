<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('date');
            $table->integer('expense_type')->unsigned();
            $table->foreign('expense_type')->references('id')->on('expense_types');
            $table->uuid('vehicleId')->nullable();
            $table->foreign('vehicleId')->references('id')->on('vehicles');
            $table->uuid('staffId')->nullable();
            $table->foreign('staffId')->references('id')->on('staff');
            $table->string('quantity')->nullable();
            $table->string('amount');
            $table->text('location')->nullable();
            $table->text('discription')->nullable();
            $table->string('account_id')->nullable();
            $table->string('status')->nullable();
            $table->uuid('tripId')->nullable();
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
        Schema::dropIfExists('expenses');
    }
}
