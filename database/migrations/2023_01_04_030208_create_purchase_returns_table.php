<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->increments('purchase_return_id');
            $table->string('purchase_return_supplier_id')->nullable();
            $table->string('purchase_number')->nullable();
            $table->string('purchase_return_number')->nullable();
            $table->string('purchase_total_quantity')->nullable();
            $table->string('purchase_return_total_quantity')->nullable();
            $table->string('purchase_subtotal')->nullable();
            $table->string('purchase_return_subtotal')->nullable();
            $table->string('purchase_discount')->nullable();
            $table->string('purchase_return_discount')->nullable();
            $table->string('purchase_net_total')->nullable();
            $table->string('purchase_return_net_total')->nullable();
            $table->string('purchase_return_status')->default(1);
            $table->string('purchase_return_is_deleted')->default('NO');
            $table->string('purchase_return_created_by')->nullable();
            $table->string('purchase_return_updated_by')->nullable();
            $table->string('purchase_return_deleted_by')->nullable();
            $table->string('purchase_return_created_at')->nullable();
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
        Schema::dropIfExists('purchase_returns');
    }
}
