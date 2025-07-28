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
        Schema::table('post_relation', function (Blueprint $table) {
            // 新增 locale 欄位
            $table->string('locale')->after('id');
            
            // 新增 slug 欄位
            $table->string('post_slug')->after('locale');
            $table->string('post_category_slug')->after('post_slug');
            
            // 新增索引
            $table->index(['post_slug', 'locale']);
            $table->index(['post_category_slug', 'locale']);
        });
        
        // 移除舊的 ID 欄位（如果有資料，需要先遷移資料）
        Schema::table('post_relation', function (Blueprint $table) {
            $table->dropForeign(['post_id']);
            $table->dropForeign(['post_category_id']);
            $table->dropColumn(['post_id', 'post_category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('post_relation', function (Blueprint $table) {
            // 復原 ID 欄位
            $table->unsignedBigInteger('post_id')->after('id');
            $table->unsignedBigInteger('post_category_id')->after('post_id');
            
            // 復原外鍵
            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('post_category_id')->references('id')->on('post_categories');
            
            // 復原索引
            $table->index('post_id');
            $table->index('post_category_id');
        });
        
        // 移除新的欄位
        Schema::table('post_relation', function (Blueprint $table) {
            $table->dropIndex(['post_slug', 'locale']);
            $table->dropIndex(['post_category_slug', 'locale']);
            $table->dropColumn(['locale', 'post_slug', 'post_category_slug']);
        });
    }
};
