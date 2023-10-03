<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Reference to users table
            $table->unsignedBigInteger('item_id')->nullable()->default(NULL); // Reference to items table
            $table->date('reservationDate'); // Date of Reservation
            $table->time('reservationTime'); // Reservation Time
            $table->unsignedBigInteger('room_id'); // Reference to rooms table
            $table->time('timelimit'); // Time Limit
            $table->string('status', 20)->default('Pending'); // Reservation Status (default: Pending)
            $table->text('remarks')->nullable(); // Remarks (nullable)
            $table->timestamps();

            // Add foreign key constraints
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('item_id')->references('id')->on('items');
            $table->foreign('room_id')->references('id')->on('rooms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
