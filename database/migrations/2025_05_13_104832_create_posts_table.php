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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
            $table->string('menu_slug', 255)->default('about');
            // $table->foreign('menu_slug')->references('menu_slug')->on('menus')->onUpdate('cascade')->onDelete('cascade');
            $table->string('slug', 255)->default('about');
            $table->string('title', 255);
            $table->string('tag', 255)->nullable();
            $table->integer('sort')->default('1');
            $table->boolean('display')->default('0');
            $table->string('date', 255)->nullable();
            $table->string('url', 255)->nullable();
            $table->boolean('url_target')->nullable();
            $table->string('image', 255)->nullable();
            $table->longText('info')->nullable();
            $table->longText('intro')->nullable();
            $table->longText('content')->nullable();
            $table->boolean('check')->default('0')->nullable();
            $table->string('fixuser', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
