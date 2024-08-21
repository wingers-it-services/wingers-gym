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
        Schema::table('user_body_measurements', function (Blueprint $table) {
            $table->integer('bmi_id')->after('user_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_body_measurements', function (Blueprint $table) {
            $table->dropColumn('bmi_id'); 
        });
    }
};
