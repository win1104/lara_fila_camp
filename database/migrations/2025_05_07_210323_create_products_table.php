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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default('tw');
            // $table->string('category_slug')->default('home');
            // $table->foreign(['locale', 'category_slug'])
            //     ->references(['locale', 'slug'])
            //     ->on('product_categories')
            //     ->onDelete('cascade')
            //     ->onUpdate('cascade');
            $table->string('slug')->default('product');
            $table->unique(['locale', 'slug']);
            $table->string('title');
            $table->string('tag')->nullable();
            $table->integer('order')->default('1');
            $table->boolean('display')->default('0');
            $table->string('date')->nullable();
            $table->string('url')->nullable();
            $table->boolean('url_target')->nullable();
            $table->string('image')->nullable();
            $table->longText('info')->nullable();
            $table->longText('intro')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('check')->default('0')->nullable();
            $table->string('status')->nullable();
            $table->string('fixuser')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
