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
        Schema::create('product_tag_relations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default('tw');
            $table->string('product_slug');
            $table->string('product_tag_slug');
            $table->timestamps();

            // 建立索引
            $table->index(['product_slug', 'locale']);
            $table->index(['product_tag_slug', 'locale']);
            $table->index(['product_slug', 'product_tag_slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_tag_relations');
    }
};
