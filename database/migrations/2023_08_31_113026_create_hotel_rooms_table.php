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
        Schema::create('hotel_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id')->nullable()->default(null);
            $table->unsignedBigInteger('type_id')->nullable()->default(null);
            $table->float('price', 8, 2)->nullable()->default(null);
            $table->tinyInteger('status')->default(1)->comment('0: Inactive, 1: Active');
            $table->tinyInteger('is_available')->default(1)->comment('0: Not Available, 1: Available');
            $table->integer('quantity')->nullable()->default(null);
            $table->integer('room_number')->nullable()->default(null);
            $table->integer('capacity')->nullable()->default(null);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('hotel_id')->references('id')->on('hotels');
            $table->foreign('type_id')->references('id')->on('room_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hotel_rooms');
    }
};
