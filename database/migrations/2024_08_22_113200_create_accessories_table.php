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
        Schema::create('accessories', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->bigInteger('gym_id')->index();
            $table->string('name');
            $table->string('category');
            $table->string('brand_name');
            $table->string('model_number')->nullable();
            $table->integer('quantity')->default(0);
            $table->double('price');
            $table->string('condition')->nullable();
            $table->longText('description');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accessories');
    }
};
