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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('premalink')->unique();
            $table->bigInteger('start_date');
            $table->bigInteger('end_date');
            $table->string('cashback_amount');
            $table->integer('thumbnail')->nullable();
            $table->integer('menu')->nullable();
            $table->bigInteger('shop_id')->unsigned()->index();
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(false);
            $table->boolean('isDeleted')->default(false);
            $table->boolean('isPaid')->default(false);
            $table->date('paid_at')->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
