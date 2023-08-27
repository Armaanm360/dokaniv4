<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->increments('purchase_items_id');
            $table->string('purchase_id')->nullable();
            $table->string('purchase_product_id')->nullable();
            $table->string('purchase_product_size')->nullable();
            $table->string('purchase_product_color')->nullable();
            $table->string('purchase_product_quantity')->nullable();
            $table->string('purchase_product_price')->nullable();
            $table->string('purchase_product_total_price')->nullable();
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
        Schema::dropIfExists('purchase_items');
    }
}
