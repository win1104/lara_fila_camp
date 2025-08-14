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
        Schema::create('user_tags', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default('tw');
            $table->string('slug');
            $table->string('title');
            $table->integer('order')->default('1');
            $table->boolean('display')->default('0');
            $table->string('color')->nullable();
            $table->text('note')->nullable();
            $table->unsignedBigInteger('creator_id')->nullable();
            $table->timestamps();

            // 建立複合索引
            $table->unique(['locale', 'slug']);
            $table->foreign('creator_id')->references('id')->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_tags');
    }
};
