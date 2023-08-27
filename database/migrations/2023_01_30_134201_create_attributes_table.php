<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('attributes_id');
            $table->string('attributes_name')->nullable();
            $table->string('attributes_entry_id')->nullable();
            $table->string('attributes_is_deleted')->default('NO');
            $table->string('attributes_created_by')->nullable();
            $table->string('attributes_updated_by')->nullable();
            $table->string('attributes_deleted_by')->nullable();
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
        Schema::dropIfExists('attributes');
    }
}