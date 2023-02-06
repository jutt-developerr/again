<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_request', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('service_location_id')->nullable();
            $table->string('name');
            $table->string('number');
            $table->enum('user_type', ['admin','mobile-users']);
            $table->unsignedInteger('created_by')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('service_location_id')
                ->references('id')
                ->on('service_locations')
                ->onDelete('cascade');

            $table->foreign('created_by')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_request');
    }
}
