<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosSaleProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_sale_products', function (Blueprint $table) {
            $table->increments('sale_product_id');
            $table->bigInteger('invoiceNo')->nullable();
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('size_id')->nullable();
            $table->bigInteger('color_id')->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->bigInteger('price')->nullable();
            $table->string('sales_date')->nullable();
            $table->bigInteger('subTotal')->nullable();
            $table->bigInteger('discount_amount')->nullable();
            $table->string('create_date')->nullable();
            $table->string('has_deleted')->default('NO');
            $table->bigInteger('created_by')->nullable();
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
        Schema::dropIfExists('pos_sale_products');
    }
}
