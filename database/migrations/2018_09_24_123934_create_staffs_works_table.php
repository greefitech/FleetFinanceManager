<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStaffsWorksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staffs_works', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('staffId');
            $table->foreign('staffId')->references('id')->on('staff');
            $table->uuid('entryId');
            $table->foreign('entryId')->references('id')->on('entries');
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
        Schema::dropIfExists('staffs_works');
    }
}
