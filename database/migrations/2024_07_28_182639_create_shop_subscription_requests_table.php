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
        Schema::create('shop_subscription_requests', function (Blueprint $table) {
            $table->id();

            $table->string('state')->default('pending');
            
            $table->bigInteger('shop_subscription_plan_id')->unsigned()->index();
            $table->foreign('shop_subscription_plan_id')->references('id')->on('shop_subscription_plans')->onDelete('cascade');
            
            $table->bigInteger('shop_id')->unsigned()->index();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');
            
            $table->string('sender_full_name');
            $table->string('sender_phone_number');
            $table->string('sender_bank_name');
            $table->string('sender_bank_account_number');
            $table->string('sender_bank_iban');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_subscription_requests');
    }
};
