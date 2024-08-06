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
        Schema::create('shop_subscription_plan_translations', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->string('value');
            $table->string('lang');
            $table->foreignId('shop_subscription_plan_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_subscription_plan_translations');
    }
};
