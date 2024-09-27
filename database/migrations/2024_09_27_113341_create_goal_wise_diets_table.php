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
        Schema::create('goal_wise_diets', function (Blueprint $table) {
            $table->id()->index();
            $table->uuid()->index();
            $table->unsignedBigInteger('goal_id')->index();
            $table->unsignedBigInteger('diet_id')->index();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('goal_wise_diets');
    }
};
