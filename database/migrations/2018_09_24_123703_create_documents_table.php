<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('documentType')->unsigned();
            $table->foreign('documentType')->references('id')->on('document_types');
            $table->string('duedate');
            $table->integer('notifyBefore')->default(10);
            $table->integer('interval');
            $table->string('issuingCompany')->nullable();
            $table->string('amount')->nullable();
            $table->string('notes')->nullable();
            $table->uuid('vehicleId');
            $table->foreign('vehicleId')->references('id')->on('vehicles');
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
        Schema::dropIfExists('documents');
    }
}
