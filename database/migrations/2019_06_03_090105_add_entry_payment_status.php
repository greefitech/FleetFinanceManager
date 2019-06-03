<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEntryPaymentStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('entries', function($table)
        {
            $table->string('commission_status')->nullable()->after('comission');
            $table->string('loading_mamool_status')->nullable()->after('loadingMamool');
            $table->string('unloading_mamool_status')->nullable()->after('unLoadingMamool');
        });

        Schema::table('admins', function($table)
        {
            $table->string('mobile')->nullable()->unique()->after('password');
        });

        Schema::table('vehicle_types', function($table)
        {
            $table->string('wheel')->nullable()->after('vehicleType');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
