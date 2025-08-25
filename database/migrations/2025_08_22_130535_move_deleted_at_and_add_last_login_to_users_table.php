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
        // 先移除 user_details 的 soft deletes
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropSoftDeletes();
        });

        // 在 users 表新增 last_login_at 和 soft deletes
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_login_at')->nullable()->after('creator_id');
            $table->softDeletes()->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 回復 users 表的變更
        Schema::table('users', function (Blueprint $table) {
            $table->dropSoftDeletes();
            $table->dropColumn('last_login_at');
        });

        // 回復 user_details 的 soft deletes
        Schema::table('user_details', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
};
