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
        Schema::create('gym_user_attendences', function (Blueprint $table) {
            $table->id()->index();
            $table->uuid()->index();
            $table->unsignedBigInteger('gym_user_id');
            $table->unsignedBigInteger('gym_id')->nullable();
            $table->string('month')->nullable();
            $table->string('year')->nullable();
            $table->string('day1')->default(0);
            $table->string('day2')->default(0);
            $table->string('day3')->default(0);
            $table->string('day4')->default(0);
            $table->string('day5')->default(0);
            $table->string('day6')->default(0);
            $table->string('day7')->default(0);
            $table->string('day8')->default(0);
            $table->string('day9')->default(0);
            $table->string('day10')->default(0);
            $table->string('day11')->default(0);
            $table->string('day12')->default(0);
            $table->string('day13')->default(0);
            $table->string('day14')->default(0);
            $table->string('day15')->default(0);
            $table->string('day16')->default(0);
            $table->string('day17')->default(0);
            $table->string('day18')->default(0);
            $table->string('day19')->default(0);
            $table->string('day20')->default(0);
            $table->string('day21')->default(0);
            $table->string('day22')->default(0);
            $table->string('day23')->default(0);
            $table->string('day24')->default(0);
            $table->string('day25')->default(0);
            $table->string('day26')->default(0);
            $table->string('day27')->default(0);
            $table->string('day28')->default(0);
            $table->string('day29')->default(0);
            $table->string('day30')->default(0);
            $table->string('day31')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_user_attendences');
    }
};
