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
        Schema::create('diet_analytics', function (Blueprint $table) {
            $table->id()->index();
            $table->uuid()->index();
            $table->string('month');
            $table->string('year');
            $table->unsignedBigInteger('gym_id')->index();
            $table->unsignedBigInteger('user_id')->index();
            $table->unsignedBigInteger('diet_id')->index();
            $table->unsignedBigInteger('user_diet_id')->index();
            $table->integer('total_fats');
            $table->integer('total_fats_consumed');
            $table->integer('total_carbs');
            $table->integer('total_carbs_consumed');
            $table->integer('total_protein');
            $table->integer('total_protein_consumed');
            $table->integer('total_calories');
            $table->integer('total_calories_consumed');
            $table->float('fat_percentage');
            $table->float('carb_percentage');
            $table->float('protein_percentage');
            $table->float('calories_percentage');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diet_analytics');
    }
};
