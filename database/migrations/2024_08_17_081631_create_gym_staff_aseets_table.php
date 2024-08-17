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
        Schema::create('gym_staff_aseets', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->string('gym_id');
            $table->string('staff_id');
            $table->string('name');
            $table->string('category');
            $table->string('asset_tag');
            $table->string('allocation_date');
            $table->float('price');
            $table->integer('status');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_staff_aseets');
    }
};
