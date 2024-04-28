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
        Schema::create('slides', function (Blueprint $table) {
            $table->id(); 
            $table->bigInteger('upload_id')->unsigned()->index();
            $table->foreign('upload_id')->references('id')->on('uploads')->onDelete('cascade');
            $table->bigInteger('slider_id')->unsigned()->index();
            $table->foreign('slider_id')->references('id')->on('sliders')->onDelete('cascade');
            $table->boolean('status')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('slides');
    }
};
