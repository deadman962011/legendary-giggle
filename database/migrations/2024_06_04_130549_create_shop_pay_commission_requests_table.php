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
        Schema::create('shop_pay_commission_requests', function (Blueprint $table) {
            $table->id();            
            $table->bigInteger('offer_id')->unsigned()->index();
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->string('amount');
            $table->string('sender_full_name');
            $table->string('sender_phone');
            $table->longText('notice')->nullable();
            $table->longText('reason')->nullable();
            $table->string('deposit_at');
            $table->bigInteger('deposit_bank_account_id')->unsigned()->index();
            $table->foreign('deposit_bank_account_id')->references('id')->on('deposit_bank_accounts')->onDelete('cascade');
            $table->string('state')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_pay_commission_requests');
    }
};
