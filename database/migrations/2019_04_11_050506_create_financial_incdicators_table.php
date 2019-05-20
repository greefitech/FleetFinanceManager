<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinancialIncdicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('financial_incdicators', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('vehicleId')->nullable()->unique();
            $table->foreign('vehicleId')->references('id')->on('vehicles');
            $table->longText('expense')->nullable();
            $table->longText('income')->nullable();
            $table->integer('clientid')->unsigned();
            $table->foreign('clientid')->references('id')->on('clients');
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
        Schema::dropIfExists('financial_incdicators');
    }
}
