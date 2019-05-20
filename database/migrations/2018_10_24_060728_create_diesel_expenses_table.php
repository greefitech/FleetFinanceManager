<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDieselExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('diesel_expenses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('date');
            $table->uuid('vehicleId');
            $table->foreign('vehicleId')->references('id')->on('vehicles');
            $table->string('quantity')->nullable();
            $table->string('amount');
            $table->text('discription')->nullable();
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
        Schema::dropIfExists('diesel_expenses');
    }
}
