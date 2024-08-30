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
        Schema::create('current_day_diets', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->unsignedBigInteger('diet_id')->index();
            $table->unsignedBigInteger('user_diet_id')->index();
            $table->unsignedBigInteger('gym_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->longText('details');
            $table->integer('total_fats');
            $table->integer('total_carbs');
            $table->integer('total_protein');
            $table->integer('total_calories');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('current_day_diets');
    }
};
