<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOwnerIdToUserDriverNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_driver_notifications', function (Blueprint $table) {
            if (Schema::hasTable('user_driver_notifications')) {
                if (!Schema::hasColumn('user_driver_notifications', 'owner_id')) {
                    Schema::table('user_driver_notifications', function (Blueprint $table) {
                        $table->uuid('owner_id')->nullable()->after('notify_id');
    
                        $table->foreign('owner_id')
                            ->references('id')
                            ->on('owners')
                            ->onDelete('cascade');
                    });
                }
    
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_driver_notifications', function (Blueprint $table) {
            //
        });
    }
}
