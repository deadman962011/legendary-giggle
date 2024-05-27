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
        Schema::create('coupon_variations', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('coupon_id')->unsigned()->index();
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');
            $table->string('amount');   
            $table->boolean('status')->default(false);
            $table->boolean('isDeleted')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_variations');
    }
};
