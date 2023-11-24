<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('seat_id');
            $table->unsignedBigInteger('from_station_id');
            $table->unsignedBigInteger('to_station_id');
            $table->unsignedBigInteger('trip_id');

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('from_station_id')->references('id')->on('stations');
            $table->foreign('to_station_id')->references('id')->on('stations');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('seat_id')->references('id')->on('seats');
            $table->foreign('trip_id')->references('id')->on('trips');

            $table->unique(['seat_id', 'from_station_id', 'to_station_id', 'trip_id'], 'unique_booking_combination');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
