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
        Schema::create('diets', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->integer('gym_id');
            $table->string('image');
            $table->string('name');
            $table->string('diet');
            $table->string('gender');
            $table->string('alternative_diet')->nullable();
            $table->integer('min_age');
            $table->integer('max_age');
            $table->string('goal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diets');
    }
};
