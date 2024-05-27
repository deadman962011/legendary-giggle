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
        Schema::create('coupon_variation_lics', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->boolean('status')->default(false);
            $table->boolean('isGranted')->default(false);
            $table->bigInteger('coupon_variation_id')->unsigned()->index();
            $table->foreign('coupon_variation_id')->references('id')->on('coupon_variations')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_variation_lics');
    }
};
