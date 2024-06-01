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
        Schema::create('user_wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->string('reason');
            $table->string('type');
            $table->bigInteger('wallet_id')->unsigned()->index();
            $table->foreign('wallet_id')->references('id')->on('user_wallets')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_wallet_transactions');
    }
};
