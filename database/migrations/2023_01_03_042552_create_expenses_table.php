<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenses', function (Blueprint $table) {
            $table->increments('expense_id');
            $table->bigInteger('expense_head_id')->nullable();
            $table->bigInteger('expense_sub_head_id')->nullable();
            $table->bigInteger('expense_account')->nullable();
            $table->bigInteger('expense_amount')->nullable();
            $table->string('created_by')->nullable();
            $table->string('is_deleted')->default('NO');
            $table->string('deleted_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('status')->default('1');
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
        Schema::dropIfExists('expenses');
    }
}
