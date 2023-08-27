<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_ledgers', function (Blueprint $table) {
            $table->increments('supplier_ledger_id');
            $table->bigInteger('supplier_id')->nullable();
            $table->bigInteger('supplier_account_id')->nullable();
            $table->bigInteger('supplier_transaction_id')->nullable();
            $table->string('supplier_ledger_type')->nullable();
            $table->bigInteger('supplier_ledger_invoice_id')->nullable();
            $table->bigInteger('supplier_ledger_money_receipt_id')->nullable();
            $table->bigInteger('supplier_ledger_refund_id')->nullable();
            $table->string('supplier_ledger_status')->nullable();
            $table->bigInteger('supplier_ledger_last_balance')->nullable();
            $table->bigInteger('supplier_ledger_dr')->nullable();
            $table->bigInteger('supplier_ledger_cr')->nullable();
            $table->string('supplier_ledger_date')->nullable();
            $table->string('supplier_ledger_create_date')->nullable();
            $table->string('supplier_ledger_prepared_by')->nullable();
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
        Schema::dropIfExists('supplier_ledgers');
    }
}
