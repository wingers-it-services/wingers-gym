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
        Schema::create('user_diets', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->integer('user_id');
            $table->string('meal_name');
            $table->integer('calories');
            $table->integer('protein');
            $table->integer('carbs');
            $table->integer('fats');
            $table->longText('notes');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_diets');
    }
};
