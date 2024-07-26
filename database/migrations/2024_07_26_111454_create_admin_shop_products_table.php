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
        Schema::create('admin_shop_products', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->string('image');
            $table->string('product_name');
            $table->string('product_code');
            $table->string('product_brand')->nullable();
            $table->string('address');
            $table->string('availability')->nullable();
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
        Schema::dropIfExists('admin_shop_products');
    }
};
