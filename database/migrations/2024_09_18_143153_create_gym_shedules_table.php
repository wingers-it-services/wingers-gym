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
        Schema::create('gym_shedules', function (Blueprint $table) {
            $table->id()->index();
            $table->uuid()->index();
            $table->unsignedBigInteger('gym_id')->index();
            $table->text('event_name');
            $table->integer('week_day');
            $table->time('start_time');
            $table->time('end_time');
            $table->boolean('is_recurring')->default(false);
            $table->longText('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gym_shedules');
    }
};
