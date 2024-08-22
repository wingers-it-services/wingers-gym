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
        Schema::table('user_subscription_histories', function (Blueprint $table) {
            $table->renameColumn('joining_date', 'subscription_start_date');
            $table->renameColumn('end_date', 'subscription_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_subscription_histories', function (Blueprint $table) {
            $table->renameColumn('subscription_start_date', 'joining_date');
            $table->renameColumn('subscription_end_date', 'end_date');
        });
    }
};
