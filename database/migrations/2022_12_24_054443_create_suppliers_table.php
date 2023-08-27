<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('supplier_id');
            $table->string('supplier_name')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('supplier_entry_id')->nullable();
            $table->string('supplier_email')->nullable();
            $table->string('supplier_phone_number')->nullable();
            $table->string('supplier_opening_balance')->nullable();
            $table->longText('supplier_address')->nullable();
            $table->string('supplier_image')->nullable();
            $table->string('supplier_status')->default(1);
            $table->string('supplier_is_deleted')->default('NO');
            $table->string('supplier_created_by')->nullable();
            $table->string('supplier_updated_by')->nullable();
            $table->string('supplier_deleted_by')->nullable();
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
        Schema::dropIfExists('suppliers');
    }
}
