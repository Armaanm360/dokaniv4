<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_return_items', function (Blueprint $table) {
            $table->increments('purchase_return_item_id');
            $table->string('purchase_return_id')->nullable();
            $table->string('purchase_number')->nullable();
            $table->string('purchase_product_id')->nullable();
            $table->string('purchase_product_size')->nullable();
            $table->string('purchase_product_color')->nullable();
            $table->string('purchase_product_quantity')->nullable();
            $table->string('purchase_product_return_quantity')->nullable();
            $table->string('purchase_product_price')->nullable();
            $table->string('purchase_product_total_price')->nullable();
            $table->string('purchase_return_product_total_price')->nullable();
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
        Schema::dropIfExists('purchase_return_items');
    }
}
