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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default('tw');
            $table->string('slug')->default('home');
            $table->string('parent_slug')->default('home');
            $table->string('type')->default('post');
            $table->string('title', 2048);
            $table->integer('order')->default(1);
            $table->boolean('display')->default('0');
            $table->string('url')->nullable();
            $table->boolean('url_target')->default('0');
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
        Schema::dropIfExists('menus');
    }
};
