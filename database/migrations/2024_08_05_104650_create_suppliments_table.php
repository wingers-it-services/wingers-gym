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
        Schema::create('suppliments', function (Blueprint $table) {
            $table->id();
            $table->uuid()->index();
            $table->string('suppliments_name');
            $table->string('brand_name');
            $table->longText('image');
            $table->float('rate');
            $table->float('comission');
            $table->float('discount');
            $table->float('gst');
            $table->float('amount');
            $table->string('company_name');
            $table->string('company_contact');
            $table->longText('company_address');
            $table->longText('company_website');
            $table->longText('description');
            $table->boolean('warrenty');
            $table->longText('warrenty_details')->nullable();
            $table->float('item_form');
            $table->string('manufacturer');
            $table->string('flavour');
            $table->string('age_range');
            $table->string('size');
            $table->integer('net_quantity');
            $table->string('diet_type');
            $table->longText('product_benefits');
            $table->string('item_dimensions');
            $table->longText('special_ingredients');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliments');
    }
};
