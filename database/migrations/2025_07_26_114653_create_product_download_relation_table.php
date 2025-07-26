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
        Schema::create('product_download_relation', function (Blueprint $table) {
            $table->id();
            $table->string('product_slug');
            $table->string('product_download_slug');
            $table->string('locale')->default('tw');
            $table->timestamps();

            // 建立複合索引
            $table->index(['product_slug', 'product_download_slug', 'locale'], 'pdr_composite_index');
            $table->index('product_slug', 'pdr_product_slug_index');
            $table->index('product_download_slug', 'pdr_download_slug_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_download_relation');
    }
};
