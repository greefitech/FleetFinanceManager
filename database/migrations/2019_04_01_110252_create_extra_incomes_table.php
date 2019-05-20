<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtraIncomesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_incomes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('date');
            $table->uuid('vehicleId');
            $table->foreign('vehicleId')->references('id')->on('vehicles');
            $table->integer('expense_type')->unsigned();
            $table->foreign('expense_type')->references('id')->on('expense_types');
            $table->string('amount');
            $table->string('account_id')->nullable();
            $table->string('status')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('extra_incomes');
    }
}
