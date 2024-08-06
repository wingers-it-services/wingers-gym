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
            $table->dropColumn('employee_id');
            $table->dropColumn('member_number');
            $table->date('end_date')->nullable();
            $table->integer('coupon_id')->nullable();
            $table->integer('subscription_status')->nullable();
            $table->integer('profile_status')->default(0);
            $table->integer('staff_assign_id')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gym_users', function (Blueprint $table) {
            $table->string('employee_id');
            $table->string('member_number');
            $table->dropColumn('end_date');
            $table->dropColumn('coupon_id');
            $table->dropColumn('subscription_status');
            $table->dropColumn('profile_status');
            $table->dropColumn('staff_assign_id');
        });
    }
};
