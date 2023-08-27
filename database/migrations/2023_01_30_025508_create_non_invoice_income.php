<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNonInvoiceIncome extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('non_invoice_income', function (Blueprint $table) {
            $table->increments('non_invoice_id');
            $table->integer('non_invoice_client_id');
            $table->integer('non_invoice_account_id');
            $table->integer('non_invoice_account_transaction_id');
            $table->integer('non_invoice_client_transaction_id');
            $table->integer('non_invoice_amount');
            $table->string('non_invoice_date')->nullable();
            $table->string('non_invoice_note')->nullable();
            $table->string('non_invoice_created_by')->nullable();
            $table->string('non_invoice_updated_by')->nullable();
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
        Schema::dropIfExists('non_invoice_income');
    }
}
