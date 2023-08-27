<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('product_id');
            $table->string('product_name')->nullable();
            $table->string('product_entry_id')->nullable();
            $table->string('product_category')->nullable();
            $table->longText('product_code')->nullable();
            $table->string('product_retail_price')->nullable();
            $table->string('product_wholesale_price')->nullable();
            $table->string('product_status')->default(1);
            $table->string('product_is_deleted')->default('NO');
            $table->string('product_created_by')->nullable();
            $table->string('product_updated_by')->nullable();
            $table->string('product_deleted_by')->nullable();
            $table->string('product_created_at')->nullable();
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
        Schema::dropIfExists('products');
    }
}
