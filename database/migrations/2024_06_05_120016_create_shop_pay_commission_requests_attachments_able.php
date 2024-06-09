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
        Schema::create('shop_pay_commission_request_attachments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('upload_id')->unsigned()->index();
            $table->foreign('upload_id')->references('id')->on('uploads')->onDelete('cascade');
            $table->bigInteger('request_id')->unsigned()->index();
            $table->foreign('request_id')->references('id')->on('shop_pay_commission_requests')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_pay_commission_request_attachments');
    }
};
