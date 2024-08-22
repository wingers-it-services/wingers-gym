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
        Schema::table('gym_users', function (Blueprint $table) {
            $table->date('subscription_start_date')->nullable()->after('subscription_id');
            $table->renameColumn('end_date', 'subscription_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gym_users', function (Blueprint $table) {
            $table->dropColumn('subscription_start_date'); 
            $table->renameColumn('subscription_end_date', 'end_date');
        });
    }
};
