<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditorExpenseTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auditor_expense_types', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('auditor_expense_category_id');
            $table->foreign('auditor_expense_category_id')->references('id')->on('auditor_expense_categories');
            $table->integer('expense_type_id')->unsigned();
            $table->foreign('expense_type_id')->references('id')->on('expense_types');
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
        Schema::dropIfExists('auditor_expense_types');
    }
}
