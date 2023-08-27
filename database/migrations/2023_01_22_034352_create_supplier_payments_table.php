<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupplierPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->increments('payment_id');
            $table->bigInteger('supplier_id')->nullable();
            $table->bigInteger('supplier_payment_type')->default(0);
            $table->date('date')->nullable();
            $table->double('amount',10,2)->nullable();
            $table->bigInteger('transactionAccountID')->nullable();
            $table->string('note')->nullable();
            $table->bigInteger('warehouse_id')->nullable();
            $table->string('created_by')->nullable();
            $table->string('updated_by')->nullable();
            $table->string('deleted_by')->nullable();
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
        Schema::dropIfExists('supplier_payments');
    }
}
