<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->increments('product_category_id');
            $table->string('product_category_name')->nullable();
            $table->string('product_category_entry_id')->nullable();
            $table->string('product_category_status')->default(1);
            $table->string('product_category_is_deleted')->default('NO');
            $table->string('product_category_created_by')->nullable();
            $table->string('product_category_updated_by')->nullable();
            $table->string('product_category_deleted_by')->nullable();
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
        Schema::dropIfExists('product_categories');
    }
}
