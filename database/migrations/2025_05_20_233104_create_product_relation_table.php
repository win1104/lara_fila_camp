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
        Schema::create('product_relation', function (Blueprint $table) {
            $table->id();
            $table->string('product_slug');
            $table->string('product_category_slug');
            $table->string('locale')->default('tw');
            $table->timestamps();

            // 建立複合索引
            $table->index(['product_slug', 'product_category_slug', 'locale']);
            $table->index('product_slug');
            $table->index('product_category_slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_relation');
    }
};
