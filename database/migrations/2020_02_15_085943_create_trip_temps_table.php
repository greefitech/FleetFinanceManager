<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_temps', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('dateFrom');
            $table->string('dateTo')->nullable();
            $table->uuid('vehicleId');
            $table->foreign('vehicleId')->references('id')->on('vehicles');
            $table->string('tripName');
            $table->string('startKm')->nullable();
            $table->string('endKm')->nullable();
            $table->string('totalKm')->nullable();
            $table->string('advance')->nullable();
            $table->uuid('staff1')->nullable();
            $table->foreign('staff1')->references('id')->on('staff');
            $table->uuid('staff2')->nullable();
            $table->foreign('staff2')->references('id')->on('staff');
            $table->uuid('staff3')->nullable();
            $table->foreign('staff3')->references('id')->on('staff');
            $table->integer('clientid')->unsigned();
            $table->foreign('clientid')->references('id')->on('clients');
            $table->integer('managerid')->unsigned()->nullable();
            $table->foreign('managerid')->references('id')->on('managers');
            $table->longText('entry')->nullable();
            $table->longText('diesel')->nullable();
            $table->longText('rto')->nullable();
            $table->longText('pc')->nullable();
            $table->longText('extraExpense')->nullable();
            $table->longText('tollgate')->nullable();
            $table->longText('driverAdvance')->nullable();
            $table->timestamps();
        });

        Schema::table('clients', function($table){
            $table->string('firebase_token')->nullable()->after('referral_number')->comment('firebase Token');
            $table->string('verified')->default(0)->after('firebase_token')->comment('1-login email verified,0-email not verified');
            $table->string('mail_notification')->default(0)->after('verified')->comment('1-send mail,0-not send mail');
            $table->string('client_status')->default(1)->after('mail_notification')->comment('1-active,0-inactive');
            $table->datetime('last_login_at')->nullable()->after('client_status')->comment('last login time');
            $table->string('last_login_ip')->nullable()->after('last_login_at')->comment('last login ip address');
            $table->softDeletes()->after('remember_token')->comment('soft delete');
        });

        Schema::create('client_log_activities', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject'); 
            $table->string('url'); 
            $table->string('method'); 
            $table->string('ip'); 
            $table->string('agent')->nullable(); 
            $table->integer('client_id')->nullable();
            $table->timestamps();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        Schema::table('document_types', function($table){
            $table->string('mail_notification')->default(0)->after('documentType')->comment('1-send;0-not now');
        });

        Schema::table('vehicles', function($table){
            $table->string('status')->default(1)->after('VehicleProfit')->comment('1-active;0-inactive');
            $table->string('status_at')->nullable()->after('status')->comment('status time stamp');
        });

        Schema::table('staff', function($table){
            $table->string('status')->default(1)->after('licenceRenewal')->comment('1-active;0-inactive');
            $table->string('status_at')->nullable()->after('status')->comment('status time stamp');
        });

        Schema::create('verify_clients', function (Blueprint $table) {
            $table->integer('client_id');
            $table->string('token');
            $table->timestamps();
        });

        Schema::create('vehicle_services', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->longText('title');
            $table->string('notification')->default(0);
            $table->integer('clientid')->unsigned()->nullable();
            $table->foreign('clientid')->references('id')->on('clients');
            $table->softDeletes();
            $table->timestamps();
        });
        
        Schema::create('services', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('date')->nullable();
            $table->string('service_station_name')->nullable();
            $table->string('next_service_date')->nullable();


            $table->string('service_km')->nullable();
            $table->string('next_service_km')->nullable();


            $table->string('note')->nullable();

            $table->uuid('vehicle_service_id')->nullable();
            $table->foreign('vehicle_service_id')->references('id')->on('vehicle_services');

            $table->uuid('vehicleId')->nullable();
            $table->foreign('vehicleId')->references('id')->on('vehicles');

            $table->integer('clientid')->unsigned()->nullable();
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
        Schema::dropIfExists('trip_temps');
        Schema::dropIfExists('client_log_activities');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('vehicle_services');
        Schema::dropIfExists('services');
    }
}
