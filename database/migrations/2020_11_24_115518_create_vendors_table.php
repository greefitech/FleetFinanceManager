<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('mobile')->nullable();
            $table->string('gst')->nullable();
            $table->string('address')->nullable();
            $table->integer('clientid')->unsigned();
            $table->foreign('clientid')->references('id')->on('clients');
            $table->integer('managerid')->unsigned()->nullable();
            $table->foreign('managerid')->references('id')->on('managers');
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::table('expenses', function($table){
            $table->string('paid_status')->default(1);
            $table->uuid('vendor_id')->nullable()->after('tripId');
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->longText('image')->nullable()->after('vendor_id');
        });
        Schema::create('vendor_expense_payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('date');
            $table->string('amount')->nullable();
            $table->string('discount')->nullable();
            $table->string('account_id')->nullable();
            $table->uuid('vendor_id')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->uuid('expense_id')->nullable();
            $table->foreign('expense_id')->references('id')->on('expenses');
            $table->integer('clientid')->unsigned();
            $table->foreign('clientid')->references('id')->on('clients');
            $table->integer('managerid')->unsigned()->nullable();
            $table->foreign('managerid')->references('id')->on('managers');
            $table->timestamps();
        });

        Schema::create('client_notification_scrolls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('except')->nullable();
            $table->longText('content');
            $table->integer('clientid')->unsigned()->nullable();
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
        Schema::dropIfExists('vendors');
    }
}
