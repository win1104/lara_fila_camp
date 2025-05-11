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
        Schema::table('articles', function (Blueprint $table) {
            // 添加 sort 欄位（數字類型，可為空）
            $table->integer('sort')->default(1)->after('slug');;

            // 添加 tag 欄位（字串類型，可為空）
            $table->string('tag')->nullable()->after('sort')->index();

            // 添加 data 欄位（字串類型，可為空）
            $table->string('date')->nullable()->after('tag');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            // 回滾時移除添加的欄位
            $table->dropColumn(['sort', 'tag', 'data']);
        });
    }
};
