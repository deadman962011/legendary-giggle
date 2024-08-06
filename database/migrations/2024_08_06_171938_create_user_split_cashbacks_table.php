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
        Schema::create('user_split_cashbacks', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('total_amount');
            $table->bigInteger('offer_invoice_id')->unsigned()->index();
            $table->foreign('offer_invoice_id')->references('id')->on('offer_invoices')->onDelete('cascade');
            $table->bigInteger('user_id')->unsigned()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_split_cashbacks');
    }
};
