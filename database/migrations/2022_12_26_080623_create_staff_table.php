<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('staff_id');
            $table->string('staff_name')->nullable();
            $table->string('staff_entry_id')->nullable();
            $table->string('staff_status')->default(1);
            $table->string('staff_is_deleted')->default('NO');
            $table->string('staff_created_by')->nullable();
            $table->string('staff_updated_by')->nullable();
            $table->string('staff_deleted_by')->nullable();
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
        Schema::dropIfExists('staff');
    }
}
