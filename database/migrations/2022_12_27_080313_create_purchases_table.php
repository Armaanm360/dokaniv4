<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->increments('purchase_id');
            $table->string('purchase_warehouse_id')->nullable();
            $table->string('purchase_supplier_id')->nullable();
            $table->string('purchase_number')->nullable();
            $table->string('purchase_po_reference')->nullable();
            $table->longText('purchase_payment_terms')->nullable();
            $table->string('purchase_date')->nullable();
            $table->string('due_date')->nullable();
            $table->longText('purchase_note')->nullable();
            $table->string('purchase_quantity')->nullable();
            $table->string('purchase_subtotal')->nullable();
            $table->string('purchase_discount')->nullable();
            $table->string('purchase_net_total')->nullable();
            $table->string('purchase_status')->default(1);
            $table->string('purchase_is_deleted')->default('NO');
            $table->string('purchase_created_by')->nullable();
            $table->string('purchase_updated_by')->nullable();
            $table->string('purchase_deleted_by')->nullable();
            $table->string('purchase_created_at')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
