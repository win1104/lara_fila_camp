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
        Schema::create('products_attributes', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->default('tw');
            $table->string('slug')->default('home');
            $table->string('name');
            $table->string('type');
            $table->integer('order')->default('1');
            $table->boolean('display')->default('0');
            $table->string('date')->nullable();
            $table->text('description')->nullable();


            $table->foreignId('product_slug')
                ->constrained('products')
                ->cascadeOnDelete();

            $table->foreignId('creator_id')
                ->nullable()
                ->constrained('admins')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_attributes');
    }
};
