<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('branch_id');
            $table->string('branch_name')->nullable();
            $table->string('branch_entry_id')->nullable();
            $table->string('branch_phone_number')->nullable();
            $table->longText('branch_address')->nullable();
            $table->string('branch_status')->default(1);
            $table->string('branch_is_deleted')->default('NO');
            $table->string('branch_created_by')->nullable();
            $table->string('branch_updated_by')->nullable();
            $table->string('branch_deleted_by')->nullable();
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
        Schema::dropIfExists('branches');
    }
}
