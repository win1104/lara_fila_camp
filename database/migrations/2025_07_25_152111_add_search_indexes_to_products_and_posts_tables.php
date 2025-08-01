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
        // 為 products 表添加搜尋用複合索引
        Schema::table('products', function (Blueprint $table) {
            // 複合索引：locale + display + title (用於全域搜尋)
            $table->index(['locale', 'display', 'title'], 'idx_products_search');
            // 複合索引：locale + slug (用於 slug 搜尋)
            $table->index(['locale', 'slug'], 'idx_products_slug');
            // 單一索引：title (用於標題搜尋)
            $table->index('title', 'idx_products_title');
        });

        // 為 posts 表添加搜尋用複合索引
        Schema::table('posts', function (Blueprint $table) {
            // 複合索引：locale + display + title (用於全域搜尋)
            $table->index(['locale', 'display', 'title'], 'idx_posts_search');
            // 複合索引：locale + slug (用於 slug 搜尋)
            $table->index(['locale', 'slug'], 'idx_posts_slug');
            // 單一索引：title (用於標題搜尋)
            $table->index('title', 'idx_posts_title');
        });

        // 為 projects 表添加搜尋用複合索引
        Schema::table('projects', function (Blueprint $table) {
            // 複合索引：locale + display + title (用於全域搜尋)
            $table->index(['locale', 'display', 'title'], 'idx_projects_search');
            // 複合索引：locale + slug (用於 slug 搜尋)
            $table->index(['locale', 'slug'], 'idx_projects_slug');
            // 單一索引：title (用於標題搜尋)
            $table->index('title', 'idx_projects_title');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 移除 products 表的索引
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex('idx_products_search');
            $table->dropIndex('idx_products_slug');
            $table->dropIndex('idx_products_title');
        });

        // 移除 posts 表的索引
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex('idx_posts_search');
            $table->dropIndex('idx_posts_slug');
            $table->dropIndex('idx_posts_title');
        });

        // 移除 poprojectssts 表的索引
        Schema::table('projects', function (Blueprint $table) {
            $table->dropIndex('idx_projects_search');
            $table->dropIndex('idx_projects_slug');
            $table->dropIndex('idx_projects_title');
        });
    }
};
