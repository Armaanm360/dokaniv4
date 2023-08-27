<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_returns', function (Blueprint $table) {
            $table->increments('sale_return_id');
            $table->bigInteger('sale_id')->null();
            $table->bigInteger('branch_id')->null();
            $table->bigInteger('return_amount')->null();
            $table->bigInteger('return_charge')->null();
            $table->bigInteger('return_account')->null();
            $table->bigInteger('return_quantity')->null();
            $table->string('return_sale_date')->null();
            $table->bigInteger('return_sale_created_by')->null();
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
        Schema::dropIfExists('invoice_returns');
    }
}
