<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_values', function (Blueprint $table) {
            $table->increments('attributes_value_id');
            $table->string('attributes_id')->nullable();
            $table->string('attributes_value')->nullable();
            $table->string('attributes_value_entry_id')->nullable();
            $table->string('attributes_value_is_deleted')->default('NO');
            $table->string('attributes_value_created_by')->nullable();
            $table->string('attributes_value_updated_by')->nullable();
            $table->string('attributes_value_deleted_by')->nullable();
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
        Schema::dropIfExists('attribute_values');
    }
}