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
        Schema::create('user_coupon_redeem_history', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('coupon_id')->unsigned()->index();
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('cascade');

            $table->bigInteger('coupon_variation_lic_id')->unsigned()->index();
            $table->foreign('coupon_variation_lic_id')->references('id')->on('coupon_variation_lics')->onDelete('cascade');
            
            $table->bigInteger('user_wallet_transaction_id')->unsigned()->index();
            $table->foreign('user_wallet_transaction_id')->references('id')->on('user_wallet_transactions')->onDelete('cascade');
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_coupon_redeem_history');
    }
};
