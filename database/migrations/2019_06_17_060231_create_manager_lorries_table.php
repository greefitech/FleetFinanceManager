<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagerLorriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manager_lorries', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('vehicleId');
            $table->foreign('vehicleId')->references('id')->on('vehicles');
            $table->string('manager_login_id')->nullable();
            $table->timestamps();
        });

        Schema::table('vehicles', function($table)
        {
            $table->string('engine_number')->nullable()->after('modelNumber');
            $table->string('chassis_number')->nullable()->after('engine_number');
            $table->string('manufacture_date')->nullable()->after('chassis_number');
            $table->string('fuel_tank_capacity')->nullable()->after('manufacture_date');
        });

        Schema::table('clients', function($table)
        {
            $table->string('profile_image')->nullable()->after('expires_on');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('manager_lorries');
    }
}
