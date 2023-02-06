<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateZoneSurgeDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('zone_surge_days', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zone_surge_price_id');
            $table->string('week_day');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('zone_surge_price_id')
                ->references('id')
                ->on('zone_surge_prices')
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
        Schema::dropIfExists('zone_surge_days');
    }
}
