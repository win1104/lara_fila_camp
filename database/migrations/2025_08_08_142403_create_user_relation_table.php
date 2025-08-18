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
        Schema::create('user_relation', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->string('user_slug');
            $table->string('user_category_slug');
            $table->timestamps();

            // 建立索引
            $table->index(['user_slug', 'locale']);
            $table->index(['user_category_slug', 'locale']);
            $table->index(['user_slug', 'user_category_slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_relation');
    }
};
