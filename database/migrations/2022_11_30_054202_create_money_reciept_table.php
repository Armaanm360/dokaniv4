<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoneyRecieptTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_receipt', function (Blueprint $table) {
            $table->increments('money_receipt_id');
            $table->bigInteger('money_receipt_account_transaction_id')->nullable();
            $table->string('money_receipt_voucher_no')->nullable();
            $table->bigInteger('money_receipt_client_id')->nullable();
            $table->bigInteger('money_receipt_client_transaction_id')->nullable();
            $table->string('money_receipt_payment_to')->nullable();
            $table->bigInteger('money_receipt_total_amount')->nullable();
            $table->bigInteger('money_receipt_total_discount')->nullable();
            $table->string('money_receipt_payment_type')->nullable();
            $table->string('money_receipt_payment_date')->nullable();
            $table->string('money_receipt_note')->nullable();
            $table->string('money_receipt_payment_status')->nullable();
            $table->string('money_receipt_has_deleted')->default('NO');
            $table->bigInteger('money_receipt_deleted_by')->nullable();
            $table->bigInteger('money_receipt_created_by')->nullable();
            $table->bigInteger('money_receipt_updated_by')->nullable();
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
        Schema::dropIfExists('money_receipt');
    }
}
