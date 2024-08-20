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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->uuid()->unique();
            $table->integer('gym_id');
            $table->string('name');
            $table->string('product_code');
            $table->string('brand');
            $table->string('category');
            $table->string('product_tag');
            $table->float('total_rating');
            $table->float('price');
            $table->float('review_count');
            $table->integer('availability');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
