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
        Schema::create('offer_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('amount');
            $table->string('vat');
            $table->string('payload');
            $table->string('commission_amout');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->bigInteger('offer_id')->unsigned()->index();
            $table->foreign('offer_id')->references('id')->on('offers')->onDelete('cascade');
            $table->boolean('isCanceled')->default(false);
            $table->date('canceled_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offer_invoices');
    }
};
