<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAcceptedAndDeclinedToReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->unsignedBigInteger('accepted_by_user_id')->nullable();
            $table->unsignedBigInteger('declined_by_user_id')->nullable();

            $table->foreign('accepted_by_user_id')->references('id')->on('users');
            $table->foreign('declined_by_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn('accepted_by_user_id');
            $table->dropColumn('declined_by_user_id');
        });
    }
}
