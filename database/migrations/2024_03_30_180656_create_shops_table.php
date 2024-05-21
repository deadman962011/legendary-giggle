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
        Schema::create('shops', function (Blueprint $table) {
            // $table->integer('shop_logo');
            $table->id();
            $table->string('shop_name');
            $table->string('longitude');
            $table->string('latitude');
            $table->string('address')->nullable();
            $table->string('tax_register');
            $table->string('shop_contact_email');
            $table->string('shop_contact_phone');
            $table->boolean('featured')->default(false);
            $table->boolean('status')->default(false);
            $table->boolean('isDeleted')->default(false);
            
            $table->bigInteger('shop_logo')->unsigned()->index();
            $table->foreign('shop_logo')->references('id')->on('uploads')->onDelete('cascade');
            $table->bigInteger('zone_id')->unsigned()->index();
            $table->foreign('zone_id')->references('id')->on('zones')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
