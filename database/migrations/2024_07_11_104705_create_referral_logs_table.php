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
        Schema::create('referral_logs', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('referral_id')->unsigned()->index();
            $table->foreign('referral_id')->references('id')->on('referrals')->onDelete('cascade');
            $table->enum('referral_event',['USER_REGISTRATION','OFFER_SHARE']); 
            $table->integer('model_id');
            $table->string('model_type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('referral_logs');
    }
};
