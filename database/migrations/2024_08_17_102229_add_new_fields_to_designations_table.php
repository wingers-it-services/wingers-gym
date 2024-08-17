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
        Schema::table('designations', function (Blueprint $table) {
            $table->boolean('is_commission_based')->after('status')->default(0);
            $table->boolean('is_assigned_to_member')->after('is_commission_based')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('designations', function (Blueprint $table) {
            $table->dropColumn('is_commission_based'); 
            $table->dropColumn('is_assigned_to_member'); 
        });
    }
};
