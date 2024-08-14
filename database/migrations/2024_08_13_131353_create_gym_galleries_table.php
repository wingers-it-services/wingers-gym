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
        Schema::create('gym_galleries', function (Blueprint $table) {
            $table->id()->index();
            $table->uuid()->index();
            $table->unsignedBigInteger('gym_id');
            $table->longText('upload_file');
            $table->string('file_type');
            $table->timestamps();
            $table->foreign('gym_id')->references('id')->on('gyms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_galleries');
    }
};
