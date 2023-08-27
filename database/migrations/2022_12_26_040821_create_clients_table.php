<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('client_id');
            $table->string('client_name')->nullable();
            $table->string('branch_id')->nullable();
            $table->string('client_entry_id')->nullable();
            $table->string('client_type')->nullable();
            $table->string('client_email')->nullable();
            $table->string('client_phone_number')->nullable();
            $table->longText('client_address')->nullable();
            $table->string('client_image')->nullable();
            $table->string('client_status')->default(1);
            $table->string('client_is_deleted')->default('NO');
            $table->string('client_created_by')->nullable();
            $table->string('client_updated_by')->nullable();
            $table->string('client_deleted_by')->nullable();
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
        Schema::dropIfExists('clients');
    }
}
