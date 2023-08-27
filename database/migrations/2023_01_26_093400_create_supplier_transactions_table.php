<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_transactions', function (Blueprint $table) {
            $table->increments('supplier_transaction_id');
            $table->string('supplier_transaction_type')->nullable();
            $table->bigInteger('supplier_transaction_account_id')->nullable();
            $table->bigInteger('supplier_transaction_supplier_id')->nullable();
            $table->bigInteger('supplier_warehouse_id')->nullable();
            $table->string('supplier_payment_type')->nullable();
            $table->string('supplier_transaction_amount')->nullable();
            $table->string('supplier_transaction_last_balance')->nullable();
            $table->bigInteger('supplier_transaction_opening_balance')->nullable();
            $table->string('supplier_transaction_date')->nullable();
            $table->string('supplier_transaction_note')->nullable();
            $table->string('supplier_transaction_create_date')->nullable();
            $table->string('supplier_transaction_has_deleted')->default('NO');
            $table->string('supplier_transaction_deleted_by');
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
        Schema::dropIfExists('supplier_transactions');
    }
}
