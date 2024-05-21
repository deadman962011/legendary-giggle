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
        Schema::create('shop_availabiltiy_slots', function (Blueprint $table) {
            $table->id();
            $table->String('start')->nullable();
            $table->String('end')->nullable();
            $table->bigInteger('shop_availability_id')->unsigned()->index();
            $table->foreign('shop_availability_id')->references('id')->on('shop_availabiltiys')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_availabiltiy_slots');
    }
};
