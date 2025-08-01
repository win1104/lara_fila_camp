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
        Schema::create('product_downloads', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default('tw');
            $table->string('slug')->default('download');
            $table->string('parent_slug')->default('download');
            $table->string('type')->default('post');
            $table->string('title')->nullable();
            $table->integer('order')->default(1);
            $table->boolean('display')->default('0');
            $table->text('note')->nullable();
            $table->string('fixuser')->nullable();
            $table->timestamps();
            $table->unique(['locale', 'slug']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_downloads');
    }
};
