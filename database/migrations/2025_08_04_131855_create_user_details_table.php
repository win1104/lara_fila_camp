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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('type')->nullable();
            $table->string('sn')->nullable();
            $table->string('pid')->nullable();
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->enum('gender', ['M', 'F', 'O'])->nullable();
            $table->date('birthday')->nullable();
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('fax')->nullable();
            $table->string('fb_id')->nullable();
            $table->string('line_id')->nullable();
            $table->string('website')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('district')->nullable();
            $table->string('zip')->nullable();
            $table->text('address')->nullable();
            $table->string('company')->nullable();
            $table->string('company_no')->nullable();
            $table->string('position')->nullable();
            $table->string('job_title')->nullable();
            $table->string('education')->nullable();
            $table->text('note')->nullable();
            $table->boolean('verify')->default(false);
            $table->string('verify_code')->nullable();
            $table->boolean('frozen')->default(false);
            $table->boolean('check')->default(false);
            $table->integer('login_count')->nullable()->default(0);
            $table->timestamp('expired')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');


            // 複合索引：(用於全域搜尋)
            $table->index(['sn', 'pid', 'mobile'], 'idx_user_details_search');
            // 複合索引：(用於 slug 搜尋)
            $table->index(['pid', 'mobile'], 'idx_user_details_slug');
            // 單一索引：(用於標題搜尋)
            $table->index('pid', 'idx_user_details_pid');
            $table->index('mobile', 'idx_user_details_mobile');
            $table->index('sn', 'idx_user_details_sn');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('slug', 8)->unique()->nullable()->after('id');
            $table->unsignedBigInteger('creator_id')->nullable()->after('status');

            $table->foreign('creator_id')
                ->references('id')->on('admins');

            // 複合索引：(用於全域搜尋)
            $table->index(['slug', 'name', 'email'], 'idx_users_search');
            // 複合索引：(用於 slug 搜尋)
            $table->index(['slug', 'name'], 'idx_users_slug');
            // 單一索引：(用於標題搜尋)
            $table->index('slug', 'idx_users_slug_only');
            $table->index('name', 'idx_users_name');
            $table->index('email', 'idx_users_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');

        Schema::table('users', function (Blueprint $table) {
            // 刪除索引
            $table->dropIndex('idx_users_search');
            $table->dropIndex('idx_users_slug');
            $table->dropIndex('idx_users_slug_only');
            $table->dropIndex('idx_users_name');
            $table->dropIndex('idx_users_email');

            // 刪除外鍵約束
            $table->dropForeign(['creator_id']);

            // 刪除欄位
            $table->dropColumn(['slug', 'creator_id']);
        });
    }
};
