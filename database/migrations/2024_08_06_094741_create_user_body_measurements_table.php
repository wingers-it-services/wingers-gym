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
        Schema::create('user_body_measurements', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->integer('gym_id');
            $table->integer('user_id');
            $table->float('chest');
            $table->float('triceps');
            $table->float('biceps');
            $table->float('lats');
            $table->float('shoulder');
            $table->float('abs');
            $table->float('forearms');
            $table->float('traps');
            $table->float('glutes');
            $table->float('quads');
            $table->float('hamstring');
            $table->float('calves');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_body_measurements');
    }
};
