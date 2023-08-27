<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientLedgersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_ledgers', function (Blueprint $table) {
            $table->increments('client_ledger_id');
            $table->bigInteger('client_id')->nullable();
            $table->bigInteger('client_account_id')->nullable();
            $table->bigInteger('client_transaction_id')->nullable();
            $table->string('client_ledger_type')->nullable();
            $table->bigInteger('client_ledger_invoice_id')->nullable();
            $table->bigInteger('client_ledger_money_receipt_id')->nullable();
            $table->bigInteger('client_ledger_refund_id')->nullable();
            $table->string('client_ledger_status')->nullable();
            $table->bigInteger('client_ledger_last_balance')->nullable();
            $table->bigInteger('client_ledger_dr')->nullable();
            $table->bigInteger('client_ledger_cr')->nullable();
            $table->string('client_ledger_date')->nullable();
            $table->string('client_ledger_create_date')->nullable();
            $table->string('client_ledger_prepared_by')->nullable();
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
        Schema::dropIfExists('client_ledgers');
    }
}
